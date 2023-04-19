# Laravel Email Chef API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/offlineagency/laravel-email-chef.svg?style=flat-square)](https://packagist.org/packages/offlineagency/laravel-email-chef)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/offlineagency/laravel-email-chef/run-tests?label=tests)](https://github.com/offlineagency/laravel-email-chef/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/offlineagency/laravel-email-chef/Check%20&%20fix%20styling?label=code%20style)](https://github.com/offlineagency/laravel-email-chef/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/offlineagency/laravel-email-chef.svg?style=flat-square)](https://packagist.org/packages/offlineagency/laravel-email-chef)
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
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="OfflineAgency\LaravelEmailChef\LaravelEmailChefServiceProvider" --tag="laravel-email-chef-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$laravel-email-chef = new OfflineAgency\LaravelEmailChef();
echo $laravel-email-chef->echoPhrase('Hello, OfflineAgency!');
```

## Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

If you discover any security-related issues, please email support@offlineagency.com instead of using the issue tracker.

## Credits

- [Offline Agency](https://github.com/ManuelRomanato)
- [Manuel Romanato](https://github.com/offline-agency)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.