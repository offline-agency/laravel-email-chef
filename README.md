# Laravel Email Chef API

[![Latest Stable Version](http://poser.pugx.org/offline-agency/laravel-email-chef/v)](https://packagist.org/packages/offline-agency/laravel-email-chef)
[![License](http://poser.pugx.org/offline-agency/laravel-email-chef/license)](https://packagist.org/packages/offline-agency/laravel-email-chef)
[![run-tests](https://github.com/offline-agency/laravel-email-chef/actions/workflows/main.yml/badge.svg)](https://github.com/offline-agency/laravel-email-chef/actions/workflows/main.yml)
[![StyleCI](https://github.styleci.io/repos/557274815/shield)](https://styleci.io/repos/557274815)
[![Total Downloads](http://poser.pugx.org/offline-agency/laravel-email-chef/downloads)](https://packagist.org/packages/offline-agency/laravel-email-chef)
[![PHP Version Require](http://poser.pugx.org/offline-agency/laravel-email-chef/require/php)](https://packagist.org/packages/offline-agency/laravel-email-chef)
---
![Laravel Email Chef Integration](https://banners.beyondco.de/Laravel%20Email%20Chef%20API.png?theme=dark&packageManager=composer+require&packageName=offline-agency%2Flaravel-email-chef&pattern=charlieBrown&style=style_2&description=A+simple+Laravel+integration+with+Email+Chef+API&md=1&showWatermark=0&fontSize=100px&images=mail-open)
## Installation

You can install the package via composer:

```bash
composer require offline-agency/laravel-email-chef
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="OfflineAgency\LaravelEmailChef\LaravelEmailChefServiceProvider" --tag="laravel-email-chef-migrations"
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="OfflineAgency\LaravelEmailChef\LaravelEmailChefServiceProvider" --tag="laravel-email-chef-config"
```

This is the contents of the published config file:

```php
return [
    'baseUrl' => 'https://app.emailchef.com/apps/api/v1/',

    'login_url' => 'https://app.emailchef.com/api/',

    'username' =>  env('EMAIL_CHEF_USERNAME'),

    'password' => env('EMAIL_CHEF_PASSWORD'),

    'list_id' => '97322',
    
    'contact_id' => '656023'
];
```

## Usage

```php
$laravel-email-chef = new OfflineAgency\LaravelEmailChef();
echo $laravel-email-chef->echoPhrase('Hello, OfflineAgency!');

//List create
$list = new ListsApi();
$list->create([
    'list_name' => 'OA list name',
    'list_description' => 'description'
]);

//List unsubscribe
$list = new ListsApi();
$list->unsubscribe(
    97322, //list_id
    53998920 //contact_id
);

//Contacts get count
$contacts = new ContactsApi;
$contacts->count(config('email-chef.list_id'));
```

## API coverage

✅ Account

✅ Account infos

✅ Subscription

✅ Lists

✅ Contacts

✅ Predefined Fields

✅ Custom Fields

✅ Blockings

✅ Import Tasks

✅ Segments

✅ Campaigns

✅ Autoresponders

✅ Send mail

✅ SMS

## Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

If you discover any security-related issues, please email support@offlineagency.com instead of using the issue tracker.

## Credits

- [Offline Agency](https://github.com/offline-agency)
- [Manuel Romanato](https://github.com/ManuelRomanato)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
