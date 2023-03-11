<?php

class ExerciceRepository {

    protected $db;

    public function __construct($rel_path) {
        include ($rel_path . "/dalibrary/entities/Exercice.php");
        include ($rel_path . "/dalibrary/connection.php");
        $this->db = $db;
    }

    private function read($row) {
        $result = new Exercice();
        $result->id = intval($row["id"]);
        $result->tmp = intval($row["tmp"]);
        $result->nb_series = intval($row["nb_series"]);
        $result->nb_repetitions = intval($row["nb_repetitions"]);
        $result->poids = intval($row["poids"]);
        $result->tmp_repos = intval($row["tmp_repos"]);
        $result->tmp_prepa = intval($row["tmp_prepa"]);
        $result->pds_deg = intval($row["pds_deg"]);
        $result->tmp_deg = intval($row["tmp_deg"]);
        $result->commentaire = $row["commentaire"];
        $result->description = $row["description"];        
        $result->accessoire_id = intval($row["accessoire_id"]);
        $result->mode_id = intval($row["mode_id"]);
        $result->zone_id = intval($row["zone_id"]);        
        $result->discipline_id = intval($row["discipline_id"]);
        
        // lookups
        /*$result->accessoire = $row["accessoire"];
        $result->mode = $row["mode_id"];
        $result->zone = $row["zone_id"];        
        $result->discipline = $row["discipline_id"];*/
        return $result;
    }

    public function getById($id) {
        $sql = "SELECT * FROM exercice WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindValue("id", $id, PDO::PARAM_INT);
        $q->execute();
        $rows = $q->fetchAll();
        return $this->read($rows[0]);
    }

