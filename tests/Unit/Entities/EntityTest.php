<?php

declare(strict_types=1);

use OfflineAgency\LaravelEmailChef\Entities\Blockings\BlockingsEntity;
use OfflineAgency\LaravelEmailChef\Entities\Blockings\CountBlockings;
use OfflineAgency\LaravelEmailChef\Entities\Contacts\ContactsEntity;
use OfflineAgency\LaravelEmailChef\Entities\CustomFields\CustomFieldsEntity;
use OfflineAgency\LaravelEmailChef\Entities\ImportTasks\ImportTasksEntity;

describe('Entity hydration', function (): void {
    it('hydrates BlockingsEntity from response', function (): void {
        $data = (object) ['email' => 'test@example.com', 'type' => 'email'];
        $entity = BlockingsEntity::fromResponse($data);

        expect($entity)->toBeInstanceOf(BlockingsEntity::class)
            ->and($entity->email)->toBe('test@example.com')
            ->and($entity->type)->toBe('email');
    });

    it('hydrates CountBlockings from response', function (): void {
        $data = (object) ['totalcount' => '42'];
        $entity = CountBlockings::fromResponse($data);

        expect($entity->totalcount)->toBe('42');
    });

    it('hydrates ContactsEntity from response', function (): void {
        $data = (object) [
            'id'            => '1',
            'list_id'       => '2',
            'name'          => 'Email',
            'type_id'       => '3',
            'place_holder'  => 'ph',
            'options'       => ['a'],
            'text'          => 'txt',
            'default_value' => 'def',
        ];
        $entity = ContactsEntity::fromResponse($data);

        expect($entity->id)->toBe('1')
            ->and($entity->options)->toBe(['a']);
    });

    it('hydrates CustomFieldsEntity from response', function (): void {
        $data = (object) [
            'id'            => '1',
            'list_id'       => '2',
            'name'          => 'Birthday',
            'type_id'       => '3',
            'place_holder'  => 'ph',
            'options'       => null,
            'default_value' => '',
            'admin_only'    => '0',
            'ord'           => null,
            'data_type'     => 'date',
        ];
        $entity = CustomFieldsEntity::fromResponse($data);

        expect($entity->name)->toBe('Birthday');
    });

    it('hydrates ImportTasksEntity from response', function (): void {
        $data = (object) [
            'id'                 => '1',
            'list_id'            => '2',
            'creation_time'      => '2024-01-01',
            'error_message'      => null,
            'imported_success'   => '10',
            'imported_fail'      => '0',
            'imported_updated'   => '5',
            'last_updated'       => '2024-01-02',
            'progress'           => '100',
            'uploaded_file_name' => 'contacts.csv',
            'list_name'          => 'Test',
            'notification_link'  => null,
        ];
        $entity = ImportTasksEntity::fromResponse($data);

        expect($entity->id)->toBe('1')
            ->and($entity->error_message)->toBeNull();
    });

    it('handles null data in fromResponse', function (): void {
        $entity = BlockingsEntity::fromResponse(null);

        expect($entity)->toBeInstanceOf(BlockingsEntity::class)
            ->and($entity->email)->toBe('');
    });

    it('ignores extra fields not in constructor', function (): void {
        $data = (object) ['email' => 'test@example.com', 'type' => 'email', 'unknown_field' => 'ignored'];
        $entity = BlockingsEntity::fromResponse($data);

        expect($entity->email)->toBe('test@example.com');
    });
});
