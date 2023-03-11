
<?php

function getParamsByJson() {
    $_rel_path = ".";
    include ($_rel_path . "/dalibrary/repositories/ParamRepository.php");
    $params = new ParamRepository($_rel_path);
    $result = $params->getAll();
    return json_encode($result);
}
?>

