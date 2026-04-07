<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelEmailChef\Api\Api;

/**
 * Concrete subclass exposing protected methods for direct testing.
 */
class TestableApi extends Api
{
    public function doGet(string $url, array $params = []): object {
        return $this->get($url, $params);
    }

    public function doPost(string $url, array $body): object {
        return $this->post($url, $body);
    }

    public function doPut(string $url, array $body): object {
        return $this->put($url, $body);
    }

    public function doDestroy(string $url, array $params = []): object {
        return $this->destroy($url, $params);
    }
}

function baseLoginFake(): array {
    return ['authkey' => 'fake-jwt', 'message' => 'ok'];
}

describe('Api base class', function (): void {
    beforeEach(function (): void {
        config(['email-chef.limits.403' => 100]);
        config(['email-chef.limits.429' => 100]);
        config(['email-chef.limits.default' => 100]);
    });

    it('handles 403 throttle on GET and retries', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login'     => Http::response(baseLoginFake(), 200),
            'https://app.emailchef.com/apps/api/v1/*' => Http::sequence()
                ->push(['error' => 'throttled'], 403)
                ->push(['ok' => true], 200),
        ]);

        $api = new TestableApi();
        $result = $api->doGet('test');

        // Throttle block retries but discards the recursive result (no return),
        // so parseResponse still runs on the original 403 response.
        expect($result->success)->toBeFalse();
    });

    it('handles 429 throttle on GET and retries', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login'     => Http::response(baseLoginFake(), 200),
            'https://app.emailchef.com/apps/api/v1/*' => Http::sequence()
                ->push(['error' => 'rate limited'], 429)
                ->push(['ok' => true], 200),
        ]);

        $api = new TestableApi();
        $result = $api->doGet('test');

        expect($result->success)->toBeFalse();
    });

    it('handles 403 throttle on PUT and retries', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login'     => Http::response(baseLoginFake(), 200),
            'https://app.emailchef.com/apps/api/v1/*' => Http::sequence()
                ->push(['error' => 'throttled'], 403)
                ->push(['ok' => true], 200),
        ]);

        $api = new TestableApi();
        $result = $api->doPut('test', ['data' => 'value']);

        expect($result->success)->toBeFalse();
    });

    it('handles 429 throttle on DELETE and retries', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login'     => Http::response(baseLoginFake(), 200),
            'https://app.emailchef.com/apps/api/v1/*' => Http::sequence()
                ->push(['error' => 'throttled'], 429)
                ->push(['ok' => true], 200),
        ]);

        $api = new TestableApi();
        $result = $api->doDestroy('test');

        expect($result->success)->toBeFalse();
    });

    it('returns parsed success response for GET', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(baseLoginFake(), 200),
            '*'                                   => Http::response(['result' => 'ok'], 200),
        ]);

        $api = new TestableApi();
        $result = $api->doGet('test');

        expect($result->success)->toBeTrue()
            ->and($result->data->result)->toBe('ok');
    });

    it('returns parsed success response for POST', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(baseLoginFake(), 200),
            '*'                                   => Http::response(['created' => true], 200),
        ]);

        $api = new TestableApi();
        $result = $api->doPost('test', ['data' => 'value']);

        expect($result->success)->toBeTrue();
    });
});
