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
            __DIR__.'/config/feature-flags.php' => $this->app->make('path.config').'feature-flags',
        ]);

        $features = $this->app->make('config')->get('feature-flags');

        /*
        $features = [
            'id_checking'       => false,
            'company_formation' => true,
            'company_dashboard' => [
                'users'  => [123, 456],
                'groups' => ['beta', 'admin']
            ]
        ];
        */

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
