# Feature flags

This is a basic Laravel 5 package for implementing feature flags.

## Installation

First, pull in the package through Composer.

```bash
composer require vestd/feature-flags
```

And then, if using Laravel 5, include the service provider within `app/config/app.php`.

```php
'providers' => [
    Vestd\FeatureFlags\FeatureFlagServiceProvider::class
];
```

And finally publish the config file, this will be where you put the feature flag configuration

```bash
php artisan vendor:publish --provider="Vestd\FeatureFlags\FeatureFlagServiceProvider"
```

## Usage in Laravel

Within your codebase use Laravel's dependency injection to load in the FeatureFlags container.
You can then call the get method to retrieve a previously configured feature flag.
If the flag doesn't exist an exception will be thrown.

```php
public function index(FeatureCollection $featureCollection)
{
    $feature = $featureCollection->get('new_home_page');

    if ($feature->isEnabled()) {
        view('new_homepage');
    } else {
        view('homepage');
    }
}
```

## Configuration

In its simplest form the configuration file will allow to to specify a key and a true or false flag

```php
  'feature_a' => true,
  'feature_b' => false,
```

The alternative method is an associative array for the keys, using this method you can specify which users or
groups would have access to the feature

```php

  'feature_c' => [
    'users'  => [123, 456],
    'groups' => ['admin', 'beta'],
  ]

```
If you use the more complex features you can check the state by using the following isEnabled checks

```php
public function index(FeatureFlags $featureFlags)
{
    $feature = $featureFlags->get('new_home_page');

    if ($feature->isEnabledForUser(456) || $feature->isEnabledForGroup('admin')) {
        view('new_homepage');
    } else {
        view('homepage');
    }
}
```


## Coming soon

The ability to configure the flags through a method other than a fixed config file, i.e. a database


## Contributing

Contributions are accepted but this package is being developed primarily for use within the Vestd app so if you use case
differs to much from what we need it may not be accepted.