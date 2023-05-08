<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AuthController as BaseAuthController;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use Vizir\KeycloakWebGuard\Facades\KeycloakWeb;

class AuthController extends BaseAuthController
{
    public function getLogin()
    {
        $url = KeycloakWeb::getLoginUrl();
        KeycloakWeb::saveState();

        return redirect($url);
    }

    public function getLogout(Request $request)
    {
        $url = KeycloakWeb::getLogoutUrl();
        KeycloakWeb::forgetToken();
        return redirect($url);
    }

    public function getSetting(Content $content)
    {
        $url = sprintf('%s/realms/%s/account/#/personal-info', trim(config('keycloak-web.base_url'), '/'), config('keycloak-web.realm'));
        return redirect($url);
    }
}
