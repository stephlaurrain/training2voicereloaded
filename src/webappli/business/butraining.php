<?php

function refreshIdxAfterDelete() {
    $rel_path = "../..";
    $res = include_once ($rel_path . "/dalibrary/repositories/TrainingRepository.php");
    $trainings = new TrainingRepository($rel_path);
    $training_col = $trainings->getByFilter();
    $cpt = 1;
    foreach ($training_col as $itm) {
        $trainings->updateIdx(array(
            "id" => intval($itm->id),
            "idx" => $cpt));
        $cpt++;
    }
}

function refreshIdxAfterDrop($items) {

    $rel_path = "../..";
    $res = include_once ($rel_path . "/dalibrary/repositories/TrainingRepository.php");
    $trainings = new trainingRepository($rel_path);
    $cpt = 1;
    foreach ($items as $itm) {
        $trainings->updateIdx(array(
            "id" => intval($itm["id"]),
            "idx" => $cpt));
        $cpt++;
    }
}

?>
