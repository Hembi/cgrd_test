<?php 

class News
{
    private $id;
    private $title;
    private $description;
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($title, $description)
    {
        try {
            $query = "INSERT INTO news (title, description) VALUES (:title, :description)";
            $statement = $this->db->prepare($query);
            return $statement->execute([":title" => $title, ":description" => $description]);
        }
        catch(Exception $e)
        {
            return "Error on create: ". $e->getMessage();
        }
    }

    public function fetch($id)
    {
        try {
            $query = "SELECT * FROM news WHERE id = :id";
            $statement = $this->db->prepare($query);
            $statement->execute([":id" => $id]);
            return $statement->fetch();
        }
        catch(Exception $e)
        {
            return "Error on fetch: ". $e->getMessage();
        }
    }
    
    public function fetchAll()
    {
        try
        {
            return $this->db->query("SELECT * FROM news")->fetchAll();
        }
        catch(Exception $e)
        {
            return "Error on fetchAll: ". $e->getMessage();
        }
    }

    public function update($id, $title, $description)
    {
        try
        {
            $query = "UPDATE news SET title=:title, description=:description WHERE id=:id";;
            $statement = $this->db->prepare($query);
            return $statement->execute([":id" => $id, ":title" => $title, ":description" => $description]);
        }
        catch(Exception $e)
        {
            return "Error on update: ". $e->getMessage();
        }
    }
    public function delete($id)
    {
        try
        {
            $query = "DELETE FROM news WHERE id = :id";
            $statement = $this->db->prepare($query);
            return $statement->execute([":id" => $id]);
        }
        catch(Exception $e)
        {
            return "Error on delete: ". $e->getMessage();
        }
    }
}

?>