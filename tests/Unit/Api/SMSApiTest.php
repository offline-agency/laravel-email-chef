<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelEmailChef\Api\Resources\SMSApi;
use OfflineAgency\LaravelEmailChef\Entities\Error;
use OfflineAgency\LaravelEmailChef\Entities\SMS\Balance;
use OfflineAgency\LaravelEmailChef\Entities\SMS\BulkMessageStatus;
use OfflineAgency\LaravelEmailChef\Entities\SMS\Send;
use OfflineAgency\LaravelEmailChef\Entities\SMS\StatusMessage;

function smsLoginFake(): array {
    return ['authkey' => 'fake-jwt', 'message' => 'ok'];
}

describe('SMSApi', function (): void {
    it('returns a Send entity for send()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(smsLoginFake(), 200),
            '*'                                   => Http::response(['message_id' => 'sms-123'], 200),
        ]);

        $result = (new SMSApi())->send([
            'to'   => '+39 333 1234567',
            'text' => 'Your code is 4821.',
        ]);

        expect($result)->toBeInstanceOf(Send::class);

        Http::assertSent(static fn ($req) => $req->method() === 'POST' && str_contains($req->url(), 'sms/send'));
    });

    it('returns a Balance entity for getBalance()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(smsLoginFake(), 200),
            '*'                                   => Http::response(['credits' => '500'], 200),
        ]);

        $result = (new SMSApi())->getBalance();

        expect($result)->toBeInstanceOf(Balance::class);

        Http::assertSent(static fn ($req) => str_contains($req->url(), 'sms/balance'));
    });

    it('returns a StatusMessage entity for getStatusMessage()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(smsLoginFake(), 200),
            '*'                                   => Http::response(['status' => 'delivered'], 200),
        ]);

        $result = (new SMSApi())->getStatusMessage('sms-123');

        expect($result)->toBeInstanceOf(StatusMessage::class);

        Http::assertSent(static fn ($req) => str_contains($req->url(), 'sms/status/sms-123'));
    });

    it('returns a BulkMessageStatus entity for getBulkMessageStatus()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(smsLoginFake(), 200),
            '*'                                   => Http::response(['bulk_id' => 'bulk-1', 'status' => 'done'], 200),
        ]);

        $result = (new SMSApi())->getBulkMessageStatus('bulk-1');

        expect($result)->toBeInstanceOf(BulkMessageStatus::class);

        Http::assertSent(static fn ($req) => str_contains($req->url(), 'sms/bulk/status/bulk-1'));
    });

    it('returns an Error for non-200 responses', function (int $status): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(smsLoginFake(), 200),
            '*'                                   => Http::response(['error' => ['message' => 'Server error']], $status),
        ]);

        expect((new SMSApi())->getBalance())->toBeInstanceOf(Error::class);
    })->with([401, 404, 500]);
});
