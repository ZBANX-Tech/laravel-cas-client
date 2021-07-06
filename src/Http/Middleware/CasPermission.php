<?php


namespace Zbanx\CasClient\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $guard = config('cas.guard');
        $user = Auth::guard($guard)->user();
        if ($user == null) {
            return response()->json([
                'code' => -1,
                'message' => 'User is not logged in',
                'data' => null
            ], 401);
        }

        $routeName = $request->route()->action['as'];
        if ($user->hasPermission($routeName)) {
            return $next($request);
        }

        return response()->json([
            'code' => -1,
            'message' => 'The user does not exist or has no operational permission',
            'data' => null
        ], 403);
    }
}