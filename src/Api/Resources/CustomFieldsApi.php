<?php

namespace OfflineAgency\LaravelEmailChef\Api\Resources;

use Illuminate\Support\Facades\Validator;
use OfflineAgency\LaravelEmailChef\Api\Api;
use OfflineAgency\LaravelEmailChef\Entities\CustomFields\CountCustomFieldsEntity;
use OfflineAgency\LaravelEmailChef\Entities\CustomFields\CreatedCustomFieldsEntity;
use OfflineAgency\LaravelEmailChef\Entities\CustomFields\GetCollection;
use OfflineAgency\LaravelEmailChef\Entities\CustomFields\GetInstance;
use OfflineAgency\LaravelEmailChef\Entities\CustomFields\UpdatedCustomFieldsEntity;
use OfflineAgency\LaravelEmailChef\Entities\Error;

class CustomFieldsApi extends Api
{
    public function getCollection(
        string $list_id
    ) {
        $response = $this->get('lists/'.$list_id.'/customfields', [
            'list_id' => $list_id,
        ]);

        if (! $response->success) {
            return new Error($response->data);
        }

        $collection = $response->data;
        // dd(gettype($collection)); //ERROR: $collection è un array, dovrebbe essere un object <-- controllare tutte le chiamate in get
        $out = collect();
        foreach ($collection as $collectionItem) {
            $out->push(new GetCollection($collectionItem));
        }

        return $out;
    }

    public function getInstance(
        string $field_id
    ) {
        $response = $this->get('customfields/'.$field_id, [
            'field_id' => $field_id,
        ]);

        if (! $response->success) {
            return new Error($response->data);
        }

        $customfield = $response->data;

        return new GetInstance($customfield);
    }

    public function count(
        string $list_id
    ) {
        $response = $this->get('lists/'.$list_id.'/customfields/count', [
            'list_id' => $list_id,
        ]);

        if (! $response->success) {
            return new Error($response->data);
        }

        $count = $response->data;

        return new CountCustomFieldsEntity($count);
    }

    public function create(
        string $list_id,
        array $instance_in = []
    ) {
        $validator = Validator::make($instance_in, [
            'data_type' => 'string',
            'name' => 'string',
            'place_holder' => 'string',
            'default_value' => 'integer',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post('lists/'.$list_id.'/customfields', [
            'instance_in' => $instance_in,
        ]);

        if (! $response->success) {
            return new Error($response->data);
        }

        $customfield = $response->data;

        return new CreatedCustomFieldsEntity($customfield);
    }

    public function update(
        string $field_id,
        array $instance_in = []
    ) {
        $validator = Validator::make($instance_in, [
            'list_id' => 'string',
            'name' => 'string',
            'type_id' => 'string',
            'place_holder' => 'string',
            'options' => 'array',
            'default_value' => 'string',
            'admin_only' => 'string',
            'ord' => 'array',
            'data_type' => 'string',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->put('customfields/'.$field_id, [
            'instance_in' => $instance_in,
        ]);

        if (! $response->success) {
            return new Error($response->data);
        }

        $customfield = $response->data;

        return new UpdatedCustomFieldsEntity($customfield);
    }

    public function delete(
        string $field_id
    ) {
        $response = $this->destroy('customfields/'.$field_id);

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'CustomFields #'.$field_id.' deleted';
    }
}
