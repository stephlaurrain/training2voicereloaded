<?php

class ExerciceTrainingRepository {

    protected $db;

    public function __construct($rel_path) {
        include_once ($rel_path . "/dalibrary/entities/ExerciceTraining.php");
        $res =include ($rel_path . "/dalibrary/connection.php");
        $_rel_path = $rel_path;
        $res=include ($rel_path . "/init.php");
        $logger->debug("=exerciceTraining repository=");
        $this->db = $db;
    }

    private function read($row) {
        $result = new ExerciceTraining();
        $result->id = intval($row["id"]);
        $result->exercice_id = intval($row["exercice_id"]);
        $result->training_id = intval($row["training_id"]);
        $result->tmp = intval($row["tmp"]);
        $result->nb_series = intval($row["nb_series"]);
        $result->nb_repetitions = intval($row["nb_repetitions"]);
        $result->poids = intval($row["poids"]);
        $result->tmp_repos = intval($row["tmp_repos"]);
        $result->tmp_prepa = intval($row["tmp_prepa"]);
        $result->pds_deg = intval($row["pds_deg"]);
        $result->tmp_deg = intval($row["tmp_deg"]);
        $result->description = $row["description"];
        $result->commentaire = $row["commentaire"];
        $result->goto = intval($row["goto"]);
        $result->nb_goto = intval($row["nb_goto"]);
        $result->idx = intval($row["idx"]);
        $result->zone = $row["zone"];
        $result->discipline = $row["discipline"];
        $result->mode = $row["mode"];
        $result->accessoire = $row["accessoire"];
        return $result;
    }

    public function getById($id) {
        $sql = "SELECT * FROM exercice_training WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindValue("id", $id, PDO::PARAM_INT);
        $q->execute();
        $rows = $q->fetchAll();
        return $this->read($rows[0]);
    }

    private function getSqlAll() {
        $sql = "SELECT et.id, et.training_id, et.exercice_id, et.tmp, et.nb_series, et.nb_repetitions, et.poids,
             et.tmp_repos, et.tmp_prepa, et.pds_deg, et.tmp_deg, et.idx, et.goto, et.nb_goto, 
             ex.description, et.commentaire,
             accessoire.intitule accessoire,
             mode.intitule mode,
             discipline.intitule discipline,
             zone.intitule zone
            FROM exercice_training et
            inner join training t on et.training_id = t.id
            inner join exercice ex on et.exercice_id = ex.id
            left join accessoire on ex.accessoire_id=accessoire.id
            left join mode on ex.mode_id=mode.id
            left join discipline on ex.discipline_id=discipline.id
            left join zone on ex.zone_id=zone.id";
        return $sql;
    }

    public function getByTrainingId($filter) {
        $sql = $this->getSqlAll() . " where training_id = :training_id order by idx";       
        $q = $this->db->prepare($sql);
        $training_id = intval($filter["training_id"]);
        $q->bindValue("training_id", $training_id, PDO::PARAM_INT);
        $q->execute();
        $error = $q->errorInfo();
        $rows = $q->fetchAll();
        $result = array();
        foreach ($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }

    public function getAll() {

        $sql = $this->getSqlAll();
        $q = $this->db->prepare($sql);
        $q->execute();
        $rows = $q->fetchAll();

        $result = array();
        foreach ($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }

    public function getMaxIdx($filter) {
        $sql = "select max(idx) maxid from exercice_training where training_id=:training_id";
        $q = $this->db->prepare($sql);
        $training_id = intval($filter["training_id"]);
        $q->bindValue("training_id", $training_id, PDO::PARAM_INT);
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
        $sql = "INSERT INTO exercice_training (exercice_id, training_id, commentaire, 
                 nb_repetitions, nb_series, pds_deg,poids, tmp, tmp_deg,tmp_prepa,tmp_repos,idx) 
                 VALUES (:exercice_id, :training_id, :commentaire, 
                 :nb_repetitions,:nb_series,:pds_deg,:poids,:tmp,:tmp_deg,:tmp_prepa,:tmp_repos,:idx)";
        $q = $this->db->prepare($sql);
        $q->bindValue("exercice_id", $data["exercice_id"], PDO::PARAM_INT);
        $q->bindValue("training_id", $data["training_id"], PDO::PARAM_INT);
        $q->bindValue("commentaire", $data["commentaire"]);
        $q->bindValue("nb_repetitions", $data["nb_repetitions"], PDO::PARAM_INT);
        $q->bindValue("nb_series", $data["nb_series"], PDO::PARAM_INT);
        $q->bindValue("pds_deg", $data["pds_deg"], PDO::PARAM_INT);
        $q->bindValue("poids", $data["poids"], PDO::PARAM_INT);
        $q->bindValue("tmp", $data["tmp"], PDO::PARAM_INT);
        $q->bindValue("tmp_deg", $data["tmp_deg"], PDO::PARAM_INT);
        $q->bindValue("tmp_prepa", $data["tmp_prepa"], PDO::PARAM_INT);
        $q->bindValue("tmp_repos", $data["tmp_repos"], PDO::PARAM_INT);
        $q->bindValue("idx", $data["idx"], PDO::PARAM_INT);
        $q->execute();
        $res = $this->getById($this->db->lastInsertId());
        return $res;
    }

    public function update($data) {

        $sql = "UPDATE exercice_training SET 
                tmp = :tmp, nb_series = :nb_series, nb_repetitions = :nb_repetitions, poids = :poids,
                tmp_repos = :tmp_repos, tmp_prepa = :tmp_prepa, pds_deg = :pds_deg, tmp_deg = :tmp_deg,
                goto = :goto,nb_goto = :nb_goto,commentaire = :commentaire 
                WHERE id = :id";

        $q = $this->db->prepare($sql);
        $q->bindValue("id", $data["id"], PDO::PARAM_INT);
        $q->bindValue("tmp", $data["tmp"], PDO::PARAM_INT);
        $q->bindValue("nb_series", $data["nb_series"], PDO::PARAM_INT);
        $q->bindValue("nb_repetitions", $data["nb_repetitions"], PDO::PARAM_INT);
        $q->bindValue("poids", $data["poids"], PDO::PARAM_INT);
        $q->bindValue("tmp_repos", $data["tmp_repos"], PDO::PARAM_INT);
        $q->bindValue("tmp_prepa", $data["tmp_prepa"], PDO::PARAM_INT);
        $q->bindValue("pds_deg", $data["pds_deg"], PDO::PARAM_INT);
        $q->bindValue("tmp_deg", $data["tmp_deg"], PDO::PARAM_INT);
        $q->bindValue("goto", $data["goto"], PDO::PARAM_INT);
        $q->bindValue("nb_goto", $data["nb_goto"], PDO::PARAM_INT);
        $q->bindValue("commentaire", $data["commentaire"], PDO::PARAM_STR);
        $q->execute();
    }

    public function updateIdx($data) {

        $sql = "UPDATE exercice_training SET 
                idx=:idx
                WHERE id = :id";

        $q = $this->db->prepare($sql);
        $q->bindValue("id", $data["id"], PDO::PARAM_INT);
        $q->bindValue("idx", $data["idx"], PDO::PARAM_INT);
        
        $q->execute();
    }

    public function remove($id) {
        $sql = "DELETE FROM exercice_training WHERE id = :id";
        try {
            $q = $this->db->prepare($sql);
            $q->bindValue("id", $id, PDO::PARAM_INT);
            $res = $q->execute();
            $error = $q->errorInfo();
        } catch (PDOException $e) {
            $logger->debug("=exercicetraining repository remove" . $e->getMessage());
            return false;
        }
    }

}

?>