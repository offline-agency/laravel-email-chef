<?php

namespace OfflineAgency\LaravelEmailChef\Api\Resources;

use Illuminate\Support\Facades\Validator;
use OfflineAgency\LaravelEmailChef\Api\Api;
use OfflineAgency\LaravelEmailChef\Entities\Contacts\CountContactEntity;
use OfflineAgency\LaravelEmailChef\Entities\Contacts\CreatedContactEntity;
use OfflineAgency\LaravelEmailChef\Entities\Contacts\GetCollection;
use OfflineAgency\LaravelEmailChef\Entities\Contacts\GetInstance;
use OfflineAgency\LaravelEmailChef\Entities\Contacts\UpdatedContactEntity;
use OfflineAgency\LaravelEmailChef\Entities\Error;

class ContactsApi extends Api
{
    public function count(
        string $list_id
    ) {
        $response = $this->get('lists/'.$list_id.'/contacts/count', [
            'list_id' => $list_id,
        ]);

        if (! $response->success) {
            return new Error($response->data);
        }

        $count = $response->data;

        return new CountContactEntity($count);
    }

    public function getCollection(
        string $status,
        string $list_id,
        ?int $limit,
        ?int $offset,
        ?string $order_by,
        ?string $order_type
    ) {
        $response = $this->get('contact?status='.$status.'&limit='.$limit.'&list_id='.$list_id.'&offset='.$offset.'&orderby='.$order_by.'&ordertype='.$order_type, [
            'status' => $status,
            'list_id' => $list_id,
            'limit' => $limit,
            'offset' => $offset,
            'order_by' => $order_by,
            'order_type' => $order_type,
        ]);

        if (! $response->success) {
            return new Error($response->data);
        }

        $collections = $response->data;
        // dd(gettype($collection)); //ERROR: $collection è un array, dovrebbe essere un object <-- controllare tutte le chiamate in get
        $out = collect();
        foreach ($collections as $collection) {
            $out->push(new GetCollection($collection));
        }

        return $out;
    }

    public function getInstance(
        string $contact_id,
        string $list_id
    ) {
        $response = $this->get('contacts/'.$contact_id.'?list_id='.$list_id, [
            'contact_id' => $contact_id,
            'list_id' => $list_id,
        ]);

        if (! $response->success) {
            return new Error($response->data);
        }

        $contact = $response->data;

        return new GetInstance($contact);
    }

    public function create(
        array $instance_in = [],
        string $mode = 'ADMIN'
    ) {
        $validator = Validator::make($instance_in, [
            'list_id' => 'required',
            'status' => 'string',
            'email' => 'required',
            'firstname' => 'string',
            'lastname' => 'string',
            'custom_fields' => '',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post('contacts', [
            'instance_in' => array_merge($instance_in, [
                'mode' => $mode,
            ]),
        ]);

        if (! $response->success) {
            return new Error($response->data);
        }

        $contact = $response->data;

        return new CreatedContactEntity($contact);
    }

    public function update(
        string $contact_id,
        array $instance_in = [],
        string $mode = 'ADMIN'
    ) {
        $response = $this->put('contact/'.$contact_id, [
            'instance_in' => array_merge($instance_in, [
                'mode' => $mode,
            ]),
        ]);

        if (! $response->success) {
            return new Error($response->data);
        }

        $contact = $response->data;

        return new UpdatedContactEntity($contact); //to implement
    }
}
