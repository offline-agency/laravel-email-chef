<?php

namespace OfflineAgency\LaravelEmailChef\Api\Resources;

use OfflineAgency\LaravelEmailChef\Api\Api;
use OfflineAgency\LaravelEmailChef\Entities\Error;
use OfflineAgency\LaravelEmailChef\Entities\PredefinedFields\PredefinedFieldsEntity;

class PredefinedFieldsApi extends Api
{
    public function getCollection(
    ) {
        $response = $this->get('/predefinedfields');

        if (! $response->success) {
            return new Error($response->data);
        }

        $collection = $response->data;

        $out = collect();
        foreach ($collection as $collectionItem) {
            $out->push(new PredefinedFieldsEntity($collectionItem)); //Qui uso PredefinedFieldsEntity e non creo una nuova entità perché le variabili di esempleare sono uguali
        }

        return $out;
    }
}
