<?php

namespace OfflineAgency\LaravelEmailChef\Tests\Feature\Resources;

use OfflineAgency\LaravelEmailChef\Api\Resources\SegmentsApi;
use OfflineAgency\LaravelEmailChef\Entities\Segments\ContactsCount;
use OfflineAgency\LaravelEmailChef\Entities\Segments\CreateSegment;
use OfflineAgency\LaravelEmailChef\Entities\Segments\Segment;
use OfflineAgency\LaravelEmailChef\Entities\Segments\SegmentCollection;
use OfflineAgency\LaravelEmailChef\Entities\Segments\SegmentCount;
use OfflineAgency\LaravelEmailChef\Entities\Segments\SegmentDeletion;
use OfflineAgency\LaravelEmailChef\Entities\Segments\UpdateSegment;
use OfflineAgency\LaravelEmailChef\Tests\TestCase;

class SegmentsTest extends TestCase
{
    public function test_get_collection()
    {
        $segment = new SegmentsApi;

        $response = $segment->getCollection(
            '108094',
            10,
            0,
        );

        $single_segment = $response->first();
        $this->assertInstanceOf(SegmentCollection::class, $single_segment);
    }

    public function test_get_instance()
    {
        $segment = new SegmentsApi;

        $response = $segment->getInstance(
            '73986'
        );

        $this->assertInstanceOf(Segment::class, $response);
        $this->assertIsString($response->id);
        $this->assertIsString($response->list_id);
        $this->assertIsString($response->logic);
        $this->assertIsArray($response->condition_groups);
        $this->assertIsString($response->name);
        $this->assertIsString($response->description);
    }

    public function test_get_count()
    {
        $segment = new SegmentsApi;

        $response = $segment->getCount(
            '108094'
        );

        $this->assertInstanceOf(SegmentCount::class, $response);
        $this->assertIsString($response->totalcount);
    }

    public function test_get_contacts_count()
    {
        $segment = new SegmentsApi;

        $response = $segment->getContactsCount(
            '73986'
        );

        $this->assertInstanceOf(ContactsCount::class, $response);
        $this->assertIsString($response->match_count);
        $this->assertIsString($response->total_count);
    }

    public function test_create_instance()
    {
        $segment = new SegmentsApi;
        $list_id = '108094';

        $response = $segment->createInstance($list_id, [
            'instance_in' => [
                'list_id' => '108094',
                'logic' => 'AND',
                'condition_groups' => [
                    [
                        'logic' => 'AND',
                        'conditions' => [
                            [
                                'comparable_id' => null,
                                'comparator_id' => '1',
                                'field_id' => '-1',
                                'name' => 'email',
                                'value' => 'cognomenome@gmail.com',
                            ],
                        ],
                    ],
                ],
                'description' => 'description',
                'id' => null,
                'name' => 'segment',
            ],
        ]);

        //dd($response);

        $this->assertInstanceOf(CreateSegment::class, $response);
    }

    public function test_update_instance()
    {
        $segment = new SegmentsApi;

        $response = $segment->updateInstance(
            '108094',
            '74006',
            [
                'instance_in' => [
                    'list_id' => '108094',
                    'logic' => 'AND',
                    'condition_groups' => [
                        [
                            'logic' => 'AND',
                            'conditions' => [
                                [
                                    'comparable_id' => null,
                                    'comparator_id' => '1',
                                    'field_id' => '-1',
                                    'name' => 'email',
                                    'value' => 'cognomenome@gmail.com',
                                ],
                            ],
                        ],
                    ],
                    'description' => 'updated description',
                    'id' => null,
                    'name' => 'updated name',
                ],
            ]
        );

        $this->assertInstanceOf(UpdateSegment::class, $response);
    }

    public function test_delete_instance()
    {
        $this->markTestIncomplete();
        $segment = new SegmentsApi;

        $response = $segment->deleteInstance(
            '74106'
        );

        $this->assertInstanceOf(SegmentDeletion::class, $response);
    }
}
