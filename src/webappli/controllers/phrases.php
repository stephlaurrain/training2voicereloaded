<?php

$_rel_path = "../..";
include ($_rel_path . "/dalibrary/repositories/PhraseRepository.php");
$phrases = new PhraseRepository($_rel_path);
//ATTENTION $req_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD'); plante chez 1and1
$req_method = filter_var($_SERVER["REQUEST_METHOD"]);
switch ($req_method) {
    case "GET":
        $result = $phrases->getByFilter(array(
            "texte" => filter_input(INPUT_GET, "texte", FILTER_DEFAULT)
        ));
        break;

    case "POST":
        $result = $phrases->insert(array(
            "texte" => filter_input (INPUT_POST,"texte",FILTER_DEFAULT)
        ));
        break;

    case "PUT":
        parse_str(file_get_contents("php://input"), $_PUT);

        $result = $phrases->update(array(
            "id" => intval(filter_var($_PUT["id"],FILTER_VALIDATE_INT)),
            "texte" => filter_var($_PUT["texte"], FILTER_DEFAULT),
        ));
        break;

    case "DELETE":
        parse_str(file_get_contents("php://input"), $_DELETE);

        $result = $phrases->remove(intval(filter_var($_DELETE["id"],FILTER_VALIDATE_INT)));
        break;
}


header("Content-Type: application/json");
echo json_encode($result);
?>
