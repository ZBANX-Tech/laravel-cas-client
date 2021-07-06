<?php


namespace Zbanx\CasClient\Http\Controllers;


use Illuminate\Routing\Controller;
use Zbanx\Kit\Common\JsonResponse;

class CommonController extends Controller
{
    use JsonResponse;

    public function routes(): \Illuminate\Http\JsonResponse
    {
        $routes = app('router')->getRoutes();
        $middleware = config('cas.middleware','cas.permission');
        $list = [];
        foreach ($routes as $route) {
            if (key_exists('middleware', $route->action)) {
                $middlewares = $route->action['middleware'];
                if (in_array($middleware, $middlewares))
                    $list[] = [
                        'uri' => $route->uri,
                        'methods' => $route->methods,
                        'label' => $route->action['as'],
                        'value' => $route->action['as']
                    ];
            }
        }
        return $this->success($list);
    }

}