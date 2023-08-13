<?php 

class User
{
    private $id;
    private $username;
    private $password;
    private $token;
    private $token_expires_at;
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getUserByUsername($username)
    {
        try {
            $query = "SELECT * FROM users WHERE username = :username";
            $statement = $this->db->prepare($query);
            $statement->execute([":username" => $username]);
            return $statement->fetch();
        }
        catch(Exception $e)
        {
            return "Error on fetch: ". $e->getMessage();
        }
    }

    public function getUserByToken($token)
    {
        try {
            $query = "SELECT * FROM users WHERE token = :token";
            $statement = $this->db->prepare($query);
            $statement->execute([":token" => $token]);
            return $statement->fetch();
        }
        catch(Exception $e)
        {
            return "Error on fetch: ". $e->getMessage();
        }
    }

    public function checkTokenExists($token)
    {
        $query = "SELECT * FROM users WHERE token = :token";
        $statement = $this->db->prepare($query);
        $statement->execute([":token" => $token]);
        return $statement->rowCount();
    }

    public function updateToken($id, $token)
    {
        $query = "UPDATE users SET token=:token, token_expires_at=DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE id = :id";
        $statement = $this->db->prepare($query);
        $statement->execute([":id" => $id, ":token" => $token]);
        return $statement->rowCount();
    }

    public function removeToken($id)
    {
        $query = "UPDATE users SET token=NULL WHERE id = :id";
        $statement = $this->db->prepare($query);
        $statement->execute([":id" => $id]);
        return $statement->rowCount();
    }
}

?>