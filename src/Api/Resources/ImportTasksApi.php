<?php

namespace OfflineAgency\LaravelEmailChef\Api\Resources;

use Illuminate\Support\Facades\Validator;
use OfflineAgency\LaravelEmailChef\Api\Api;
use OfflineAgency\LaravelEmailChef\Entities\Error;
use OfflineAgency\LaravelEmailChef\Entities\ImportTasks\CreatedImportTasksEntity;
use OfflineAgency\LaravelEmailChef\Entities\ImportTasks\GetCollection;
use OfflineAgency\LaravelEmailChef\Entities\ImportTasks\GetInstance;

class ImportTasksApi extends Api
{
    public function getCollection(
    ) {
        $response = $this->get('importtasks', []);

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

    public function getInstance(
        string $task_id
    ) {
        $response = $this->get('importtasks/'.$task_id, [
            'task_id' => $task_id,
        ]);

        if (! $response->success) {
            return new Error($response->data);
        }

        $importtask = $response->data;

        return new GetInstance($importtask);
    }

    public function create(
        string $list_id,
        array $instance_in = []
    ) {
        $validator = Validator::make($instance_in, [
            'contacts' => 'required|array',
            'notification_link' => 'string',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post('lists/'.$list_id.'/import', [
            'instance_in' => $instance_in,
        ]);

        if (! $response->success) {
            return new Error($response->data);
        }

        $importtask = $response->data;

        return new CreatedImportTasksEntity($importtask);
    }
}
