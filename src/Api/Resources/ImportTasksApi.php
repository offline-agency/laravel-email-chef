<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Api\Resources;

use Illuminate\Support\Facades\Validator;
use OfflineAgency\LaravelEmailChef\Api\Api;
use OfflineAgency\LaravelEmailChef\Entities\Error;
use OfflineAgency\LaravelEmailChef\Entities\ImportTasks\CreatedImportTasksEntity;
use OfflineAgency\LaravelEmailChef\Entities\ImportTasks\GetCollection;
use OfflineAgency\LaravelEmailChef\Entities\ImportTasks\GetInstance;

final class ImportTasksApi extends Api
{
    public function getCollection(
    ): mixed {
        $response = $this->get('importtasks', []);

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

    public function getInstance(
        string $task_id,
    ): mixed {
        $response = $this->get('importtasks/'.$task_id, [
            'task_id' => $task_id,
        ]);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $importtask = $response->data;

        return GetInstance::fromResponse($importtask);
    }

    /**
     * @param array<string, mixed> $instance_in
     */
    public function create(
        string $list_id,
        array $instance_in = [],
    ): mixed {
        $validator = Validator::make($instance_in, [
            'contacts'          => 'required|array',
            'notification_link' => 'string',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post('lists/'.$list_id.'/import', [
            'instance_in' => $instance_in,
        ]);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $importtask = $response->data;

        return CreatedImportTasksEntity::fromResponse($importtask);
    }
}
