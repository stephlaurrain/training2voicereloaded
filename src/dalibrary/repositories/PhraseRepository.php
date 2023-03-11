<?php

class PhraseRepository {

    protected $db;

    public function __construct($rel_path) {
        include ($rel_path . "/dalibrary/entities/Phrase.php");
        include ($rel_path . "/dalibrary/connection.php");
        $this->db = $db;
    }

    private function read($row) {
        $result = new Phrase();
        $result->id = intval($row["id"]);
        $result->texte = $row["texte"];
        return $result;
    }

    public function getById($id) {
        $sql = "SELECT * FROM phrase WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindValue("id", $id, PDO::PARAM_INT);
        $q->execute();
        $rows = $q->fetchAll();
        return $this->read($rows[0]);
    }

    public function getAll() {        
        $sql = "SELECT * FROM phrase";  
        $q = $this->db->prepare($sql);        
        $q->execute();
        $rows = $q->fetchAll();
        $result = array();
        foreach($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }
    
    public function getByFilter($filter) {
        $texte = "%" . $filter["texte"] . "%";        
        $sql = "SELECT * FROM phrase WHERE texte LIKE :texte";  
        $q = $this->db->prepare($sql);
        $q->bindValue('texte', $texte,PDO::PARAM_STR);
        $q->execute();
        $rows = $q->fetchAll();

        $result = array();
        foreach($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }

    public function insert($data) {
        $sql = "INSERT INTO phrase (texte) VALUES (:texte)";                
        $q = $this->db->prepare($sql);
        $q->bindValue("texte", $data["texte"]);
        $q->execute();
        $res=$this->getById($this->db->lastInsertId());
        return $res;
    }

    public function update($data) {
        $sql = "UPDATE phrase SET texte = :texte WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindValue("texte", $data["texte"]);
        $q->bindValue("id", $data["id"], PDO::PARAM_INT);
        $q->execute();
    }

    public function remove($id) {
        $sql = "DELETE FROM phrase WHERE id = :id";      
        try
        {
         $q = $this->db->prepare($sql);
         $q->bindValue("id", $id, PDO::PARAM_INT);
         $q->execute();
        }
       catch(PDOException $e)
        {        
        echo "Statement failed: " . $e->getMessage();
        return false;
        }
}

}

?>