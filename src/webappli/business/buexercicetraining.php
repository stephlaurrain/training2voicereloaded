<?php

function refreshIdxAfterDelete($training_id) {
    $rel_path = "../..";
    $res = include_once ($rel_path . "/dalibrary/repositories/ExerciceTrainingRepository.php");
    $exercicestrainings = new ExerciceTrainingRepository($rel_path);
    $exercicetraining_col = $exercicestrainings->getByTrainingId(array("training_id" => $training_id));
    $cpt = 1;
    foreach ($exercicetraining_col as $itm) {
        $exercicestrainings->updateIdx(array(
            "id" => intval($itm->id),
            "idx" => $cpt));
        $cpt++;
    }
}

function refreshIdxAfterDrop($items) {

    $rel_path = "../..";
    $res = include_once ($rel_path . "/dalibrary/repositories/ExerciceTrainingRepository.php");
    $exercicestrainings = new ExerciceTrainingRepository($rel_path);
    $cpt = 1;
    foreach ($items as $itm) {
        $exercicestrainings->updateIdx(array(
            "id" => intval($itm["id"]),
            "idx" => $cpt));
        $cpt++;
    }
}

//TODO mettre en général
function dchiffre($nb) {
    if ($nb < 10) {
        $nb = "0" . $nb;
    }
    return $nb;
}

function doTotal($line){
    $nbseries = $line->nb_series;
    $tmp = $line->tmp;
    $repos = $line->tmp_repos;
    $prepa = $line->tmp_prepa;
    return ($tmp * $nbseries) + ($repos * $nbseries) + ($prepa * $nbseries);
}

function getTotalByTraining($training_id) {
    $rel_path = "../..";
    $res = include_once ($rel_path . "/dalibrary/repositories/ExerciceTrainingRepository.php");
    $exercicestrainings = new ExerciceTrainingRepository($rel_path);
    $exercicetraining_col = $exercicestrainings->getByTrainingId(array("training_id" => $training_id));
    
    $total = 0;
    $cptgoto = 0;
    $gId = 0;
    $indexEx = 0;
    $nbEx = count($exercicetraining_col);
    if ($nbEx > 0) {
        do {
            $goto = $exercicetraining_col[$indexEx]->goto;
            $nbGoto = $exercicetraining_col[$indexEx]->nb_goto;
            $id = $exercicetraining_col[$indexEx]->id;
            $total += doTotal($exercicetraining_col[$indexEx]);
            if (($cptgoto===0) && ($nbGoto>0) && ($gId!==$id)) {
                $cptgoto=$nbGoto;
                $gId=$id;
            } 
            if ($id===$gId&&$cptgoto>0) {
               $indexEx-=$goto;
               if ($indexEx<0) $indexEx=0;
               $cptgoto--;
            }
            else {
                $indexEx++;
            }
        } while ($indexEx < $nbEx);
    }

    $m = (int) ($total / 60);
    $s = $total % 60;
    $totalastime = dchiffre($m) . ":" . dchiffre($s);
    return $totalastime;
}

function calculTotalTrainings($trainings_col) {
    foreach ($trainings_col as $train) {
        $train->total = getTotalByTraining($train->id);
    }
    return $trainings_col;
}


function duplicateTraining($training_id) {
    $rel_path = "../..";
    $res = include_once ($rel_path . "/dalibrary/repositories/ExerciceTrainingRepository.php");
    $res = include_once ($rel_path . "/dalibrary/repositories/TrainingRepository.php");
    $exercicesRepo = new ExerciceTrainingRepository($rel_path);
    $trainingRepo= new TrainingRepository($rel_path);
    
    
    $training_org = $trainingRepo->getById($training_id);
    $idx_training = $trainingRepo->getMaxIdx();
    $ins_data=array(
            "description" => $training_org->description,
            "commentaire" => $training_org->commentaire,
            "idx" => $idx_training+1
        );
    $new_training = $trainingRepo->insert($ins_data);
    $exercicetraining_col = $exercicesRepo->getByTrainingId(array("training_id" => $training_id));
    foreach ($exercicetraining_col as $exercicetraining) {
        $newrow=(array(
            "training_id" => $new_training->id,
            "exercice_id" => $exercicetraining->exercice_id,
            "commentaire" => $exercicetraining->commentaire,
            "nb_repetitions" => $exercicetraining->nb_repetitions,
            "nb_series" => $exercicetraining->nb_series,
            "pds_deg" => $exercicetraining->pds_deg,
            "poids" => $exercicetraining->poids,
            "tmp" => $exercicetraining->tmp,
            "tmp_deg" => $exercicetraining->tmp_deg,
            "tmp_prepa" => $exercicetraining->tmp_prepa,
            "tmp_repos" => $exercicetraining->tmp_repos,
            "idx" => $exercicetraining->idx
        ));    
        $exercicesRepo->insert($newrow);        
    }
    
}

?>
