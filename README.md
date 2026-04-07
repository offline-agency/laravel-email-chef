# Laravel Email Chef API

[![Latest Stable Version](https://img.shields.io/packagist/v/offline-agency/laravel-email-chef)](https://packagist.org/packages/offline-agency/laravel-email-chef)
[![PHP Version](https://img.shields.io/packagist/php-v/offline-agency/laravel-email-chef)](https://packagist.org/packages/offline-agency/laravel-email-chef)
[![Laravel](https://img.shields.io/badge/Laravel-12.x%20|%2013.x-red)](https://laravel.com)
[![Tests](https://github.com/offline-agency/laravel-email-chef/actions/workflows/main.yml/badge.svg)](https://github.com/offline-agency/laravel-email-chef/actions)
[![Coverage](https://img.shields.io/badge/coverage-%E2%89%A580%25-brightgreen)]()
[![PHPStan](https://img.shields.io/badge/PHPStan-level%206-blue)]()
[![License](https://img.shields.io/packagist/l/offline-agency/laravel-email-chef)](LICENSE.md)

A Laravel package for the [EmailChef](https://emailchef.com) API — covering all 14 resource groups with a fluent, typed PHP interface.

---

## Requirements

| Dependency | Version |
|---|---|
| PHP | ^8.4 |
| Laravel | ^12.0 \| ^13.0 |
| orchestra/testbench (dev) | ^10.0 \| ^11.0 |

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

Every API class is instantiated directly — authentication is handled automatically via JWT.

### Account

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\AccountApi;

$account = (new AccountApi())->getCollection();
// Returns AccountEntity with id, email, lang, status, subscribers, etc.
echo $account->email; // "admin@acme.com"
```

### Account Infos

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\AccountInfosApi;

$api    = new AccountInfosApi();
$info   = $api->getInstance('12345');
$result = $api->update([
    'company_name' => 'Acme Corp',
    'address'      => 'Via Roma 1, Milan',
]);
```

### Subscription

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\SubscriptionApi;

$subscription = (new SubscriptionApi())->getCollection();
echo $subscription->type;            // "premium"
echo $subscription->plan_expiration; // "2027-01-15"
```

### Lists

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\ListsApi;

$lists = new ListsApi();

// Browse all lists
$all = $lists->getCollection(limit: 10, offset: 0, orderby: 'name', order_type: 'asc');

// Get details and stats
$list  = $lists->getInstance('97322');
$stats = $lists->getStats('97322', '2024-01-01', '2024-12-31');

// Create, update, delete
$created = $lists->create(['list_name' => 'Newsletter', 'list_description' => 'Main list']);
$lists->update('97322', ['list_name' => 'Updated Newsletter', 'list_description' => 'Updated']);
$lists->delete('97322');

// Subscribe / Unsubscribe
$lists->subscribe('97322', '656023');
$lists->unsubscribe('97322', '656023');
```

### Contacts

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\ContactsApi;

$contacts = new ContactsApi();

$count   = $contacts->count('97322');
$all     = $contacts->getCollection('active', '97322', limit: 25, offset: 0, order_by: 'email', order_type: 'asc');
$contact = $contacts->getInstance('656023', '97322');

$created = $contacts->create([
    'list_id' => '97322',
    'email'   => 'john@example.com',
    'firstname' => 'John',
    'lastname'  => 'Doe',
]);

$contacts->update('656023', ['firstname' => 'Jane']);
$contacts->delete('97322', '656023');
```

### Predefined Fields

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\PredefinedFieldsApi;

$fields = (new PredefinedFieldsApi())->getCollection();
// Collection of PredefinedFieldsEntity with id, name, type_id, reference, etc.
```

### Custom Fields

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\CustomFieldsApi;

$api = new CustomFieldsApi();

$fields = $api->getCollection('97322');
$field  = $api->getInstance('42');
$count  = $api->count('97322');

$api->create('97322', ['name' => 'Birthday', 'type_id' => '3']);
$api->update('42', ['name' => 'Birth Date']);
$api->delete('42');
```

### Blockings

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\BlockingsApi;

$api = new BlockingsApi();

$blocked = $api->getCollection('spam', limit: 10, offset: 0);
$count   = $api->count('spam');

$api->create('block@example.com', 'email');
$api->delete('block@example.com');
```

### Import Tasks

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\ImportTasksApi;

$api = new ImportTasksApi();

$tasks = $api->getCollection();
$task  = $api->getInstance('101');

$api->create('97322', [
    'contacts' => [
        ['email' => 'a@example.com', 'firstname' => 'Alice'],
        ['email' => 'b@example.com', 'firstname' => 'Bob'],
    ],
]);
```

### Segments

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\SegmentsApi;

$api = new SegmentsApi();

$segments      = $api->getCollection('97322', limit: 10, offset: 0);
$segment       = $api->getInstance('5');
$segmentCount  = $api->getCount('97322');
$contactsCount = $api->getContactsCount('5');

$api->createInstance(97322, [
    'name'  => 'VIP Customers',
    'logic' => 'and',
    'condition_groups' => [['field' => 'email', 'operator' => 'contains', 'value' => '@acme.com']],
]);
$api->updateInstance('97322', '5', ['name' => 'Premium VIPs']);
$api->deleteInstance('5');
```

### Campaigns

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\CampaignsApi;

$api = new CampaignsApi();

$count     = $api->getCount();
$campaigns = $api->getCollection('sent', limit: 10, offset: 0, orderby: 'name', ordertype: 'asc');
$campaign  = $api->getInstance('10');

$api->createInstance([
    'name'       => 'Summer Sale',
    'subject'    => 'Up to 50% off',
    'from_name'  => 'Acme Store',
    'from_email' => 'hello@acme.com',
    'html_body'  => '<h1>Summer Sale!</h1><p>Shop now.</p>',
]);
$api->updateInstance('10', ['subject' => 'Extended: Summer Sale']);
$api->deleteInstance('10');

$api->sendTestEmail('10', ['email' => 'test@acme.com']);
$api->sendCampaign('10', []);
$api->schedule('10', ['send_time' => '2026-07-01 09:00:00']);
$api->cancelScheduling('10');
$api->archive('10');
$api->unarchive('10');
$api->cloning(['id' => '10']);
$api->getLinkCollection('10');
```

### Autoresponders

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\AutorespondersApi;

$api = new AutorespondersApi();

$count = $api->getCount();
$list  = $api->getCollection(limit: 10, offset: 0, orderby: 'name', ordertype: 'asc');
$ar    = $api->getInstance('20');

$api->createInstance([
    'name'      => 'Welcome Email',
    'subject'   => 'Welcome aboard!',
    'html_body' => '<p>Thanks for joining.</p>',
]);
$api->updateInstance('20', ['subject' => 'Welcome to Acme!']);
$api->deleteInstance('20');

$api->sendTestEmail('20', ['email' => 'test@acme.com']);
$api->activate('20', []);
$api->deactivate('20', []);
$api->cloning(['id' => '20']);
$api->getLinksCollection('20');
```

### Send Mail (transactional)

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\SendEmailApi;

(new SendEmailApi())->sendMail([
    'to'      => 'customer@example.com',
    'subject' => 'Your order has shipped',
    'html'    => '<p>Track your order <a href="https://track.acme.com/123">here</a>.</p>',
]);
```

### SMS

```php
use OfflineAgency\LaravelEmailChef\Api\Resources\SMSApi;

$sms = new SMSApi();

$sms->send(['to' => '+39 333 1234567', 'text' => 'Your verification code is 4821.']);
$sms->getBalance();                    // Balance entity with ->balance, ->currency
$sms->getStatusMessage('msg-abc123');  // StatusMessage entity
$sms->getBulkMessageStatus('bulk-1');  // BulkMessageStatus entity
```

---

## API Coverage

| Group             | Status |
|-------------------|--------|
| Account           | ✅     |
| Account Infos     | ✅     |
| Subscription      | ✅     |
| Lists             | ✅     |
| Contacts          | ✅     |
| Predefined Fields | ✅     |
| Custom Fields     | ✅     |
| Blockings         | ✅     |
| Import Tasks      | ✅     |
| Segments          | ✅     |
| Campaigns         | ✅     |
| Autoresponders    | ✅     |
| Send Mail         | ✅     |
| SMS               | ✅     |

---

## Testing

```bash
composer test                            # run all tests
./vendor/bin/pest --coverage             # with coverage report
./vendor/bin/pest --coverage --min=80    # enforce coverage gate
composer analyse                         # static analysis (PHPStan level 6)
./vendor/bin/pint                        # fix code style
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

---

## Proposed Improvements

> **Note:** This section is a review aid for PR #11. It will be removed before merging.

### Proposal 1 — JWT token caching

**Current:** A new JWT token is fetched via `POST /login` on every API class instantiation.

**Proposed:** Cache the token using Laravel's Cache facade with a TTL slightly shorter than server-side expiry (e.g. 55 minutes):

```php
use Illuminate\Support\Facades\Cache;

private function getToken(): string
{
    return Cache::remember('emailchef_jwt', now()->addMinutes(55), function (): string {
        $response = Http::post(config('email-chef.login_url').'login', [
            'username' => config('email-chef.username'),
            'password' => config('email-chef.password'),
        ]);
        return $response->json('authkey');
    });
}
```

**Effort:** Low. **Impact:** Eliminates redundant auth round-trips.

---

### Proposal 2 — Exception hierarchy

**Current:** API errors return an `Error` entity. Consumers cannot catch specific error types.

**Proposed:** Create `src/Exceptions/` hierarchy:

```
EmailChefException (base)
├── AuthenticationException   (401)
├── NotFoundException          (404)
├── ValidationException        (422 — carries field errors)
├── RateLimitException         (429 — includes Retry-After value)
└── ServerException            (5xx)
```

**Effort:** Medium. **Impact:** High — enables typed error handling.

---

### Proposal 3 — EmailChef Facade

**Current:** Users instantiate each API class manually (`new ListsApi()`).

**Proposed:** A single-entry-point facade:

```php
use OfflineAgency\LaravelEmailChef\Facades\EmailChef;

EmailChef::lists()->getCollection(limit: 10, offset: 0, orderby: 'name', order_type: 'asc');
EmailChef::contacts()->count(listId: '97322');
EmailChef::campaigns()->sendCampaign('42', []);
```

**Effort:** Low-medium. **Impact:** High ergonomic value.

---

### Proposal 4 — Pagination abstraction

**Current:** List endpoints return a single page. No standard way to iterate beyond page 1.

**Proposed:** A `PaginatedResponse` value object with `hasMorePages()` and an `->all()` convenience method that auto-fetches all pages.

**Effort:** Medium. **Impact:** Important for large contact lists.

---

### Proposal 5 — Config type-safety

**Current:** Config keys like `'email-chef.baseUrl'` are raw strings. A typo silently returns `null`.

**Proposed:** A `src/EmailChefConfig.php` class with static accessors that throw on missing config:

```php
final class EmailChefConfig
{
    public static function baseUrl(): string
    {
        return config('email-chef.baseUrl') ?? throw new \RuntimeException('EmailChef baseUrl not configured.');
    }
}
```

**Effort:** Low. **Impact:** IDE autocompletion + early failure on misconfiguration.

---

### Proposal 6 — Laravel 13 attribute adoption in examples

Laravel 13 introduced first-party PHP Attribute support. The README examples could demonstrate modern L13 usage patterns:

```php
use Illuminate\Routing\Attributes\Controllers\Middleware;

#[Middleware('auth')]
class NewsletterController
{
    public function subscribe(Request $request): JsonResponse
    {
        (new ListsApi())->subscribe(
            listId: config('email-chef.list_id'),
            data: $request->validated(),
        );
        return response()->json(['subscribed' => true]);
    }
}
```

**Effort:** Documentation only.
