<?php

class AuthController
{
    private $userModel;
    function __construct()
    {
        $this->userModel = new User();
    }

    function login()
    {
        if(!empty($_POST["username"]) && !empty($_POST["password"]))
        {
            $user = $this->userModel->getUserByUsername($_POST["username"]);
            if(!empty($user) && password_verify($_POST["password"], $user->password))
            {
                $newToken = $this->generateToken();
                $this->userModel->updateToken($user->id, $newToken);
                Response::json(["token" => $newToken]);
            }
            else
                Response::json(["error" => "Wrong Login Data!"], 400);
        }
        else
            Response::json(["error" => "Username and password can not be empty!"], 400);
    }

    function logout()
    {
        if(!empty($_POST["token"]))
            $user = $this->userModel->getUserByToken($_POST["token"]);

        if(!empty($user))
        {
            Response::json($this->userModel->removeToken($user->id));
        }
        else
            Response::json(["error" => "Invalid token."], 401);
    }

    function validateToken($token)
    {
        $user = $this->userModel->getUserByToken($token);
        if(!empty($user->token_expires_at))
        {
            $currentDate = date("Y-m-d H:i:s");
            if($user->token_expires_at > $currentDate) return true;
        }
        return false;
    }

    function generateToken()
    {
        return bin2hex(openssl_random_pseudo_bytes(32));
    }
}

?>