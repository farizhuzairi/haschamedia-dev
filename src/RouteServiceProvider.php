<?php

namespace HaschaDev;

use EMS\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function register(): void
    {}
    
    public function boot(): void
    {
        $this->mapWebRoutes();
        $this->mapApiRoutes();
        $this->mapConsoleRoutes();
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->group(__DIR__.'/../routes/web.php');
    }

    protected function mapApiRoutes()
    {
        Route::prefix('host')
            ->middleware('api')
            ->group(__DIR__.'/../routes/api.php');
    }

    protected function mapConsoleRoutes()
    {
        require __DIR__.'/../routes/console.php';
    }
}
