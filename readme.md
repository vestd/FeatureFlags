# Feature flags

## Installation

First, pull in the package through Composer.

```js
"require": {
    "vestd/feature-flags": "~1.0"
}
```

And then, if using Laravel 5, include the service provider within `app/config/app.php`.

```php
'providers' => [
    'Vestd\FeatureFlags\FeatureFlagServiceProvider'
];
```

## Usage in Laravel

Within your codebase use Laravel's dependency injection to load in the FeatureFlags container

```php
public function index(FeatureFlags $featureFlags)
{
    $feature = $featureFlags->get('new_home_page');

    if ($feature->isEnabled()) {
        view('new_homepage');
    } else {
        view('homepage');
    }
}
```
