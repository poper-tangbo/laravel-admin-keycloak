<?php

namespace App\Extensions;

use Illuminate\Contracts\Auth\Authenticatable;

class AdminUserProvider extends WebUserProvider
{
    /**
     * @param array $credentials
     * @return ?Authenticatable
     */
    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        $user = $this->newModelQuery()
            ->where('username', $credentials['preferred_username'])
            ->first();
        if (empty($user)) {
            $user = $this->createModel();
            $user->username = $credentials['preferred_username'];
            $user->name = $credentials['family_name'] . $credentials['given_name'];
            $user->password = 'no-password';
            $user->save();
        }
        return $user;
    }

}