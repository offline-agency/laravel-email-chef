<?php

namespace OfflineAgency\LaravelEmailChef\Tests\Feature\Resources;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelEmailChef\Api\Resources\ContactsApi;
use OfflineAgency\LaravelEmailChef\Entities\Contacts\ContactsEntity;
use OfflineAgency\LaravelEmailChef\Entities\Contacts\CountContactEntity;
use OfflineAgency\LaravelEmailChef\Entities\Contacts\CreatedContactEntity;
use OfflineAgency\LaravelEmailChef\Entities\Contacts\GetCollection;
use OfflineAgency\LaravelEmailChef\Entities\Contacts\GetInstance;
use OfflineAgency\LaravelEmailChef\Tests\TestCase;

class ContactsTest extends TestCase
{
    public function test_simple_callback()
    {
        $result = Http::withHeaders([
            'Accept' => 'application/json; charset=utf-8',
        ])->post('https://app.emailchef.com/api/'.'login', [
            'username' => config('email-chef.username'),
            'password' => config('email-chef.password'),
        ]);

        $result_body = json_decode($result->body());

        $response = Http::withHeaders([
            'authkey' => $result_body->authkey,
            'Accept' => 'application/json; charset=utf-8',
        ])->post('https://app.emailchef.com/apps/api/v1/contacts', [
            'instance_in' => [
                'list_id' => 97322,
                'status ' => 'ACTIVE',
                'email' => 'ciao@gmail.com',
                'firstname' => 'Mario',
                'lastname' => 'Rossi',
                'custom_fields' => [
                    [
                        'test' => 'OK',
                    ],
                ],
                'mode' => 'ADMIN',
            ],
        ]);

        $this->assertEquals(200, $response->status());
    }

    public function test_get_count()
    {
        $contacts = new ContactsApi;

        $response = $contacts->count(config('email-chef.list_id'));

        $this->assertInstanceOf(CountContactEntity::class, $response);
        $this->assertIsString($response->active);
        $this->assertIsString($response->unsubscribed);
        $this->assertIsString($response->bounced);
        $this->assertIsString($response->reported);
    }

    /**
     * status: ACTIVE, UNSUBSCRIBED, BOUNCED, REPORTED
     * list_id
     * limit: number of results to return for a single page (default = 10)
     * offset: number of results to skip prior to start considering results to return (default = 0)
     * orderby: e (email), n (name), ab (added_by), s (status), at (addition_time)(default = at)
     * ordertype: a (ascending), d (descending) (default = d).
     */
    public function test_get_collection()
    {
        $contacts = new ContactsApi;

        $response = $contacts->getCollection(
            'ACTIVE',
            config('email-chef.list_id'),
            null,
            null,
            null,
            null
        );

        $contact = $response->first();
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertInstanceOf(GetCollection::class, $contact);
        $this->assertIsString($contact->status);
        $this->assertIsString($contact->email);
        $this->assertIsString($contact->firstname);
        $this->assertIsString($contact->lastname);
    }

    public function test_get_instance()
    {
        $contacts = new ContactsApi;

        $response = $contacts->getInstance(
            config('email-chef.contact_id'),
            config('email-chef.list_id')
        );

        $this->assertInstanceOf(GetInstance::class, $response);
        $this->assertIsString($response->status);
        $this->assertIsString($response->email);
        $this->assertIsString($response->firstname);
        $this->assertIsString($response->lastname);
        $this->assertIsString($response->ip);
        $this->assertIsString($response->country);
        $this->assertIsString($response->city);
        $this->assertIsString($response->added_by);
        $this->assertIsString($response->addition_time);
        $this->assertIsBool($response->privacy_accepted);
        $this->assertIsBool($response->terms_accepted);
        $this->assertIsBool($response->newsletter_accepted);
        $this->assertIsBool($response->blacklisted);
        $this->assertIsArray($response->customFields);
        $this->assertIsInt($response->rating);
    }

    public function test_create()
    {
        $contacts = new ContactsApi;

        $response = $contacts->create([
            'list_id' => config('email-chef.list_id'),
            'status ' => 'ACTIVE',
            'email' => 'user12354@gmail.com',
            'firstname' => 'Riccardo',
            'lastname' => 'Agostini',
            'custom_fields' => [[
                'test' => 'OK',
            ]],
        ]);

        $this->assertInstanceOf(CreatedContactEntity::class, $response);
        $this->assertIsBool($response->contact_added_to_list);
        $this->assertIsString($response->contact_id);
        $this->assertIsString($response->contact_status);
        $this->assertIsBool($response->updated);
    }

    public function test_update()
    {
        $this->markTestIncomplete();
        $contacts = new ContactsApi;

        $response = $contacts->update('656023', [
            'list_id' => config('email-chef.list_id'),
            'status ' => 'ACTIVE',
            'email' => 'mario.rossi@gmail.com',
            'firstname' => 'Mario',
            'lastname' => 'Rossi',
            'custom_fields' => [[
                'test' => 'OK',
            ]],
        ]
        );

        $this->assertInstanceOf(ContactsEntity::class, $response);
    }
}
