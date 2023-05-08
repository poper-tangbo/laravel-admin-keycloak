<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Vizir\KeycloakWebGuard\Facades\KeycloakWeb;

class TestController extends Controller
{
    public function test(): string
    {
        $credentials = KeycloakWeb::retrieveToken();
        $credentials = KeycloakWeb::refreshAccessToken($credentials); // TODO:调试用

        $response = Http::withToken($credentials['access_token'])
            ->asForm()
            ->post('http://localhost:8080/realms/kcauth/protocol/openid-connect/token', [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:uma-ticket',
                'client_id' => config('keycloak-web.client_id'),
                'client_secret' => config('keycloak-web.client_secret'),
                'audience' => config('keycloak-web.client_id'),
                'response_mode' => 'decision',
                'permission' => 'test1',
            ]);
        dump($response->json());

        return '公共访问';
    }

    public function test1(): string
    {
        return 'test1';
    }

    public function test2(): string
    {
        return 'test2';
    }
}
