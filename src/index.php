<?php
include ("./webappli/common/head.php");
include("./webappli/business/buparams.php");
include("./webappli/business/buphrases.php");
?>

<div class="row grids-container">
    <div id="traingrid-resizeable" class="col-11 offset-sm-2 col-sm-8 traingrid-container">
        <div id="trainingGrid"></div>       
    </div>
    <div id="totaltrain" class="col-1"></div>

</div>


<div class="row">

    <div id="exercicetraingrid-resizeable"  class="col-12">
        <div id="exerciceTrainingGrid"></div>
    </div>
</div>
<div id="coherencedial"  title="Cohérence">
    <canvas id="canvas2" width ="100" height="100"></canvas>
</div>



<script>
    /* init du tableau des paramètres */
    /* getParamsByJson(); 
     * getPhrasesByJson()*/
    var _param_array =<?php echo getParamsByJson(); ?>;
    var _phrase_array =<?php echo getPhrasesByJson(); ?>;

</script>

<?php
include ("./webappli/common/chrono.php");
include ("./webappli/common/dialexercice.php");
include ("./webappli/common/incjs.php");
?>
<script src="./webappli/public/js/params.js" type="text/javascript"></script>
<script src="./webappli/public/js/speech.js" type="text/javascript"></script>
<script src="./webappli/public/js/chrono.js" type="text/javascript"></script>
<script src="./webappli/public/js/dial/dialexercice.js" type="text/javascript"></script>
<script src="./webappli/public/js/dial/coherence.js" type="text/javascript"></script>
<script src="./webappli/public/js/common.js" type="text/javascript"></script>
<script src="./webappli/public/js/pages/training.js" type="text/javascript"></script>
<script src="https://code.responsivevoice.org/responsivevoice.js?key=JYiKhDFd"></script>
<?php include ("./webappli/common/foot.php"); ?>