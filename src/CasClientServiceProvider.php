<?php


namespace Zbanx\CasClient;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;


class CasClientServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        $this->registerPublishing();
        $this->registerRoutes();
    }


    private function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            //发布配置文件
            $this->publishes([
                __DIR__ . '/../config/cas.php' => config_path('cas.php'),
            ]);
        }
    }

    private function registerRoutes()
    {
        Route::group([
            'namespace' => 'Zbanx\CasClient\Http\Controllers',
            'prefix' => config('cas.prefix', 'cas'),
//            'middleware' => 'cas.sign',
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/cas.php');
        });
    }

}
