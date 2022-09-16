<?php

namespace Armincms\MobileApp;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Laravel\Nova\Nova as LaravelNova;
use Zareismail\Cypress\Cypress;
use Zareismail\Gutenberg\Gutenberg;

class ServiceProvider extends AuthServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->registerPolicies();
        // $this->conversions();
        $this->resources();
        // $this->components();
        $this->fragments();
        $this->widgets();
        $this->templates();
    }

    /**
     * Register the application's Nova resources.
     *
     * @return void
     */
    protected function resources()
    {
        LaravelNova::resources([
            Nova\Release::class,
        ]);
    }

    /**
     * Register the application's Gutenberg fragments.
     *
     * @return void
     */
    protected function fragments()
    {
        Gutenberg::fragments([]);
    }

    /**
     * Register the application's Gutenberg widgets.
     *
     * @return void
     */
    protected function widgets()
    {
        Gutenberg::widgets([
            \Armincms\MobileApp\Cypress\Widgets\ReleasesCard::class,
        ]);
    }

    /**
     * Register the application's Gutenberg templates.
     *
     * @return void
     */
    protected function templates()
    {
        Gutenberg::templates([
            \Armincms\MobileApp\Gutenberg\Templates\ReleasesCard::class,
        ]);
    }
}
