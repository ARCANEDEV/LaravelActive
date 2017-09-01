# 1. Installation

## Table of contents

  1. [Installation and Setup](_docs/1-Installation-and-Setup.md)
  2. [Configuration](_docs/2-Configuration.md)
  3. [Usage](_docs/3-Usage.md)
  
## Server Requirements

The LaravelActive package has a few system requirements:

    - PHP >= 5.6
    
## Version Compatibility

| LaravelActive                                 | Laravel                      |
|:----------------------------------------------|:-----------------------------|
| ![LaravelActive v1.0.x][laravel_active_1_0_x] | ![Laravel v5.4][laravel_5_4] |


[laravel_5_4]:  https://img.shields.io/badge/v5.4-supported-brightgreen.svg?style=flat-square "Laravel v5.4"

[laravel_active_1_0_x]:   https://img.shields.io/badge/version-1.0.*-blue.svg?style=flat-square "LaravelActive v1.0.*"

## Composer

You can install this package via [Composer](http://getcomposer.org/) by running this command: `composer require arcanedev/laravel-active`.

## Laravel

### Setup

> **NOTE :** The package will automatically register itself if you're using Laravel `>= v5.5`, so you can skip this section.

Once the package is installed, you can register the service provider in `config/app.php` in the `providers` array:

```php
// config/app.php

'providers' => [
    ...
    Arcanedev\LaravelActive\LaravelActiveServiceProvider::class,
],
```

And for the Facade:

```php
// config/app.php

'aliases' => [
    ...
    'Active' => Arcanedev\LaravelActive\Facades\Active::class,
];
```

### Artisan commands

To publish the config &amp; view files, run this command:

```bash
php artisan vendor:publish --provider="Arcanedev\LaravelActive\LaravelActiveServiceProvider"
```
