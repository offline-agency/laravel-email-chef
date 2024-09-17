<?php

namespace OfflineAgency\LaravelEmailChef\Api\Resources;

use OfflineAgency\LaravelEmailChef\Api\Api;
use OfflineAgency\LaravelEmailChef\Entities\Blockings\CountBlockingsEntity;
use OfflineAgency\LaravelEmailChef\Entities\Blockings\CreatedBlockingsEntity;
use OfflineAgency\LaravelEmailChef\Entities\Blockings\GetCollection;
use OfflineAgency\LaravelEmailChef\Entities\Error;

class BlockingsApi extends Api
{
    public function getCollection(
        string $query_string,
        ?int $limit,
        ?int $offset
    ) {
        $response = $this->get('blockings?$query_string='.$query_string.'&limit='.$limit.'&offset='.$offset, [
            'query_string' => $query_string,
            'limit' => $limit,
            'offset' => $offset,
        ]);

        if (! $response->success) {
            return new Error($response->data);
        }

        $collection = $response->data;

        $out = collect();
        foreach ($collection as $collectionItem) {
            $out->push(new GetCollection($collectionItem));
        }

        return $out;
    }

    public function count(
        string $query_string,
    ) {
        $response = $this->get('blockings/count?query_string='.$query_string, [
            'query_string' => $query_string,
        ]);

        if (! $response->success) {
            return new Error($response->data);
        }

        $count = $response->data;

        return new CountBlockingsEntity($count);
    }

    public function create(
        string $email,
        string $type
    ) {
        $response = $this->post('blockings?email='.$email.'&type='.$type, []);

        if (! $response->success) {
            return new Error($response->data);
        }

        $blocking = $response->data;

        return new CreatedBlockingsEntity($blocking);
    }

    public function delete(
        string $email
    ) {
        $response = $this->destroy('blockings/'.$email);

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'Blocking #'.$email.' deleted';
    }
}
