<?php

$_rel_path = "../..";
include ($_rel_path . "/dalibrary/repositories/ZoneRepository.php");
$zones = new ZoneRepository($_rel_path);
$req_method = filter_var($_SERVER["REQUEST_METHOD"]);
switch ($req_method) {
    case "GET":
        $result = $zones->getByFilter(array(
            "intitule" => filter_input(INPUT_GET, "intitule", FILTER_DEFAULT)
        ));
        break;

    case "POST":
        $result = $zones->insert(array(
            "intitule" => filter_input (INPUT_POST,"intitule",FILTER_DEFAULT)
        ));
        break;

    case "PUT":
        parse_str(file_get_contents("php://input"), $_PUT);

        $result = $zones->update(array(
            "id" => intval(filter_var($_PUT["id"],FILTER_VALIDATE_INT)),
            "intitule" => filter_var($_PUT["intitule"], FILTER_DEFAULT)
        ));
        break;

    case "DELETE":
        parse_str(file_get_contents("php://input"), $_DELETE);
        $result = $zones->remove(intval(filter_var($_DELETE["id"],FILTER_VALIDATE_INT)));
        break;
}


header("Content-Type: application/json");
echo json_encode($result);
?>
