<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 */

namespace Larva\Live;

use Illuminate\Support\Manager;
use Illuminate\Support\ServiceProvider;
use Larva\Live\Contracts\Factory;

/**
 * Class LiveServiceProvider
 * @author Tongle Xu <xutongle@gmail.com>
 */
class LiveServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/live.php' => config_path('live.php'),
            ], 'live-config');
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if (!$this->app->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__ . '/../config/live.php', 'live');
        }

        $this->app->singleton(Factory::class, function ($app) {
            return new LiveManager($app);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [Factory::class];
    }
}