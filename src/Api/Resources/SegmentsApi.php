<?php

namespace OfflineAgency\LaravelEmailChef\Api\Resources;

use Illuminate\Support\Facades\Validator;
use OfflineAgency\LaravelEmailChef\Api\Api;
use OfflineAgency\LaravelEmailChef\Entities\Error;
use OfflineAgency\LaravelEmailChef\Entities\Segments\ContactsCount;
use OfflineAgency\LaravelEmailChef\Entities\Segments\CreateSegment;
use OfflineAgency\LaravelEmailChef\Entities\Segments\Segment;
use OfflineAgency\LaravelEmailChef\Entities\Segments\SegmentCollection;
use OfflineAgency\LaravelEmailChef\Entities\Segments\SegmentCount;
use OfflineAgency\LaravelEmailChef\Entities\Segments\SegmentDeletion;
use OfflineAgency\LaravelEmailChef\Entities\Segments\UpdateSegment;

class SegmentsApi extends Api
{
    public function getCollection(
        string $list_id,
        ?int $limit,
        ?int $offset
    ) {
        $response = $this->get('lists/'.$list_id.'/segments?limit='.$limit.'&offset='.$offset, [
            'list_id' => $list_id,
            'limit' => $limit,
            'offset' => $offset,
        ]);

        if (! $response->success) {
            return new Error($response->data);
        }

        $collections = $response->data;
        $out = collect();
        foreach ($collections as $collection) {
            $out->push(new SegmentCollection($collection));
        }

        return $out;
    }

    public function getInstance(
        string $segment_id
    ) {
        $response = $this->get('lists/108094/segments/'.$segment_id, [
            'segment_id' => $segment_id,
        ]);

        if (! $response->success) {
            return new Error($response->data);
        }

        //dd($response);

        $getInstance = $response->data;

        //dd($getInstance);

        return new Segment($getInstance);
    }

    public function getCount(
        string $list_id
    ) {
        $response = $this->get('lists/'.$list_id.'/segments/count?');

        if (! $response->success) {
            return new Error($response->data);
        }

        $getCount = $response->data;

        return new SegmentCount($getCount);
    }

    public function getContactsCount(
        string $segment_id
    ) {
        $response = $this->get('segments/'.$segment_id.'/contacts/count', [
            'segment_id' => $segment_id,
        ]);

        if (! $response->success) {
            return new Error($response->data);
        }

        $getContactsCount = $response->data;

        return new ContactsCount($getContactsCount);
    }

    public function createInstance(
        int $list_id,
        array $body
    ) {
        $validator = Validator::make($body, [
            'instance_in.list_id' => 'required',
            'instance_in.logic' => 'required',
            'instance_in.condition_groups' => 'required|array',
            'instance_in.condition_groups.*.logic' => 'required|string',
            'instance_in.condition_groups.*.conditions' => 'required|array',
            'instance_in.condition_groups.*.conditions.*.comparable_id' => 'nullable',
            'instance_in.condition_groups.*.conditions.*.comparator_id' => 'required|string',
            'instance_in.condition_groups.*.conditions.*.field_id' => 'required|string',
            'instance_in.condition_groups.*.conditions.*.name' => 'required|string',
            'instance_in.condition_groups.*.conditions.*.value' => 'required|string',
            'instance_in.description' => 'nullable|string',
            'instance_in.id' => 'nullable',
            'instance_in.name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post('segments?list_id='.$list_id, $body);

        if (! $response->success) {
            return new Error($response->data);
        }

        $createInstance = $response->data;

        return new CreateSegment($createInstance);
    }

    public function updateInstance(
        string $list_id,
        string $segment_id,
        array $body
    ) {
        $validator = Validator::make($body, [
            'instance_in.list_id' => 'required',
            'instance_in.logic' => 'required',
            'instance_in.condition_groups' => 'required|array',
            'instance_in.condition_groups.*.logic' => 'required|string',
            'instance_in.condition_groups.*.conditions' => 'required|array',
            'instance_in.condition_groups.*.conditions.*.comparable_id' => 'nullable',
            'instance_in.condition_groups.*.conditions.*.comparator_id' => 'required|string',
            'instance_in.condition_groups.*.conditions.*.field_id' => 'required|string',
            'instance_in.condition_groups.*.conditions.*.name' => 'required|string',
            'instance_in.condition_groups.*.conditions.*.value' => 'required|string',
            'instance_in.description' => 'nullable|string',
            'instance_in.id' => 'nullable',
            'instance_in.name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->put('segments/'.$segment_id.'?lists_id='.$list_id, $body);

        if (! $response->success) {
            return new Error($response->data);
        }

        $updateInstance = $response->data;

        return new UpdateSegment($updateInstance);
    }

    public function deleteInstance(
        string $segment_id
    ) {
        $response = $this->destroy('segments/'.$segment_id, [
            'segment_id' => $segment_id,
        ]);

        if (! $response->success) {
            return new Error($response->data);
        }

        $deleteInstance = $response->data;

        return new SegmentDeletion($deleteInstance);
    }
}
