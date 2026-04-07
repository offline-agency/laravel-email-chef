<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Api\Resources;

use OfflineAgency\LaravelEmailChef\Api\Api;
use OfflineAgency\LaravelEmailChef\Entities\Blockings\CountBlockingsEntity;
use OfflineAgency\LaravelEmailChef\Entities\Blockings\CreatedBlockingsEntity;
use OfflineAgency\LaravelEmailChef\Entities\Blockings\GetCollection;
use OfflineAgency\LaravelEmailChef\Entities\Error;

final class BlockingsApi extends Api
{
    public function getCollection(
        string $query_string,
        ?int $limit,
        ?int $offset,
    ): mixed {
        $response = $this->get('blockings?$query_string='.$query_string.'&limit='.$limit.'&offset='.$offset, [
            'query_string' => $query_string,
            'limit'        => $limit,
            'offset'       => $offset,
        ]);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $collection = $response->data;

        $out = collect();

        foreach ($collection as $collectionItem) {
            $out->push(GetCollection::fromResponse($collectionItem));
        }

        return $out;
    }

    public function count(
        string $query_string,
    ): mixed {
        $response = $this->get('blockings/count?query_string='.$query_string, [
            'query_string' => $query_string,
        ]);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $count = $response->data;

        return CountBlockingsEntity::fromResponse($count);
    }

    public function create(
        string $email,
        string $type,
    ): mixed {
        $response = $this->post('blockings?email='.$email.'&type='.$type, []);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $blocking = $response->data;

        return CreatedBlockingsEntity::fromResponse($blocking);
    }

    public function delete(
        string $email,
    ): mixed {
        $response = $this->destroy('blockings/'.$email);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        return 'Blocking #'.$email.' deleted';
    }
}
