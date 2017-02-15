<?php

namespace library;

class User
{
    private $username;
    private $password;

    public function __construct($user_data = array()) {
        if ($user_data) {
            $this->setFromArray($user_data);
        }
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return base64_decode($this->password);
    }

    public function setPassword($password) {
        $this->password = base64_encode($password);
    }

    public function setFromArray($args) {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}