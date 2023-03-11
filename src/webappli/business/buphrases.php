
<?php

function getPhrasesByJson() {
    $_rel_path = ".";
    include ($_rel_path."/dalibrary/repositories/PhraseRepository.php");
    $phrases = new PhraseRepository($_rel_path);
    $result = $phrases->getAll();
    return json_encode($result);
}
?>

