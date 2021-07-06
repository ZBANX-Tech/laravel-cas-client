<?php


namespace Zbanx\CasClient\Http\Controllers;


use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Zbanx\Kit\Common\JsonResponse;

class CommonController extends Controller
{
    use JsonResponse;

    public function routes(): \Illuminate\Http\JsonResponse
    {
        $routes = app('routes');
        dd($routes);
        $routes = app()->routes->getRoutes();
        $list = [];
        foreach ($routes as $route) {
            if (key_exists('middleware', $route->action)) {
                $middleware = $route->action['middleware'];
                foreach (Arr::wrap($middleware) as $item) {
                    if (Str::startsWith($item, 'rbac.check:')) {
                        $list[] = [
                            'uri' => $route->uri,
                            'methods' => $route->methods,
                            'label' => $route->action['description'] ?? explode(':', $item)[1],
                            'value' => explode(':', $item)[1]
                        ];
                    }
                }
            }
        }
        return $this->success($list);
    }

}