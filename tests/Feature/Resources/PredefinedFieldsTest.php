<?php

namespace OfflineAgency\LaravelEmailChef\Tests\Feature\Resources;

use Illuminate\Support\Collection;
use OfflineAgency\LaravelEmailChef\Api\Resources\PredefinedFieldsApi;
use OfflineAgency\LaravelEmailChef\Entities\PredefinedFields\PredefinedFieldsEntity;
use OfflineAgency\LaravelEmailChef\Tests\TestCase;

class PredefinedFieldsTest extends TestCase
{
    public function test_get_collection()//todo:check commented lines
    {
        $predefined_fields = new PredefinedFieldsApi();

        $response = $predefined_fields->getCollection();

        $predefined_field = $response->first();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertInstanceOf(PredefinedFieldsEntity::class, $predefined_field);
        $this->assertIsString('predefined_field_id', $predefined_field->id);
        $this->assertIsString('predefined_field', $predefined_field->name);
        $this->assertIsString('predefined_field_id', $predefined_field->type_id);
        $this->assertIsString('predefined_fields', $predefined_field->place_holder);
        $this->assertIsString('predefined_fields', $predefined_field->reference);
        $this->assertIsString('predefined_field_id', $predefined_field->mandatory);
        $this->assertIsString('predefined_fields', $predefined_field->data_type);
    }
}
