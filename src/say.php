<?php
include("./webappli/business/buparams.php");
include("./webappli/business/buphrases.php");
?>



<script>
    /* init du tableau des paramètres */
    /* getParamsByJson(); 
     * getPhrasesByJson()*/
    var _param_array =<?php echo getParamsByJson(); ?>;
    var _phrase_array =<?php echo getPhrasesByJson(); ?>;

</script>


<script src="./webappli/public/js/params.js" type="text/javascript"></script>
<script src="./webappli/public/js/speech.js" type="text/javascript"></script>
<script src="./webappli/public/js/chrono.js" type="text/javascript"></script>
<script src="./webappli/public/js/dial/dialexercice.js" type="text/javascript"></script>
<script src="./webappli/public/js/dial/coherence.js" type="text/javascript"></script>
<script src="./webappli/public/js/common.js" type="text/javascript"></script>
<script src="./webappli/public/js/pages/training.js" type="text/javascript"></script>
<script src="https://code.responsivevoice.org/responsivevoice.js?key=JYiKhDFd"></script>
<script src="./webappli/public/js/justsay.js" type="text/javascript"></script>

