<?php

namespace Vestd\FeatureFlags;


use Illuminate\Support\ServiceProvider;
use Vestd\Models\FeatureFlags;

class FeatureFlagServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/feature-flags.php' => $this->app->make('path.config').'/feature-flags.php',
        ]);

        //Fetch the flags from the config file and register a singleton feature collection for them

        $features = $this->app->make('config')->get('feature-flags');

        $this->app->singleton(FeatureCollection::class, function() use($features) {
            $featureFlags = new FeatureCollection();

            $featureFlags->setFeatures($features);

            return $featureFlags;
        });

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
