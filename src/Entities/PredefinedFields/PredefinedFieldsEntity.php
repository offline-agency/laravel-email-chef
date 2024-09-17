<?php

namespace OfflineAgency\LaravelEmailChef\Entities\PredefinedFields;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class PredefinedFieldsEntity extends AbstractEntity
{
    public string $id;
    public string $name;
    public string $type_id;
    public string $place_holder;
    public string $reference;
    public string $mandatory;
    public string $data_type;
}
