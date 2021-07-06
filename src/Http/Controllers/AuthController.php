<?php


namespace Zbanx\CasClient\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Zbanx\CasClient\Exceptions\CasClientException;
use Zbanx\CasClient\Uilts\HttpClient;
use Zbanx\Kit\Common\JsonResponse;

class AuthController extends Controller
{
    use JsonResponse;

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $ticket = $request->input('ticket');

        try {
            $client = new HttpClient();
            $response = $client->request('GET', "/api/tickets/{$ticket}");
        } catch (GuzzleException $exception) {
            return $this->error($exception->getMessage(), -2);
        } catch (CasClientException $exception) {
            return $this->error($exception->getMessage(), -3);
        }

        if ($response['code'] != 0) {
            return $this->error($response['message'], -1);
        }

        $guard = config('cas.guard');
        $token = auth($guard)->attempt([
            'id' => $response['account_id']
        ]);

        $user = auth($guard)->user();

        return $this->success([
            'user' => $user,
            'permissions' => $response['permissions'],
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