<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AuthController as BaseAuthController;
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
}
