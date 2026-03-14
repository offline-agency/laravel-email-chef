# Laravel Email Chef API

[![Latest Stable Version](http://poser.pugx.org/offline-agency/laravel-email-chef/v)](https://packagist.org/packages/offline-agency/laravel-email-chef)
[![PHP Version Require](http://poser.pugx.org/offline-agency/laravel-email-chef/require/php)](https://packagist.org/packages/offline-agency/laravel-email-chef)
[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![run-tests](https://github.com/offline-agency/laravel-email-chef/actions/workflows/main.yml/badge.svg)](https://github.com/offline-agency/laravel-email-chef/actions/workflows/main.yml)
[![PHPStan](https://img.shields.io/badge/PHPStan-level%206-brightgreen.svg)](https://phpstan.org)
[![License](http://poser.pugx.org/offline-agency/laravel-email-chef/license)](https://packagist.org/packages/offline-agency/laravel-email-chef)
[![Total Downloads](http://poser.pugx.org/offline-agency/laravel-email-chef/downloads)](https://packagist.org/packages/offline-agency/laravel-email-chef)

A Laravel package for the [EmailChef](https://emailchef.com) API — covering all 14 resource groups with a fluent, typed PHP interface.

---

## Requirements

| Dependency  | Version   |
|-------------|-----------|
| PHP         | ^8.4      |
| Laravel     | ^12.0     |
| testbench   | ^10.0 (dev) |

---

## Installation

```bash
composer require offline-agency/laravel-email-chef
```

Publish the config file:

```bash
php artisan vendor:publish --provider="OfflineAgency\LaravelEmailChef\LaravelEmailChefServiceProvider" --tag="laravel-email-chef-config"
```

Add your credentials to `.env`:

```env
EMAIL_CHEF_USERNAME=your@email.com
EMAIL_CHEF_PASSWORD=your-password
```

The published config (`config/email-chef.php`):

```php
return [
    'baseUrl'    => 'https://app.emailchef.com/apps/api/v1/',
    'login_url'  => 'https://app.emailchef.com/api/',
    'username'   => env('EMAIL_CHEF_USERNAME'),
    'password'   => env('EMAIL_CHEF_PASSWORD'),
    'list_id'    => '97322',
    'contact_id' => '656023',
];
```

---

## Usage

Every API class is instantiated directly — authentication is handled automatically.

### Account

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\AccountApi;

$account = (new AccountApi())->getCollection();
// → AccountEntity
```

### Account Infos

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\AccountInfosApi;

$info   = (new AccountInfosApi())->getInstance();
$result = (new AccountInfosApi())->update(['instance_in' => [...]]);
```

### Subscription

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\SubscriptionApi;

$plans = (new SubscriptionApi())->getCollection();
// → Collection<SubscriptionEntity>
```

### Lists

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\ListsApi;

$lists = (new ListsApi())->getCollection(limit: 10, offset: 0, orderby: 'name', order_type: 'asc');
$list  = (new ListsApi())->getInstance('97322');
$stats = (new ListsApi())->getStats('97322');

(new ListsApi())->create(['list_name' => 'My List', 'list_description' => 'desc']);
(new ListsApi())->update('97322', ['list_name' => 'Updated']);
(new ListsApi())->delete('97322');
(new ListsApi())->subscribe('97322', ['email' => 'user@example.com']);
(new ListsApi())->unsubscribe('97322', '656023');
```

### Contacts

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\ContactsApi;

$count    = (new ContactsApi())->count('97322');
$contacts = (new ContactsApi())->getCollection('97322', 10, 0, 'email', 'asc');
$contact  = (new ContactsApi())->getInstance('97322', '656023');

(new ContactsApi())->create(['instance_in' => ['list_id' => '97322', 'email' => 'new@example.com']]);
(new ContactsApi())->update('656023', ['instance_in' => ['email' => 'updated@example.com']]);
(new ContactsApi())->delete('97322', '656023');
```

### Predefined Fields

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\PredefinedFieldsApi;

$fields = (new PredefinedFieldsApi())->getCollection();
```

### Custom Fields

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\CustomFieldsApi;

$fields = (new CustomFieldsApi())->getCollection();
$field  = (new CustomFieldsApi())->getInstance('1');
$count  = (new CustomFieldsApi())->count();

(new CustomFieldsApi())->create(['instance_in' => ['name' => 'Birthday', 'type' => 'date']]);
(new CustomFieldsApi())->update('1', ['instance_in' => ['name' => 'Birth Date']]);
(new CustomFieldsApi())->delete('1');
```

### Blockings

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\BlockingsApi;

$list  = (new BlockingsApi())->getCollection('spam@example.com', 10, 0);
$count = (new BlockingsApi())->count('spam@example.com');

(new BlockingsApi())->create('block@example.com', 'email');
(new BlockingsApi())->delete('block@example.com');
```

### Import Tasks

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\ImportTasksApi;

$tasks = (new ImportTasksApi())->getCollection(10, 0);
$task  = (new ImportTasksApi())->getInstance('42');

(new ImportTasksApi())->create(['instance_in' => ['list_id' => '97322', 'contacts' => [...]]]);
```

### Segments

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\SegmentsApi;

$segments = (new SegmentsApi())->getCollection('97322', 10, 0);
$segment  = (new SegmentsApi())->getInstance('5');
$count    = (new SegmentsApi())->getCount('97322');
$contacts = (new SegmentsApi())->getContactsCount('5');

(new SegmentsApi())->createInstance(97322, ['instance_in' => [...]]);
(new SegmentsApi())->updateInstance('97322', '5', ['instance_in' => [...]]);
(new SegmentsApi())->deleteInstance('5');
```

### Campaigns

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\CampaignsApi;

$count     = (new CampaignsApi())->getCount();
$campaigns = (new CampaignsApi())->getCollection('active', 10, 0, 'name', 'asc');
$campaign  = (new CampaignsApi())->getInstance('10');

(new CampaignsApi())->createInstance(['instance_in' => [...]]);
(new CampaignsApi())->updateInstance('10', ['instance_in' => [...]]);
(new CampaignsApi())->deleteInstance('10');
(new CampaignsApi())->sendTestEmail('10', ['instance_in' => ['email' => 'test@example.com']]);
(new CampaignsApi())->sendCampaign('10', []);
(new CampaignsApi())->schedule('10', ['instance_in' => ['send_time' => '2025-12-01 09:00:00']]);
(new CampaignsApi())->cancelScheduling('10');
(new CampaignsApi())->archive('10');
(new CampaignsApi())->unarchive('10');
(new CampaignsApi())->cloning(['instance_in' => ['id' => '10']]);
(new CampaignsApi())->getLinkCollection('10');
```

### Autoresponders

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\AutorespondersApi;

$count = (new AutorespondersApi())->getCount();
$list  = (new AutorespondersApi())->getCollection(10, 0, 'name', 'asc');
$ar    = (new AutorespondersApi())->getInstance('20');

(new AutorespondersApi())->createInstance(['instance_in' => [...]]);
(new AutorespondersApi())->updateInstance('20', ['instance_in' => [...]]);
(new AutorespondersApi())->deleteInstance('20');
(new AutorespondersApi())->sendTestEmail('20', ['instance_in' => ['email' => 'test@example.com']]);
(new AutorespondersApi())->activate('20', []);
(new AutorespondersApi())->deactivate('20', []);
(new AutorespondersApi())->cloning(['instance_in' => ['id' => '20']]);
(new AutorespondersApi())->getLinksCollection('20');
```

### Send Mail (transactional)

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\SendEmailApi;

(new SendEmailApi())->sendMail([
    'to'      => 'customer@example.com',
    'subject' => 'Your order is ready',
    'html'    => '<p>Thank you for your order!</p>',
]);
```

### SMS

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\SMSApi;

(new SMSApi())->send(['to' => '+39 333 1234567', 'text' => 'Your code is 4821.']);
(new SMSApi())->getBalance();
(new SMSApi())->getStatusMessage('sms-123');
(new SMSApi())->getBulkMessageStatus('bulk-1');
```

---

## API Coverage

| Group            | Class               | Methods                                                                                                       |
|------------------|---------------------|---------------------------------------------------------------------------------------------------------------|
| Account          | AccountApi          | `getCollection()`                                                                                             |
| Account Infos    | AccountInfosApi     | `getInstance()`, `update()`                                                                                   |
| Subscription     | SubscriptionApi     | `getCollection()`                                                                                             |
| Lists            | ListsApi            | `getCollection()`, `getInstance()`, `getStats()`, `create()`, `update()`, `delete()`, `subscribe()`, `unsubscribe()` |
| Contacts         | ContactsApi         | `count()`, `getCollection()`, `getInstance()`, `create()`, `update()`, `delete()`                            |
| Predefined Fields | PredefinedFieldsApi | `getCollection()`                                                                                             |
| Custom Fields    | CustomFieldsApi     | `getCollection()`, `getInstance()`, `count()`, `create()`, `update()`, `delete()`                            |
| Blockings        | BlockingsApi        | `getCollection()`, `count()`, `create()`, `delete()`                                                         |
| Import Tasks     | ImportTasksApi      | `getCollection()`, `getInstance()`, `create()`                                                                |
| Segments         | SegmentsApi         | `getCollection()`, `getInstance()`, `getCount()`, `getContactsCount()`, `createInstance()`, `updateInstance()`, `deleteInstance()` |
| Campaigns        | CampaignsApi        | `getCount()`, `getCollection()`, `getInstance()`, `createInstance()`, `updateInstance()`, `deleteInstance()`, `sendTestEmail()`, `sendCampaign()`, `schedule()`, `cancelScheduling()`, `archive()`, `unarchive()`, `cloning()`, `getLinkCollection()` |
| Autoresponders   | AutorespondersApi   | `getCount()`, `getCollection()`, `getInstance()`, `createInstance()`, `updateInstance()`, `deleteInstance()`, `sendTestEmail()`, `activate()`, `deactivate()`, `cloning()`, `getLinksCollection()` |
| Send Mail        | SendEmailApi        | `sendMail()`                                                                                                  |
| SMS              | SMSApi              | `send()`, `getBalance()`, `getStatusMessage()`, `getBulkMessageStatus()`                                     |

---

## Testing

```bash
composer test              # run all tests
composer test-coverage     # run with coverage report
composer analyse           # PHPStan level 6
composer lint              # fix code style
composer lint:test         # check code style (no changes)
```

---

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please report security issues to support@offlineagency.com.

## Credits

- [Offline Agency](https://github.com/offline-agency)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