    public function getByFilterWithLookups($filter) {
        $description = "%" . $filter["description"] . "%";
        $commentaire = "%" . $filter["commentaire"] . "%";
        $sql = "SELECT ex.*,
             accessoire.intitule accessoire,
             mode.intitule mode,
             discipline.intitule discipline,
             zone.intitule zone
            FROM exercice ex            
            left join accessoire on ex.accessoire_id=accessoire.id
            left join mode on ex.mode_id=mode.id
            left join discipline on ex.discipline_id=discipline.id
            left join zone on ex.zone_id=zone.id";

        $q = $this->db->prepare($sql);
        $q->bindValue('description', $description, PDO::PARAM_STR);    
        $q->bindValue('commentaire', $commentaire, PDO::PARAM_STR);  
        $q->bindValue("accessoire_id", $filter["accessoire_id"], PDO::PARAM_INT);
        $q->bindValue("mode_id", $filter["mode_id"], PDO::PARAM_INT);        
        $q->bindValue("discipline_id", $filter["discipline_id"], PDO::PARAM_INT);
        $q->bindValue("zone_id", $filter["zone_id"], PDO::PARAM_INT);
        
        $q->execute();
        $rows = $q->fetchAll();
        
        $error = $q->errorInfo();
        $result = array();
        foreach ($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }
    
    public function getByFilter($filter) {
        $description = "%" . $filter["description"] . "%";
        $commentaire = "%" . $filter["commentaire"] . "%";
        $sql = "SELECT * FROM exercice 
                WHERE description like :description
                and commentaire like :commentaire
                and (accessoire_id=:accessoire_id or :accessoire_id=0)
                and (mode_id=:mode_id or :mode_id=0)
                and (discipline_id=:discipline_id or :discipline_id=0)
                and (zone_id=:zone_id or :zone_id=0)
                order by description
                ";
        $q = $this->db->prepare($sql);
        $q->bindValue('description', $description, PDO::PARAM_STR);  
        $q->bindValue('commentaire', $commentaire, PDO::PARAM_STR);  
        $q->bindValue("accessoire_id", $filter["accessoire_id"], PDO::PARAM_INT);
        $q->bindValue("mode_id", $filter["mode_id"], PDO::PARAM_INT);        
        $q->bindValue("discipline_id", $filter["discipline_id"], PDO::PARAM_INT);
        $q->bindValue("zone_id", $filter["zone_id"], PDO::PARAM_INT);
        
        $q->execute();
        $rows = $q->fetchAll();
        
        $error = $q->errorInfo();
        $result = array();
        foreach ($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }

    public function insert($data) {
        $sql = "INSERT INTO exercice (tmp,nb_series,nb_repetitions,poids,tmp_repos,tmp_prepa,pds_deg,tmp_deg,commentaire,
                description,accessoire_id,zone_id,discipline_id,mode_id) 
                VALUES (
                :tmp,:nb_series,:nb_repetitions,:poids,:tmp_repos,:tmp_prepa,:pds_deg,:tmp_deg,:commentaire,
                :description,:accessoire_id,:zone_id,:discipline_id,:mode_id
                )";

        $q = $this->db->prepare($sql);
        $q->bindValue("tmp", $data["tmp"], PDO::PARAM_INT);
        $q->bindValue("nb_series", $data["nb_series"], PDO::PARAM_INT);
        $q->bindValue("nb_repetitions", $data["nb_repetitions"]);
        $q->bindValue("poids", $data["poids"], PDO::PARAM_INT);
        $q->bindValue("tmp_repos", $data["tmp_repos"], PDO::PARAM_INT);
        $q->bindValue("tmp_prepa", $data["tmp_prepa"], PDO::PARAM_INT);
        $q->bindValue("pds_deg", $data["pds_deg"], PDO::PARAM_INT);
        $q->bindValue("tmp_deg", $data["tmp_deg"], PDO::PARAM_INT);
        $q->bindValue("commentaire", $data["commentaire"]);
        $q->bindValue("description", $data["description"]);
        $q->bindValue("accessoire_id", $data["accessoire_id"] === 0 ? null : $data["accessoire_id"], PDO::PARAM_INT);
        $q->bindValue("zone_id", $data["zone_id"] === 0 ? null : $data["zone_id"], PDO::PARAM_INT);
        $q->bindValue("discipline_id", $data["discipline_id"] === 0 ? null : $data["discipline_id"], PDO::PARAM_INT);
        $q->bindValue("mode_id", $data["mode_id"] === 0 ? null : $data["mode_id"], PDO::PARAM_INT);
        $q->execute();
        $error = $q->errorInfo();
        $res = $this->getById($this->db->lastInsertId());
        return $res;
    }

    public function update($data) {
        $sql = "UPDATE exercice SET tmp=:tmp,nb_series=:nb_series,nb_repetitions=:nb_repetitions,poids=:poids,
                tmp_repos=:tmp_repos,tmp_prepa=:tmp_prepa,pds_deg=:pds_deg,tmp_deg=:tmp_deg,commentaire=:commentaire,
                description=:description,accessoire_id=:accessoire_id,zone_id=:zone_id,
                discipline_id=:discipline_id,mode_id=:mode_id WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindValue("tmp", $data["tmp"], PDO::PARAM_INT);
        $q->bindValue("nb_series", $data["nb_series"], PDO::PARAM_INT);
        $q->bindValue("nb_repetitions", $data["nb_repetitions"]);
        $q->bindValue("poids", $data["poids"], PDO::PARAM_INT);
        $q->bindValue("tmp_repos", $data["tmp_repos"], PDO::PARAM_INT);
        $q->bindValue("tmp_prepa", $data["tmp_prepa"], PDO::PARAM_INT);
        $q->bindValue("pds_deg", $data["pds_deg"], PDO::PARAM_INT);
        $q->bindValue("tmp_deg", $data["tmp_deg"], PDO::PARAM_INT);
        $q->bindValue("commentaire", $data["commentaire"]);
        $q->bindValue("description", $data["description"]);
        $q->bindValue("accessoire_id", $data["accessoire_id"] === 0 ? null : $data["accessoire_id"], PDO::PARAM_INT);
        $q->bindValue("zone_id", $data["zone_id"] === 0 ? null : $data["zone_id"], PDO::PARAM_INT);
        $q->bindValue("discipline_id", $data["discipline_id"] === 0 ? null : $data["discipline_id"], PDO::PARAM_INT);
        $q->bindValue("mode_id", $data["mode_id"] === 0 ? null : $data["mode_id"], PDO::PARAM_INT);
        $q->bindValue("id", $data["id"], PDO::PARAM_INT);
        $res = $q->execute();
        $error = $q->errorInfo();
    }

    public function remove($id) {
        $sql = "DELETE FROM exercice WHERE id = :id";
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