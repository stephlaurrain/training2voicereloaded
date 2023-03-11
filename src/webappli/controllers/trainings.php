<?php

$_rel_path = "../..";
include ($_rel_path . "/init.php");
include ($_rel_path . "/dalibrary/repositories/TrainingRepository.php");

$logger->debug("=trainings=");
$training = new TrainingRepository($_rel_path);
$req_method = filter_var($_SERVER["REQUEST_METHOD"]);

switch ($req_method) {
    case "GET":
        $action = filter_input(INPUT_GET, "action", FILTER_DEFAULT);
        switch ($action) {
            case "fetchgrid":
                $trainings_col = $training->getByFilter(array(
                    "description" => filter_input(INPUT_GET, "description")
                ));
                //$res = include($_rel_path."/webappli/business/buexercicetraining.php");                
                //calculTotalTrainings($trainings_col);
                $result = $trainings_col;
                break;
            case "duplicate":
                $training_id = filter_input(INPUT_GET, "training_id", FILTER_VALIDATE_INT);
                $res = include($_rel_path . "/webappli/business/buexercicetraining.php");
                duplicateTraining($training_id);
                break;
        }

        break;

    case "POST":
        $idx = $training->getMaxIdx();
        $result = $training->insert(array(
            "description" => filter_input(INPUT_POST, "description", FILTER_DEFAULT),
            "commentaire" => filter_input(INPUT_POST, "commentaire", FILTER_DEFAULT),
            "idx" => $idx + 1
        ));
        break;

    case "PUT":
        parse_str(file_get_contents("php://input"), $_PUT);
        //méthode crado
        $drop = $_PUT['items'][0]['action'];
        if ($drop != null) {
            $action = "drop";
        } else {
            $action = "upd";
        }
        switch ($action) {
            case "upd":
                $result = $training->update(array(
                    "id" => intval(filter_var($_PUT["id"], FILTER_VALIDATE_INT)),
                    "description" => filter_var($_PUT["description"], FILTER_DEFAULT),
                    "commentaire" => filter_var($_PUT["commentaire"], FILTER_DEFAULT),
                    "date_creation" => filter_var($_PUT["date_creation"], FILTER_DEFAULT),
                    //VOIR
                    "archive" => $_PUT["archive"] === "true" ? 1 : 0,
                    "heure_fin" => filter_var($_PUT["heure_fin"], FILTER_DEFAULT)
                ));
                break;
            case "drop":
                $res = include($_rel_path . "/webappli/business/butraining.php");
                //todo filter
                $items = $_PUT['items'];
                refreshIdxAfterDrop($items);

                break;
        }




        break;

    case "DELETE":
        parse_str(file_get_contents("php://input"), $_DELETE);
        $result = $training->remove(intval(filter_var($_DELETE["id"], FILTER_VALIDATE_INT)));
        include($_rel_path."/webappli/business/training.php");                                
        refreshIdxAfterDelete();
        break;
}

header("Content-Type: application/json");
echo json_encode($result);
?>
