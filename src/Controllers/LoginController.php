<?php

class LoginController
{
    private $userModel;
    function __construct()
    {
        $userModel = new User();
    }

    function login($username, $password)
    {
        $user = $this->userModel->getUserByUsername($username);
        if(!empty($user) && password_verify($password, $user->password))
        {
            $newToken = $this->generateToken();
            $this->userModel->updateToken($user->id, $newToken);
            Response::json(["token" => $newToken]);
        }
        else
            Response::json(["error" => "Username or password incorrect."], 400);
    }

    function validateToken($token)
    {
        $user = $this->userModel->getUserByToken($token);
        if(!empty($user))
        {
            $currentDate = date("Y-m-d H:i:s");
            $tokenExpiration = date("Y-m-d H:i:s", $user->token_expiration);
            if($tokenExpiration > $currentDate) return true;
        }
        return false;
    }

    function generateToken()
    {
        return bin2hex(openssl_random_pseudo_bytes(32));
    }
}

?>