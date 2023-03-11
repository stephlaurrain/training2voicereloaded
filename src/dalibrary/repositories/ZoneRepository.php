<?php

class ZoneRepository {

    protected $db;

    public function __construct($rel_path) {
        include ($rel_path."/dalibrary/entities/Zone.php");
        include ($rel_path . "/dalibrary/connection.php"); 
        $this->db = $db;
    }

    private function read($row) {
        $result = new Zone();
        $result->id = intval($row["id"]);
        $result->intitule = $row["intitule"];
        return $result;
    }

    public function getById($id) {
        $sql = "SELECT * FROM zone WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindValue("id", $id, PDO::PARAM_INT);
        $q->execute();
        $rows = $q->fetchAll();
        return $this->read($rows[0]);
    }

    public function getByFilter($filter) {
        $intitule = "%" . $filter["intitule"] . "%";
        $sql = "SELECT * FROM zone WHERE intitule LIKE :intitule order by intitule";
        $q = $this->db->prepare($sql);
        $q->bindValue('intitule', $intitule, PDO::PARAM_STR);
        $q->execute();
        $rows = $q->fetchAll();

        $result = array();
        foreach ($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }

    public function insert($data) {
        $sql = "INSERT INTO zone (intitule) VALUES (:intitule)";
        $q = $this->db->prepare($sql);
        $q->bindValue("intitule", $data["intitule"]);
        $q->execute();
        $res = $this->getById($this->db->lastInsertId());
        return $res;
    }

    public function update($data) {
        $sql = "UPDATE zone SET intitule = :intitule WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindValue("intitule", $data["intitule"]);
        $q->bindValue("id", $data["id"], PDO::PARAM_INT);
        $q->execute();
    }

    public function remove($id) {
        $sql = "DELETE FROM zone WHERE id = :id";
        try {
            $q = $this->db->prepare($sql);
            $q->bindValue("id", $id, PDO::PARAM_INT);
            $q->execute();
        } catch (PDOException $e) {
            echo "Statement failed: " . $e->getMessage();
            return false;
        }
    }

}

?>