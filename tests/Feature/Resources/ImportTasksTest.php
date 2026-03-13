<?php

namespace OfflineAgency\LaravelEmailChef\Tests\Feature\Resources;

use OfflineAgency\LaravelEmailChef\Api\Resources\ImportTasksApi;
use OfflineAgency\LaravelEmailChef\Entities\ImportTasks\CreatedImportTasksEntity;
use OfflineAgency\LaravelEmailChef\Entities\ImportTasks\GetCollection;
use OfflineAgency\LaravelEmailChef\Entities\ImportTasks\GetInstance;
use OfflineAgency\LaravelEmailChef\Tests\TestCase;

class ImportTasksTest extends TestCase
{
    public function test_get_collection()
    {
        $import_tasks = new ImportTasksApi();

        $response = $import_tasks->getCollection();

        $import_task = $response->first();

        $this->assertInstanceOf(GetCollection::class, $import_task);
        $this->assertIsString($import_task->id);
        $this->assertIsString($import_task->list_id);
        $this->assertIsString($import_task->creation_time);
        $this->assertIsString($import_task->imported_success);
        $this->assertIsString($import_task->imported_fail);
        $this->assertIsString($import_task->imported_updated);
        $this->assertIsString($import_task->last_updated);
        $this->assertIsString($import_task->progress);
        $this->assertIsString($import_task->uploaded_file_name);
        $this->assertIsString($import_task->list_name);
    }

    public function test_get_instance()
    {
        $import_tasks = new ImportTasksApi();

        $response = $import_tasks->getInstance(
            2201836
        );

        $this->assertInstanceOf(GetInstance::class, $response);
        $this->assertIsString($response->id);
        $this->assertIsString($response->list_id);
        $this->assertIsString($response->progress);
        $this->assertIsString($response->imported);
        $this->assertIsString($response->failed);
        $this->assertIsString($response->updated);
        $this->assertIsString($response->uploaded_file_name);
        $this->assertIsString($response->list_name);
    }

    public function test_create()
    {
        $this->markTestIncomplete(); //remove this after changing the parameters on the create method below

        $import_tasks = new ImportTasksApi();

        $response = $import_tasks->create(
            '108094',
            [
                'contacts' => [
                    [
                        [
                            'placeholder' => 'email',
                            'value' => 'fzancan@gmail.com',
                        ],
                    ],
                    [
                        [
                            'placeholder' => 'first_name',
                            'value' => 'Federico',
                        ],
                    ],
                    [
                        [
                            'placeholder' => 'last_name',
                            'value' => 'Zancan',
                        ],
                    ],

                ],
                'notification_link' => 'http://usersremotesite.net/notifications/endpoint',
            ]
        );

        $this->assertInstanceOf(CreatedImportTasksEntity::class, $response);
        $this->assertIsString($response->id);
        $this->assertIsArray($response->validation_errors);
        $this->assertIsArray($response->validation_warnings);
    }
}
