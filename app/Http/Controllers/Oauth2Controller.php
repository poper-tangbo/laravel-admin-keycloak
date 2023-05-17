<?php

namespace App\Http\Controllers;

use App\Extensions\Keycloak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vizir\KeycloakWebGuard\Exceptions\KeycloakCallbackException;

class Oauth2Controller extends Controller
{
    public function signIn()
    {
        $k = new Keycloak();
        $url = $k->getLoginUrl();

        return redirect($url);
    }

    public function signOut()
    {
        $k = new Keycloak();
        $url = $k->getLogoutUrl();
        $k->forgetToken();
        return redirect($url);
    }

    public function callback(Request $request)
    {
        // Check for errors from Keycloak
        if (!empty($request->input('error'))) {
            $error = $request->input('error_description');
            $error = ($error) ?: $request->input('error');

            throw new KeycloakCallbackException($error);
        }

        $k = new Keycloak();
        // Check given state to mitigate CSRF attack
        // Change code for token
        $code = $request->input('code');
        if (!empty($code)) {
            $token = $k->getAccessToken($code);

            if (Auth::validate($token)) {
                return redirect('http://localhost:8181');
            }
        }

        return redirect(route('keycloak.login'));
    }

    public function auth()
    {
        if (Auth::check()) {
            $headers = [];
            $users = config('users.kibana');
            $access = [];
            foreach ($users as $item) {
                if (!empty($item['emails']) && !empty($item['access']) && in_array(Auth::id(), $item['emails'])) {
                    $access = $item['access'];
                    break;
                }
            }

            if (!empty($access['username']) && !empty($access['password'])) {
                $authStr = base64_encode($access['username'] . ':' . $access['password']);
                $headers['X-Auth-Request-Basic-Auth'] = 'Basic ' . $authStr;
            }
            return response('', 200, $headers);
        }

        return response('Unauthorized.', 401);
    }
}
