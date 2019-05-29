# Laravel Jumbotron Images

[![Latest Version on Packagist](https://img.shields.io/packagist/v/davide-casiraghi/laravel-jumbotron-images.svg?style=flat-square)](https://packagist.org/packages/davide-casiraghi/laravel-jumbotron-images)
[![Build Status](https://img.shields.io/travis/davide-casiraghi/laravel-jumbotron-images/master.svg?style=flat-square)](https://travis-ci.org/davide-casiraghi/laravel-jumbotron-images)
[![Quality Score](https://img.shields.io/scrutinizer/g/davide-casiraghi/laravel-jumbotron-images.svg?style=flat-square)](https://scrutinizer-ci.com/g/davide-casiraghi/laravel-jumbotron-images)
[![Coverage Status](https://scrutinizer-ci.com/g/davide-casiraghi/laravel-jumbotron-images/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/davide-casiraghi/laravel-jumbotron-images/)
<a href="https://codeclimate.com/github/davide-casiraghi/laravel-jumbotron-images/maintainability"><img src="https://api.codeclimate.com/v1/badges/998c23a3b93bddddde3f/maintainability" /></a>
[![GitHub last commit](https://img.shields.io/github/last-commit/davide-casiraghi/laravel-jumbotron-images.svg)](https://github.com/davide-casiraghi/laravel-jumbotron-images) 

Add a jumbotron images with title and description to the pages of your Laravel application.  
The titles and descriptions support multilanguage.

## Installation

You can install the package via composer:

```bash
composer require davide-casiraghi/laravel-jumbotron-images
```

### Publish all the vendor files
```php artisan vendor:publish --force```

### Run the database migrations
```php artisan migrate```

### Add the JS files to /resources/js/app.js
```
require('./vendor/laravel-jumbotron-images/jquery.stellar');  
require('./vendor/laravel-jumbotron-images/laravel-jumbotron-images');  
```

### Add the SCSS file to /resources/sass/app.scss
```
@import 'vendor/laravel-jumbotron-images/laravel-jumbotron-images';
```
### Add your jumbotrons to the jumbotrons table
Once you have published the package you can go to this route to manage your jumbotrons:  
**/jumbotron-images**

## Usage

Include the facade in your controller:
``` php
use DavideCasiraghi\LaravelJumbotronImages\Facades\LaravelJumbotronImages;
```

In the controller, pass to the view the Jumbotron datas. (In this case we want to show the jumbotron with id = 1)
``` php
$jumbotronImage = LaravelJumbotronImages::getJumbotronImage(1);
return view('welcome', [
    'jumbotronImage' => $jumbotronImage,
    'jumbotronImageParameters' => LaravelJumbotronImages::getParametersArray($jumbotronImage),
]);
```

Then include in the view the jumbotron view.
``` php
@include('vendor.laravel-jumbotron-images.show-jumbotron-image', $jumbotronImage)
```

### The snippet
The library replace all the occurrences of this kind of snippet

``` bash
{# jumbotron id=[1] #}
```
## Testing

You can run unit tests checking the code coverage using this command.
``` bash
./vendor/bin/phpunit --coverage-html=html
```
So you can find the reports about the code coverage in this file **/html/index.html**

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email davide.casiraghi@gmail.com instead of using the issue tracker.

## Credits

- [Davide Casiraghi](https://github.com/davide-casiraghi)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
