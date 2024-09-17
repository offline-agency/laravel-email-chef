<?php

namespace OfflineAgency\LaravelEmailChef\Tests\Feature\Resources;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use OfflineAgency\LaravelEmailChef\Api\Resources\ListsApi;
use OfflineAgency\LaravelEmailChef\Entities\Lists\ContactList;
use OfflineAgency\LaravelEmailChef\Entities\Lists\GetCollection;
use OfflineAgency\LaravelEmailChef\Entities\Lists\GetInstance;
use OfflineAgency\LaravelEmailChef\Entities\Lists\GetStats;
use OfflineAgency\LaravelEmailChef\Entities\Lists\UpdateList;
use OfflineAgency\LaravelEmailChef\Tests\TestCase;

class ListsTest extends TestCase
{
    public function test_get_collection()
    {
        $list = new ListsApi;

        $response = $list->getCollection(
            10,
            0,
            'n',
            'a'
        );

        $contact = $response->first();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertInstanceOf(GetCollection::class, $contact);
        $this->assertIsString($contact->name);
        $this->assertIsString($contact->id);
        $this->assertIsString($contact->description);
        $this->assertInstanceOf(Carbon::class, $contact->date);
        $this->assertIsString($contact->active);
        $this->assertIsString($contact->subscribed);
        $this->assertIsString($contact->unsubscribed);
        $this->assertIsString($contact->bounced);
        $this->assertIsString($contact->reported);
        $this->assertIsString($contact->segments);
        $this->assertIsInt($contact->forms);
    }

    public function test_get_instance()
    {
        $list = new ListsApi();

        $response = $list->getInstance(
            config('email-chef.list_id'),
        );

        $this->assertInstanceOf(GetInstance::class, $response);
        $this->assertIsString($response->name);
        $this->assertIsString($response->description);
    }

    public function test_get_stats()
    {
        $list = new ListsApi();

        $response = $list->getStats(
            '97322',
            '2023-01-01',
            '2023-06-10'
        );

        $this->assertInstanceOf(GetStats::class, $response);
        $this->assertIsArray($response->total_list);
        $this->assertIsArray($response->daily_delta_list);
        $this->assertIsString($response->start_date);
        $this->assertIsString($response->last_date);
    }

    public function test_unsubscribe()
    {
        $list = new ListsApi();

        $response = $list->unsubscribe(
            '97322',
            '53998920'
        );

        $this->assertIsString($response);
    }

    public function test_create()
    {
        $list = new ListsApi();

        $response = $list->create([
            'list_name' => 'OA run test 2',
            'list_description' => 'Test di creazione lista tramite API',
        ]);

        $this->assertInstanceOf(ContactList::class, $response);
        $this->assertIsObject($response);
    }

    public function test_update()
    {
        $this->markTestIncomplete(); //remove this after changing the parameters on the update method below
        $list = new ListsApi();

        $response = $list->update('123246', [
            'list_name' => 'Lista personalizzata OA',
            'list_description' => 'Test di modifica per lista',
        ]
        );

        $this->assertInstanceOf(UpdateList::class, $response);
        $this->assertIsString($response->list_id);
    }

    public function test_delete()
    {
        $list = new ListsApi();

        $response = $list->create([
            'list_name' => 'OA run test 3',
            'list_description' => 'Test di creazione lista tramite API',
        ]);

        $response = $list->delete($response->list_id);

        $this->assertIsString($response);
    }
}
