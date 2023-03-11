<?php

$_rel_path = "../..";
include ($_rel_path . "/dalibrary/repositories/ExerciceRepository.php");
$exercices = new ExerciceRepository($_rel_path);
$req_method = filter_var($_SERVER["REQUEST_METHOD"]);

switch ($req_method) {
    case "GET":
        // $action = filter_input(INPUT_GET, "action", FILTER_DEFAULT);
        $queryfilter = array(
            "description" => filter_input(INPUT_GET, "description", FILTER_DEFAULT),
            "commentaire" => filter_input(INPUT_GET, "commentaire", FILTER_DEFAULT),
            "accessoire_id" => filter_input(INPUT_GET, "accessoire_id", FILTER_VALIDATE_INT),
            "mode_id" => filter_input(INPUT_GET, "mode_id", FILTER_VALIDATE_INT),
            "discipline_id" => filter_input(INPUT_GET, "discipline_id", FILTER_VALIDATE_INT),
            "zone_id" => filter_input(INPUT_GET, "zone_id", FILTER_VALIDATE_INT)
        );
        $result = $exercices->getByFilter($queryfilter);
        break;



    case "POST":
        $result = $exercices->insert(array(
            "tmp" => intval($_POST["tmp"]),
            "nb_series" => intval($_POST["nb_series"]),
            "nb_repetitions" => intval($_POST["nb_repetitions"]),
            "poids" => intval($_POST["poids"]),
            "tmp_repos" => intval($_POST["tmp_repos"]),
            "tmp_prepa" => intval($_POST["tmp_prepa"]),
            "pds_deg" => intval($_POST["pds_deg"]),
            "tmp_deg" => intval($_POST["tmp_deg"]),
            "commentaire" => $_POST["commentaire"],
            "description" => $_POST["description"],
            "accessoire_id" => intval($_POST["accessoire_id"]),
            "mode_id" => intval($_POST["mode_id"]),
            "zone_id" => intval($_POST["zone_id"]),
            "discipline_id" => intval($_POST["discipline_id"])
        ));
        break;

    case "PUT":
        parse_str(file_get_contents("php://input"), $_PUT);

        $result = $exercices->update(array(
            "id" => intval($_PUT["id"]),
            "tmp" => intval($_PUT["tmp"]),
            "nb_series" => intval($_PUT["nb_series"]),
            "nb_repetitions" => intval($_PUT["nb_repetitions"]),
            "poids" => intval($_PUT["poids"]),
            "tmp_repos" => intval($_PUT["tmp_repos"]),
            "tmp_prepa" => intval($_PUT["tmp_prepa"]),
            "pds_deg" => intval($_PUT["pds_deg"]),
            "tmp_deg" => intval($_PUT["tmp_deg"]),
            "commentaire" => $_PUT["commentaire"],
            "description" => $_PUT["description"],
            "accessoire_id" => intval($_PUT["accessoire_id"]),
            "mode_id" => intval($_PUT["mode_id"]),
            "zone_id" => intval($_PUT["zone_id"]),
            "discipline_id" => intval($_PUT["discipline_id"])
        ));
        break;

    case "DELETE":
        parse_str(file_get_contents("php://input"), $_DELETE);

        $result = $exercices->remove(intval($_DELETE["id"]));
        break;
}


header("Content-Type: application/json");
echo json_encode($result);
?>
