<?php

namespace models;

use components\Model;
use library\User;

class Users extends Model {

    protected $table = 'users';

    public function getUserByUserName($username) {
        $user_data = $this->getWhere('username', $username);

        if ($user_data) {
            return new User($user_data);
        } else {
            return null;
        }
    }
}