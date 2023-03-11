<?php
$_rel_path="../..";
include ($_rel_path."/dalibrary/repositories/ParamRepository.php");
$params = new ParamRepository($_rel_path);
$req_method = filter_var($_SERVER["REQUEST_METHOD"]);

switch ($req_method) {
    case "GET":
        $result = $params->getByFilter(array(
            "cle" => filter_input(INPUT_GET,"cle",FILTER_DEFAULT),
            "valeur" => filter_input(INPUT_GET,"valeur",FILTER_DEFAULT)
        ));
        break;

    case "POST":
        $result = $params->insert(array(
            "cle" => filter_input (INPUT_POST,"cle",FILTER_DEFAULT),
            "valeur" => filter_input (INPUT_POST,"valeur",FILTER_DEFAULT)
        ));
        break;

    case "PUT":
        parse_str(file_get_contents("php://input"), $_PUT);
                
        $result = $params->update(array(
            "id" => intval(filter_var($_PUT["id"],FILTER_VALIDATE_INT)),
            "cle" => filter_var($_PUT["cle"], FILTER_DEFAULT),
            "valeur" => filter_var($_PUT["valeur"], FILTER_DEFAULT)
        ));
        break;

    case "DELETE":
        parse_str(file_get_contents("php://input"), $_DELETE);
        $result = $params->remove(intval(filter_var($_DELETE["id"],FILTER_VALIDATE_INT)));
        break;
}


header("Content-Type: application/json");
echo json_encode($result);
?>
