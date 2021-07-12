<?php


namespace Zbanx\CasClient;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Zbanx\CasClient\Http\Middleware\CasPermission;


class CasClientServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        $this->registerPublishing();
        $this->registerRoutes();
        $this->aliasMiddleware();
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

    /**
     * Alias the middleware.
     *
     * @return void
     */
    protected function aliasMiddleware()
    {
        $router = $this->app['router'];

        $method = method_exists($router, 'aliasMiddleware') ? 'aliasMiddleware' : 'middleware';

        $middlewareAliases = [
            'cas.permission' => CasPermission::class,
        ];
        foreach ($middlewareAliases as $alias => $middleware) {
            $router->$method($alias, $middleware);
        }
    }
}
