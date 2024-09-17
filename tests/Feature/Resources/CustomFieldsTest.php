<?php

namespace OfflineAgency\LaravelEmailChef\Tests\Feature\Resources;

use Illuminate\Support\Collection;
use OfflineAgency\LaravelEmailChef\Api\Resources\CustomFieldsApi;
use OfflineAgency\LaravelEmailChef\Entities\CustomFields\CountCustomFieldsEntity;
use OfflineAgency\LaravelEmailChef\Entities\CustomFields\CreatedCustomFieldsEntity;
use OfflineAgency\LaravelEmailChef\Entities\CustomFields\GetCollection;
use OfflineAgency\LaravelEmailChef\Entities\CustomFields\GetInstance;
use OfflineAgency\LaravelEmailChef\Entities\CustomFields\UpdatedCustomFieldsEntity;
use OfflineAgency\LaravelEmailChef\Tests\TestCase;

class CustomFieldsTest extends TestCase
{
    public function test_get_collection()//todo: check this method
    {
        $custom_fields = new CustomFieldsApi;

        $response = $custom_fields->getCollection(
            108094
        );

        $custom_field = $response->first();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertInstanceOf(GetCollection::class, $custom_field);
        $this->assertIsString($custom_field->id);
        $this->assertIsString($custom_field->list_id);
        $this->assertIsString($custom_field->name);
        $this->assertIsString($custom_field->type_id);
        $this->assertIsString($custom_field->place_holder);
        $this->assertIsString($custom_field->default_value);
        $this->assertIsString($custom_field->admin_only);
        $this->assertIsString($custom_field->data_type);
    }

    public function test_get_instance()
    {
        $custom_fields = new CustomFieldsApi;

        $response = $custom_fields->getInstance(
            '170972'
        );

        $this->assertInstanceOf(GetInstance::class, $response);
        $this->assertIsString($response->id);
        $this->assertIsString($response->list_id);
        $this->assertIsString($response->name);
        $this->assertIsString($response->type_id);
        $this->assertIsString($response->place_holder);
        $this->assertIsString($response->default_value);
        $this->assertIsString($response->admin_only);
        $this->assertIsString($response->data_type);
    }

    public function test_get_count()
    {
        $custom_fields = new CustomFieldsApi;

        $response = $custom_fields->count(
            108094
        );

        $this->assertInstanceOf(CountCustomFieldsEntity::class, $response);
        $this->assertIsString($response->totalcount);
    }

    public function test_create()
    {
        $this->markTestIncomplete(); //remove this after changing the parameters on the update method below

        $custom_fields = new CustomFieldsApi();

        $response = $custom_fields->create(
            '108094',
            [
                'data_type' => 'string',
                'name' => 'Smartphone4',
                'place_holder' => 'smartphone4',
                'default_value' => '1',
            ]
        );

        $this->assertInstanceOf(CreatedCustomFieldsEntity::class, $response);
        $this->assertIsString($response->custom_field_id);
    }

    public function test_update()
    {
        $this->markTestIncomplete(); //remove this after changing the parameters on the update method below

        $custom_fields = new CustomFieldsApi();

        $response = $custom_fields->update(
            '170972',
            [
                'list_id' => '108094',
                'name' => 'Smartphone6',
                'type_id' => '4',
                'place_holder' => 'smartphone6',
                'default_value' => '1',
                'admin_only' => '0',
                'data_type' => 'string',
            ]
        );

        $this->assertInstanceOf(UpdatedCustomFieldsEntity::class, $response);
        $this->assertIsString($response->custom_field_id);
    }

    public function test_delete()
    {
        $custom_fields = new CustomFieldsApi();

        $response = $custom_fields->create(
            108094,
            [
                'data_type' => 'boolean',
                'name' => 'Smartphone1',
                'place_holder' => 'smartphone1',
                'default_value' => '1',
            ]
        );

        $response = $custom_fields->delete($response->custom_field_id);

        $this->assertIsString($response);
    }
}
