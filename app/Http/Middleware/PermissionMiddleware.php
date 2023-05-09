<?php

namespace App\Http\Middleware;

use Closure;
use Encore\Admin\Auth\Permission as Checker;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Middleware\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Vizir\KeycloakWebGuard\Facades\KeycloakWeb;

class PermissionMiddleware extends Permission
{
    public function handle(Request $request, Closure $next, ...$args)
    {
        if (config('admin.check_route_permission') === false) {
            return $next($request);
        }

        if (!Admin::user() || !empty($args) || $this->shouldPassThrough($request)) {
            return $next($request);
        }

        $credentials = KeycloakWeb::retrieveToken();
        $baseUrl = sprintf('%s/realms/%s', trim(config('keycloak-web.base_url'), '/'), config('keycloak-web.realm'));
        $permission = sprintf('/%s#%s', request()->path(), request()->method());
        $response = Http::baseUrl($baseUrl)
            ->withToken($credentials['access_token'])
            ->asForm()
            ->post('/protocol/openid-connect/token', [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:uma-ticket',
                'client_id' => config('keycloak-web.client_id'),
                'client_secret' => config('keycloak-web.client_secret'),
                'audience' => config('keycloak-web.client_id'),
                'response_mode' => 'decision',
                'permission' => $permission,
            ]);

        if ($response->failed() || $response->json('result') !== true) {
            Checker::error();
        }

        return $next($request);
    }
}
