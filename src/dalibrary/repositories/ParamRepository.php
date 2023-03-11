<?php

class ParamRepository {

    protected $db;

    public function __construct($rel_path) {
        include ($rel_path . "/dalibrary/entities/Param.php");
        include ($rel_path . "/dalibrary/connection.php");
        $this->db = $db;
    }

    private function read($row) {
        $result = new Param();
        $result->id = intval($row["id"]);
        $result->cle = $row["cle"];
        $result->valeur = $row["valeur"];
        return $result;
    }

    public function getById($id) {
        $sql = "SELECT * FROM param WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindValue("id", $id, PDO::PARAM_INT);
        $q->execute();
        $rows = $q->fetchAll();
        return $this->read($rows[0]);
    }

    public function getAll() {
        $sql = "SELECT * FROM param";
        $q = $this->db->prepare($sql);
        $q->execute();
        $rows = $q->fetchAll();

        $result = array();
        foreach ($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }

    public function getByFilter($filter) {
        $cle = "%" . $filter["cle"] . "%";
        $valeur = "%" . $filter["valeur"] . "%";
        $sql = "SELECT * FROM param WHERE cle LIKE :cle and valeur like :valeur";
        $q = $this->db->prepare($sql);
        $q->bindValue("cle", $cle, PDO::PARAM_STR);
        $q->bindValue("valeur", $valeur, PDO::PARAM_STR);
        $q->execute();
        $rows = $q->fetchAll();

        $result = array();
        foreach ($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }

    public function insert($data) {
        $sql = "INSERT INTO param (cle, valeur) VALUES (:cle,:valeur)";
        $q = $this->db->prepare($sql);
        $q->bindValue("cle", $data["cle"]);
        $q->bindValue("valeur", $data["valeur"]);
        $q->execute();
        $res = $this->getById($this->db->lastInsertId());
        return $res;
    }

    public function update($data) {
        $sql = "UPDATE param SET cle = :cle, valeur = :valeur WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindValue("cle", $data["cle"]);
        $q->bindValue("valeur", $data["valeur"]);
        $q->bindValue("id", $data["id"], PDO::PARAM_INT);
        $q->execute();
    }

    public function remove($id) {
        $sql = "DELETE FROM param WHERE id = :id";
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