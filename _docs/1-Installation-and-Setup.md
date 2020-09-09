# 1. Installation

## Table of contents

  1. [Installation and Setup](1-Installation-and-Setup.md)
  2. [Configuration](2-Configuration.md)
  3. [Usage](3-Usage.md)

## Version Compatibility

| Laravel                      | LaravelActive                                 |
|:-----------------------------|:----------------------------------------------|
| ![Laravel v8.x][laravel_8_x] | ![LaravelActive v4.x][laravel_active_4_x]     |
| ![Laravel v7.x][laravel_7_x] | ![LaravelActive v3.x][laravel_active_3_x]     |
| ![Laravel v6.x][laravel_6_x] | ![LaravelActive v2.x][laravel_active_2_x]     |
| ![Laravel v5.8][laravel_5_8] | ![LaravelActive v1.4.x][laravel_active_1_4_x] |
| ![Laravel v5.7][laravel_5_7] | ![LaravelActive v1.3.x][laravel_active_1_3_x] |
| ![Laravel v5.6][laravel_5_6] | ![LaravelActive v1.2.x][laravel_active_1_2_x] |
| ![Laravel v5.5][laravel_5_5] | ![LaravelActive v1.1.x][laravel_active_1_1_x] |
| ![Laravel v5.4][laravel_5_4] | ![LaravelActive v1.0.x][laravel_active_1_0_x] |

[laravel_8_x]:  https://img.shields.io/badge/version-8.x-blue.svg?style=flat-square "Laravel v8.x"
[laravel_7_x]:  https://img.shields.io/badge/version-7.x-blue.svg?style=flat-square "Laravel v7.x"
[laravel_6_x]:  https://img.shields.io/badge/version-6.x-blue.svg?style=flat-square "Laravel v6.x"
[laravel_5_8]:  https://img.shields.io/badge/version-5.8-blue.svg?style=flat-square "Laravel v5.8"
[laravel_5_7]:  https://img.shields.io/badge/version-5.7-blue.svg?style=flat-square "Laravel v5.7"
[laravel_5_6]:  https://img.shields.io/badge/version-5.6-blue.svg?style=flat-square "Laravel v5.6"
[laravel_5_5]:  https://img.shields.io/badge/version-5.5-blue.svg?style=flat-square "Laravel v5.5"
[laravel_5_4]:  https://img.shields.io/badge/version-5.4-blue.svg?style=flat-square "Laravel v5.4"

[laravel_active_4_x]:    https://img.shields.io/badge/version-4.x-blue.svg?style=flat-square "LaravelActive v4.x"
[laravel_active_3_x]:    https://img.shields.io/badge/version-3.x-blue.svg?style=flat-square "LaravelActive v3.x"
[laravel_active_2_x]:    https://img.shields.io/badge/version-2.x-blue.svg?style=flat-square "LaravelActive v2.x"
[laravel_active_1_4_x]:  https://img.shields.io/badge/version-1.4.x-blue.svg?style=flat-square "LaravelActive v1.4.x"
[laravel_active_1_3_x]:  https://img.shields.io/badge/version-1.3.x-blue.svg?style=flat-square "LaravelActive v1.3.x"
[laravel_active_1_2_x]:  https://img.shields.io/badge/version-1.2.x-blue.svg?style=flat-square "LaravelActive v1.2.x"
[laravel_active_1_1_x]:  https://img.shields.io/badge/version-1.1.x-blue.svg?style=flat-square "LaravelActive v1.1.x"
[laravel_active_1_0_x]:  https://img.shields.io/badge/version-1.0.x-blue.svg?style=flat-square "LaravelActive v1.0.x"

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

### Artisan commands

To publish the config &amp; view files, run this command:

```bash
php artisan vendor:publish --provider="Arcanedev\LaravelActive\LaravelActiveServiceProvider"
```
