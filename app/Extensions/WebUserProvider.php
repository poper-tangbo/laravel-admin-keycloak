<?php

namespace App\Extensions;

use Vizir\KeycloakWebGuard\Auth\KeycloakWebUserProvider;

class WebUserProvider extends KeycloakWebUserProvider
{
    public function retrieveByCredentials(array $credentials)
    {
        $user = $this->newModelQuery()
            ->where('email', $credentials['email'])
            ->first();
        if (empty($user)) {
            throw new \Exception('User not found');
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
