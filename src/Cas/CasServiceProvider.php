<?php namespace JuHeData\Cas;

use Illuminate\Support\ServiceProvider;

class CasServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('cas.php'),
        ], 'cas');

        $timestamp = date('Y_m_d_His', time());
        $this->publishes([
            __DIR__ . '/../database/create_cas_proxy_pgt_iou_table.php.stub' => database_path("/migrations/{$timestamp}_create_cas_proxy_pgt_iou_table.php"),
        ], 'migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('cas', function () {
            return new CasManager(config('cas'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['cas'];
    }

}
