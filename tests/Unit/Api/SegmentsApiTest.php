<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelEmailChef\Api\Resources\SegmentsApi;
use OfflineAgency\LaravelEmailChef\Entities\Error;
use OfflineAgency\LaravelEmailChef\Entities\Segments\ContactsCount;
use OfflineAgency\LaravelEmailChef\Entities\Segments\CreateSegment;
use OfflineAgency\LaravelEmailChef\Entities\Segments\Segment;
use OfflineAgency\LaravelEmailChef\Entities\Segments\SegmentCollection;
use OfflineAgency\LaravelEmailChef\Entities\Segments\SegmentCount;
use OfflineAgency\LaravelEmailChef\Entities\Segments\SegmentDeletion;
use OfflineAgency\LaravelEmailChef\Entities\Segments\UpdateSegment;

function segmentsLoginFake(): array {
    return ['authkey' => 'fake-jwt', 'message' => 'ok'];
}

function segmentBody(): array {
    return [
        'instance_in' => [
            'list_id'          => '97322',
            'logic'            => 'AND',
            'name'             => 'Test Segment',
            'description'      => null,
            'id'               => null,
            'condition_groups' => [
                [
                    'logic'      => 'AND',
                    'conditions' => [
                        [
                            'comparable_id' => null,
                            'comparator_id' => 'eq',
                            'field_id'      => 'firstname',
                            'name'          => 'First Name',
                            'value'         => 'John',
                        ],
                    ],
                ],
            ],
        ],
    ];
}

describe('SegmentsApi', function (): void {
    it('returns a Collection of SegmentCollection for getCollection()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(segmentsLoginFake(), 200),
            '*'                                   => Http::response([
                ['id' => '1', 'list_id' => '97322', 'name' => 'Segment 1'],
            ], 200),
        ]);

        $result = (new SegmentsApi())->getCollection('97322', 10, 0);

        expect($result)->toBeInstanceOf(Collection::class)
            ->and($result->first())->toBeInstanceOf(SegmentCollection::class);
    });

    it('returns a Segment entity for getInstance()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(segmentsLoginFake(), 200),
            '*'                                   => Http::response(['id' => '5', 'name' => 'My Segment'], 200),
        ]);

        $result = (new SegmentsApi())->getInstance('5');

        expect($result)->toBeInstanceOf(Segment::class);
    });

    it('returns a SegmentCount entity for getCount()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(segmentsLoginFake(), 200),
            '*'                                   => Http::response(['count' => 3], 200),
        ]);

        $result = (new SegmentsApi())->getCount('97322');

        expect($result)->toBeInstanceOf(SegmentCount::class);
    });

    it('returns a ContactsCount entity for getContactsCount()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(segmentsLoginFake(), 200),
            '*'                                   => Http::response(['match_count' => '10', 'total_count' => '100'], 200),
        ]);

        $result = (new SegmentsApi())->getContactsCount('5');

        expect($result)->toBeInstanceOf(ContactsCount::class);
    });

    it('returns a CreateSegment entity for createInstance()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(segmentsLoginFake(), 200),
            '*'                                   => Http::response(['id' => '20'], 200),
        ]);

        $result = (new SegmentsApi())->createInstance(97_322, segmentBody());

        expect($result)->toBeInstanceOf(CreateSegment::class);

        Http::assertSent(static fn ($req) => $req->method() === 'POST');
    });

    it('returns an UpdateSegment entity for updateInstance()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(segmentsLoginFake(), 200),
            '*'                                   => Http::response(['id' => '20'], 200),
        ]);

        $result = (new SegmentsApi())->updateInstance('97322', '20', segmentBody());

        expect($result)->toBeInstanceOf(UpdateSegment::class);

        Http::assertSent(static fn ($req) => $req->method() === 'PUT');
    });

    it('returns a SegmentDeletion entity for deleteInstance()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(segmentsLoginFake(), 200),
            '*'                                   => Http::response(['deleted' => true], 200),
        ]);

        $result = (new SegmentsApi())->deleteInstance('20');

        expect($result)->toBeInstanceOf(SegmentDeletion::class);

        Http::assertSent(static fn ($req) => $req->method() === 'DELETE');
    });

    it('returns an Error for non-200 responses', function (int $status): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(segmentsLoginFake(), 200),
            '*'                                   => Http::response(['error' => ['message' => 'Server error']], $status),
        ]);

        expect((new SegmentsApi())->getCollection('97322', 10, 0))->toBeInstanceOf(Error::class);
    })->with([401, 404, 500]);
});
