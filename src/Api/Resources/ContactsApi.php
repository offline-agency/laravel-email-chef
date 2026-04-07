<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Api\Resources;

use Illuminate\Support\Facades\Validator;
use OfflineAgency\LaravelEmailChef\Api\Api;
use OfflineAgency\LaravelEmailChef\Entities\Contacts\CountContactEntity;
use OfflineAgency\LaravelEmailChef\Entities\Contacts\CreatedContactEntity;
use OfflineAgency\LaravelEmailChef\Entities\Contacts\GetCollection;
use OfflineAgency\LaravelEmailChef\Entities\Contacts\GetInstance;
use OfflineAgency\LaravelEmailChef\Entities\Contacts\UpdatedContactEntity;
use OfflineAgency\LaravelEmailChef\Entities\Error;

final class ContactsApi extends Api
{
    public function count(
        string $list_id,
    ): mixed {
        $response = $this->get('lists/'.$list_id.'/contacts/count', [
            'list_id' => $list_id,
        ]);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $count = $response->data;

        return CountContactEntity::fromResponse($count);
    }

    public function getCollection(
        string $status,
        string $list_id,
        ?int $limit,
        ?int $offset,
        ?string $order_by,
        ?string $order_type,
    ): mixed {
        $response = $this->get('contact?status='.$status.'&limit='.$limit.'&list_id='.$list_id.'&offset='.$offset.'&orderby='.$order_by.'&ordertype='.$order_type, [
            'status'     => $status,
            'list_id'    => $list_id,
            'limit'      => $limit,
            'offset'     => $offset,
            'order_by'   => $order_by,
            'order_type' => $order_type,
        ]);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $collections = $response->data;
        $out = collect();

        foreach ($collections as $collection) {
            $out->push(GetCollection::fromResponse($collection));
        }

        return $out;
    }

    public function getInstance(
        string $contact_id,
        string $list_id,
    ): mixed {
        $response = $this->get('contacts/'.$contact_id.'?list_id='.$list_id, [
            'contact_id' => $contact_id,
            'list_id'    => $list_id,
        ]);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $contact = $response->data;

        return GetInstance::fromResponse($contact);
    }

    /**
     * @param array<string, mixed> $instance_in
     */
    public function create(
        array $instance_in = [],
        string $mode = 'ADMIN',
    ): mixed {
        $validator = Validator::make($instance_in, [
            'list_id'       => 'required',
            'status'        => 'string',
            'email'         => 'required',
            'firstname'     => 'string',
            'lastname'      => 'string',
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
            return Error::fromResponse($response->data);
        }

        $contact = $response->data;

        return CreatedContactEntity::fromResponse($contact);
    }

    /**
     * @param array<string, mixed> $instance_in
     */
    public function update(
        string $contact_id,
        array $instance_in = [],
        string $mode = 'ADMIN',
    ): mixed {
        $response = $this->put('contacts/'.$contact_id, [
            'instance_in' => array_merge($instance_in, [
                'mode' => $mode,
            ]),
        ]);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $contact = $response->data;

        return UpdatedContactEntity::fromResponse($contact); // to implement
    }

    public function delete(
        string $list_id,
        string $contact_id,
    ): string|Error {
        $response = $this->destroy(
            'lists/'.$list_id.'/contacts/'.$contact_id,
        );

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        return 'Contact #'.$contact_id.' deleted from list #'.$list_id;
    }
}
