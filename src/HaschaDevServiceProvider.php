<?php

namespace HaschaDev;

use HaschaDev\Dev;
use HaschaDev\HaschaMedia;
use HaschaDev\Contracts\Page\Pageable;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use HaschaDev\Services\Page\PageService;
use HaschaDev\Support\Handler as DevHandler;
use Illuminate\Contracts\Foundation\Application;

class HaschaDevServiceProvider extends ServiceProvider
{
    public array $singletons = [
        Dev::class => DevHandler::class,
        Pageable::class => PageService::class
    ];

    public function register(): void
    {
        $this->app->singleton(Dev::class, function (){
            return new DevHandler();
        });
    }
    
    public function boot(): void
    {
        /**
         * config to publish
         * 
         */
        $this->publishes([
            __DIR__.'/../config/haschadev.php' => config_path('haschadev.php'),
        ], 'haschadev-config');

        /**
         * config to join
         * 
         */
        $this->mergeConfigFrom(
            __DIR__.'/../config/haschadev.php', 'haschadev'
        );

        $kernel = $this->app->make(Kernel::class);
        $kernel->appendMiddlewareToGroup('web', \HaschaDev\Http\Middleware\Tracer::class);

        /**
         * Blade Templating
         * 
         */
        HaschaMedia::bladeTemplates();

        /**
         * Observers
         */
        HaschaMedia::observers();

        /**
         * reset app/config.php
         */
        Config::set('app.name', HaschaMedia::appName());

        /**
         * via Composers
         * 
         */
        \Illuminate\Support\Facades\View::composer('*', function (\Illuminate\View\View $view) {
            $pageable = $this->app->make(Pageable::class);
            $view->with('pageable', $pageable);
        });
    }
}
