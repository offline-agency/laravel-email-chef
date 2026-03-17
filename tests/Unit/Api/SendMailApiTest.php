<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelEmailChef\Api\Resources\SendEmailApi;
use OfflineAgency\LaravelEmailChef\Entities\Error;
use OfflineAgency\LaravelEmailChef\Entities\SendEmail\SendMail;

function sendMailLoginFake(): array {
    return ['authkey' => 'fake-jwt', 'message' => 'ok'];
}

describe('SendEmailApi', function (): void {
    it('returns a SendMail entity on success', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(sendMailLoginFake(), 200),
            '*'                                   => Http::response(['message_id' => 'abc123'], 200),
        ]);

        $result = (new SendEmailApi())->sendMail([
            'to'      => 'customer@example.com',
            'subject' => 'Hello',
            'html'    => '<p>Hi</p>',
        ]);

        expect($result)->toBeInstanceOf(SendMail::class);

        Http::assertSent(static fn ($req) => $req->method() === 'POST' && str_contains($req->url(), 'sendmail'));
    });

    it('returns an Error on non-200 response', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(sendMailLoginFake(), 200),
            '*'                                   => Http::response(['error' => ['message' => 'Server error']], 500),
        ]);

        expect((new SendEmailApi())->sendMail([]))->toBeInstanceOf(Error::class);
    });
});
