# Feature flags

## Installation

First, pull in the package through Composer.

```bash
composer require vestd/feature-flags
```

And then, if using Laravel 5, include the service provider within `app/config/app.php`.

```php
'providers' => [
    'Vestd\FeatureFlags\FeatureFlagServiceProvider'
];
```

And finally publish the config file, this will be where you put the feature flag configuration

```bash
php artisan vendor:publish --provider="Vestd\FeatureFlags\FeatureFlagServiceProvider"
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
