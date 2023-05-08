<?php

namespace App\Extensions;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Log;
use Vizir\KeycloakWebGuard\Auth\KeycloakWebUserProvider;

class WebUserProvider extends KeycloakWebUserProvider
{
    /**
     * @param array $credentials
     * @return ?Authenticatable
     */
    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        $user = $this->newModelQuery()
            ->where('email', $credentials['email'])
            ->first();
        if (empty($user)) {
            $user = $this->createModel();
            $user->email = $credentials['email'];
            $user->name = $credentials['family_name'] . $credentials['given_name'];
            $user->password = 'no-password';
            $user->save();
        }
        return $user;
    }

    protected function newModelQuery($model = null)
    {
        return is_null($model)
            ? $this->createModel()->newQuery()
            : $model->newQuery();
    }

    public function createModel()
    {
        $class = '\\' . ltrim($this->model, '\\');

        return new $class;
    }

}
