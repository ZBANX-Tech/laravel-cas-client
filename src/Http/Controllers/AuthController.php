<?php


namespace Zbanx\CasClient\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Zbanx\CasClient\Uilts\HttpClient;
use Zbanx\Kit\Common\JsonResponse;

class AuthController extends Controller
{
    use JsonResponse;

    /**
     * @throws GuzzleException
     */
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $ticket = $request->input('ticket');

        $client = new HttpClient();
        $res = $client->request('POST', "/tickets/{$ticket}");

        $guard = config('cas.guard');
        $token = auth($guard)->attempt([
            'id' => $res['account_id']
        ]);

        $user = auth($guard)->user();

        return $this->success([
            'user' => $user,
            'permissions' => $res['permissions'],
            'token' => $token,
            'ttl' => config('cas.ttl')
        ]);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        $guard = config('cas.guard');
        auth($guard)->logout();
        return $this->success();
    }
}