<?php


namespace Zbanx\CasClient\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Zbanx\CasClient\Account;
use Zbanx\CasClient\Exceptions\CasClientException;
use Zbanx\CasClient\Uilts\CasCache;
use Zbanx\CasClient\Uilts\HttpClient;
use Zbanx\Kit\Common\JsonResponse;

class AuthController extends Controller
{
    use JsonResponse;

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        if ($request->filled('ticket')) {
            $response = $this->loginWithTicket($request->input('ticket'));
        } elseif ($request->filled('account') && $request->filled('password')) {
            $response = $this->loginWithPassword($request->all(['account', 'password']));
        }
        if ($response['code'] != 0) {
            return $this->error($response['message'], -1);
        }

        $auth = config('cas.auth');

        $user = $auth['model']::query()->find($response['data']['account_id']);

        if (!$user) {
            // 账号不存在则创建新账号
            $account = new Account($response['data']['account']);
            $user = $auth['model']::createAccount($account);
        }

        $token = auth($auth['guard'])->login($user);

        CasCache::setPermissions($response['data']['account_id'], $response['data']['permissions']);
        $ticket = $request->filled('ticket') ? $request->get('ticket') : $response['data']['ticket'];
        CasCache::setUserTicket($response['data']['account_id'], $ticket);

        return $this->success([
            'user' => $user,
            'permissions' => $response['data']['permissions'],
            'token' => $token,
            'ttl' => config('cas.ttl')
        ]);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        $guard = config('cas.auth.guard');
        $user_id = auth($guard)->id();
        $ticket = CasCache::getUserTicket($user_id);
        auth($guard)->logout();
        CasCache::delPermissions($user_id);

        if (!empty($ticket)) {
            try {
                $client = new HttpClient();
                $client->request('DELETE', "/api/tickets/{$ticket}");
            } catch (CasClientException | GuzzleException $e) {

            }
        }

        return $this->success();
    }

    private function loginWithTicket($ticket)
    {
        try {
            $client = new HttpClient();
            $response = $client->request('GET', "/api/tickets/{$ticket}");
        } catch (GuzzleException $exception) {
            return $this->error($exception->getMessage(), -2);
        } catch (CasClientException $exception) {
            return $this->error($exception->getMessage(), -3);
        }

        return $response;
    }

    private function loginWithPassword($data)
    {
        try {
            $client = new HttpClient();
            $response = $client->request('POST', "/api/login", [
                'body' => $data
            ]);
        } catch (GuzzleException $exception) {
            return $this->error($exception->getMessage(), -2);
        } catch (CasClientException $exception) {
            return $this->error($exception->getMessage(), -3);
        }
        return $response;
    }
}