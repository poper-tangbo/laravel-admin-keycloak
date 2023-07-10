<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Vizir\KeycloakWebGuard\Facades\KeycloakWeb;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('healthy', fn() => 'ok');

Route::get('t', fn() => '1688975013');

Route::get('/', function () {
    return view('welcome');
});

Route::get('register', function () {
    $url = KeycloakWeb::getRegisterUrl();
    KeycloakWeb::saveState();
    return redirect($url);
})->name('keycloak.register');

Route::middleware('auth')->get('home', function () {
    /** @var User $user */
    $user = Auth::user();

    $logoutUrl = route('keycloak.logout');
    $content = <<<EOT
<h1>用户信息</h1>
<p>
    <label>姓名：</label>
    <span>$user->name</span>
</p>
<p>
    <label>邮箱：</label>
    <span>$user->email</span>
</p>
<p>
    <a href="$logoutUrl">退出</a>
</p>
EOT;

    return response($content);
});
