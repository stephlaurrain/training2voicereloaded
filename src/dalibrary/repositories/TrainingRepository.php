<?php

class TrainingRepository {

    protected $db;

    public function __construct($rel_path) {
        include_once ($rel_path . "/dalibrary/entities/Training.php");
        include ($rel_path . "/dalibrary/connection.php");
        $_rel_path = $rel_path;
        include ($rel_path . "/init.php");
        $logger->debug("=training repository=");
        $this->db = $db;
    }

    private function read($row) {
        $result = new Training();
        $result->id = intval($row["id"]);
        
        $result->date_creation = $row["date_creation"];
        $result->description = $row["description"];
        $result->commentaire = $row["commentaire"];
        $result->modele = $row["modele"];
        $result->heure_fin = $row["heure_fin"];        
        $result->eval = $row["eval"];
        $result->idx = intval($row["idx"]);
        return $result;
    }

    public function getById($id) {
        $sql = "SELECT * FROM training WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindValue("id", $id, PDO::PARAM_INT);
        $q->execute();
        $rows = $q->fetchAll();
        return $this->read($rows[0]);
    }

    public function getByFilter($filter) {
        $description = "%" . $filter["description"] . "%";

        $sql = "SELECT * FROM training WHERE description LIKE :description order by idx";
        $q = $this->db->prepare($sql);
        $q->bindValue('description', $description, PDO::PARAM_STR);
        $q->execute();
        $rows = $q->fetchAll();

        $result = array();
        foreach ($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }

     public function getMaxIdx() {
        $sql = "select max(idx) maxid from training";
        $q = $this->db->prepare($sql);        
        $q->execute();
        $error = $q->errorInfo();
        $rows = $q->fetchAll();
        if (count($rows) === 0) {
            $res = 0;
        } else {
            $res = intval($rows[0]['maxid']);
        }
        return $res;
    }
    
    public function insert($data) {
        $sql = "INSERT INTO training (description, commentaire, date_creation, idx) VALUES (:description, :commentaire, now(), :idx)";
        $q = $this->db->prepare($sql);
        $q->bindValue("description", $data["description"]);
        $q->bindValue("commentaire", $data["commentaire"]);
        $q->bindValue("idx", $data["idx"], PDO::PARAM_INT);
        $q->execute();
        $error = $q->errorInfo();
        $res = $this->getById($this->db->lastInsertId());
        return $res;
    }

    public function update($data) {
        $sql = "UPDATE training SET description = :description, commentaire = :commentaire WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindValue("description", $data["description"]);
        $q->bindValue("commentaire", $data["commentaire"]);
        $q->bindValue("id", $data["id"], PDO::PARAM_INT);
        $prout = $q->execute();
        $error = $q->errorInfo();
    }
    
    public function updateIdx($data) {

        $sql = "UPDATE training SET 
                idx=:idx
                WHERE id = :id";

        $q = $this->db->prepare($sql);
        $q->bindValue("id", $data["id"], PDO::PARAM_INT);
        $q->bindValue("idx", $data["idx"], PDO::PARAM_INT);
        
        $q->execute();
    }

    public function remove($id) {
        $sql = "DELETE FROM training WHERE id = :id";
        try {
            $q = $this->db->prepare($sql);
            $q->bindValue("id", $id, PDO::PARAM_INT);
            $q->execute();
        } catch (PDOException $e) {
            $logger->debug("=training repository=" . $e->getMessage());
            return false;
        }
    }

}

?>