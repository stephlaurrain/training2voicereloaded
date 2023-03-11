<?php

$_rel_path = "../..";
include_once ($_rel_path . "/dalibrary/repositories/ExerciceTrainingRepository.php");
$exercicestrainings = new ExerciceTrainingRepository($_rel_path);
$req_method = filter_var($_SERVER["REQUEST_METHOD"]);

switch ($req_method) {
    case "GET":
        $action = filter_input(INPUT_GET, "action", FILTER_DEFAULT);
        switch ($action) {
            case "fetchgrid":
                $result = $exercicestrainings->getByTrainingId(array(
                    "training_id" => filter_input(INPUT_GET, "training_id", FILTER_VALIDATE_INT) //FILTER_DEFAULT)
                ));
                break;
        }
        break;
    case "POST":
        $idx = $exercicestrainings->getMaxIdx(array("training_id" => intval(filter_input(INPUT_POST, "training_id", FILTER_VALIDATE_INT))));
        $result = $exercicestrainings->insert(array(
            "training_id" => intval(filter_input(INPUT_POST, "training_id", FILTER_VALIDATE_INT)),
            "exercice_id" => intval(filter_input(INPUT_POST, "exercice_id", FILTER_VALIDATE_INT)),
            "commentaire" => filter_input(INPUT_POST, "commentaire", FILTER_DEFAULT),
            "nb_repetitions" => intval(filter_input(INPUT_POST, "nb_repetitions", FILTER_VALIDATE_INT)),
            "nb_series" => intval(filter_input(INPUT_POST, "nb_series", FILTER_VALIDATE_INT)),
            "pds_deg" => intval(filter_input(INPUT_POST, "pds_deg", FILTER_VALIDATE_INT)),
            "poids" => intval(filter_input(INPUT_POST, "poids", FILTER_VALIDATE_INT)),
            "tmp" => intval(filter_input(INPUT_POST, "tmp", FILTER_VALIDATE_INT)),
            "tmp_deg" => intval(filter_input(INPUT_POST, "tmp_deg", FILTER_VALIDATE_INT)),
            "tmp_prepa" => intval(filter_input(INPUT_POST, "tmp_prepa", FILTER_VALIDATE_INT)),
            "tmp_repos" => intval(filter_input(INPUT_POST, "tmp_repos", FILTER_VALIDATE_INT)),
            "idx" => $idx + 1
        ));
        break;

    case "PUT":
        parse_str(file_get_contents("php://input"), $_PUT);     
        //méthode crado
        $drop=$_PUT['items'][0]['action'];
        if ($drop!=null) {$action="drop";} else {$action="upd";}
        switch ($action) {
            case "upd":
                $result = $exercicestrainings->update(array(
                    "id" => intval($_PUT["id"]),
                    "tmp" => intval($_PUT["tmp"]),
                    "nb_series" => intval($_PUT["nb_series"]),
                    "nb_repetitions" => intval($_PUT["nb_repetitions"]),
                    "poids" => intval($_PUT["poids"]),
                    "tmp_repos" => intval($_PUT["tmp_repos"]),
                    "tmp_prepa" => intval($_PUT["tmp_prepa"]),
                    "pds_deg" => intval($_PUT["pds_deg"]),
                    "tmp_deg" => intval($_PUT["tmp_deg"]),
                    "goto" => intval($_PUT["goto"]),
                    "nb_goto" => intval($_PUT["nb_goto"]),
                    "commentaire" => $_PUT["commentaire"],
                ));
                break;
            case "drop":
                $res = include($_rel_path."/webappli/business/buexercicetraining.php");                
                //todo filter
                $items = $_PUT['items'];
                refreshIdxAfterDrop($items);
  
                break;
        }
        break;

    case "DELETE":
        parse_str(file_get_contents("php://input"), $_DELETE);
        $result = $exercicestrainings->remove(intval($_DELETE["id"]));
        
        $training_id = intval($_DELETE["training_id"]);        
        include($_rel_path."/webappli/business/buexercicetraining.php");                                
        refreshIdxAfterDelete($training_id);
        
        break;
}


header("Content-Type: application/json");
echo json_encode($result);
?>
