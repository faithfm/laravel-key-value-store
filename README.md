## Laravel Key Value Store

Use `faithfm/laravel-key-value-store` to store key value pairs in the database ('key_value_store' table).

### Installation

**1** - You can install the package via composer:  (uses )

> Note: This Composer library is installed directly from Github (not currently registered with packagist.org).  

Add this library to your project's `composer.json` file:

```json
{
    "require": {
        ...
        "faithfm/laravel-key-value-store": "^1.0"
    }
    ...

    "repositories": [
        ...,
        {
            "type": "vcs",
            "url": "https://github.com/faithfm/laravel-key-value-store"
        }
    ]
}
```

...then install using:

```bash
composer update faithfm/laravel-key-value-store
```

**2** - In Laravel 5.5 or above the service provider automatically get registered and a facade `KeyValueStore::get('my_key')` will be available.

**3** - Now run the migration by `php artisan migrate` to create the 'key_value_store' table.

Optionally you can publish migration by running

```
php artisan vendor:publish --provider="FaithFM\KeyValueStore\KeyValueStoresServiceProvider" --tag="migrations"
```

### Getting Started

You can use helper function `key_value_store('my_key')` or `KeyValueStore::get('my_key')` to use laravel-key-value-store.

### Available methods

```php
// Pass `true` to ignore cached pairs
key_value_store()->all($fresh = false);

// Get a single pair
key_value_store()->get($key, $default = null);

// Set a single pair
key_value_store()->set($key, $value);

// Set a multiple pairs
key_value_store()->set([
   'key1' => 'my value',
   'my_email' => 'info@email.com',
]);

// check for key
key_value_store()->has($key);

// remove a key
key_value_store()->remove($key);
```

### Groups

From `v 1.0.6` You can organize your pairs into groups. If you skip the group name it will store pairs with `default` group name.

> If you are updating from previous version dont forget to run the migration

You have all above methods available just set you working group by calling `->group('group_name')` method and chain on:

```php
key_value_store()->group('team.1')->set('my_key', 'My Team App');
key_value_store()->group('team.1')->get('my_key');
> My Team App

key_value_store()->group('team.2')->set('my_key', 'My Team 2 App');
key_value_store()->group('team.2')->get('my_key');
> My Team 2 App

// You can use facade
\KeyValueStore::group('team.1')->get('my_key')
> My Team App
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

### Testing

The package contains some integration/smoke tests, set up with Orchestra. The tests can be run via phpunit.

```bash
$ composer test
```

### Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email saquibweb@gmail.com instead of using the issue tracker.

