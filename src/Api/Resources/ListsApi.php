<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Api\Resources;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use OfflineAgency\LaravelEmailChef\Api\Api;
use OfflineAgency\LaravelEmailChef\Entities\Error;
use OfflineAgency\LaravelEmailChef\Entities\Lists\ContactList;
use OfflineAgency\LaravelEmailChef\Entities\Lists\GetCollection;
use OfflineAgency\LaravelEmailChef\Entities\Lists\GetInstance;
use OfflineAgency\LaravelEmailChef\Entities\Lists\GetStats;
use OfflineAgency\LaravelEmailChef\Entities\Lists\UpdateList;

final class ListsApi extends Api
{
    public function getCollection(
        ?int $limit,
        ?int $offset,
        ?string $orderby,
        ?string $order_type,
    ): mixed {
        $response = $this->get('lists?limit='.$limit.'&offset='.$offset.'&orderby='.$orderby.'&ordertype='.$order_type, [
            'limit'      => $limit,
            'offset'     => $offset,
            'orderby'    => $orderby,
            'order_type' => $order_type,
        ]);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $collections = $response->data;

        $out = collect();

        foreach ($collections as $collection) {
            $collection->date = Carbon::parse($collection->date);
            $out->push(GetCollection::fromResponse($collection));
        }

        return $out;
    }

    public function getInstance(
        string $id,
    ): mixed {
        $response = $this->get('lists/'.$id, [
            'id' => $id,
        ]);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $list = $response->data;

        return GetInstance::fromResponse($list);
    }

    public function getStats(
        string $list_id,
        string $start_date,
        string $end_date,
    ): mixed {
        $response = $this->get('lists/'.$list_id.'/stats?start_date='.$start_date.'&end_date='.$end_date, [
            'start_date' => $start_date,
            'end_date'   => $end_date,
        ]);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $stats = $response->data;

        return GetStats::fromResponse($stats);
    }

    public function unsubscribe(
        string $list_id,
        string $contact_id,
    ): mixed {
        $response = $this->get('lists/'.$list_id.'/unsubscribe?contact_id='.$contact_id.'$contact_idlist_id='.$list_id, [
            'contact_id' => $contact_id,
            'list_id'    => $list_id,
        ]);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        // this endpoint does not return response
        /* $result = $response->data; */

        return 'Actually Contact #'.$contact_id.' is not in your list';
    }

    /**
     * @param array<string, mixed> $instance_in
     */
    public function create(
        array $instance_in = [],
    ): mixed {
        $validator = Validator::make($instance_in, [
            'list_name'        => 'required',
            'list_description' => 'string',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post('lists', [
            'instance_in' => $instance_in,
        ]);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $list = $response->data;

        return ContactList::fromResponse($list);
    }

    /**
     * @param array<string, mixed> $instance_in
     */
    public function update(
        string $list_id,
        array $instance_in = [],
    ): mixed {
        $validator = Validator::make($instance_in, [
            'list_name'        => 'required',
            'list_description' => 'string',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->put('lists/'.$list_id, [
            'instance_in' => $instance_in,
        ]);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $list = $response->data;

        return UpdateList::fromResponse($list);
    }

    public function delete(
        string $list_id,
    ): mixed {
        $response = $this->destroy('lists/'.$list_id);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        return 'List #'.$list_id.' deleted';
    }

    public function subscribe(
        string $list_id,
        string $contact_id,
    ): ContactList|Error {
        $response = $this->post('lists/'.$list_id.'/subscribe', [
            'contact_id' => $contact_id,
            'list_id'    => $list_id,
        ]);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        return ContactList::fromResponse($response->data);
    }
}
