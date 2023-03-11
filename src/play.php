<?php
include ("./webappli/common/headplay.php");
include("./webappli/business/buparams.php");
include("./webappli/business/buphrases.php");
?>

<div class="row play-grids-container">
    <div id="play-traingrid " class="col-8 play-traingrid-container">
        <div id="trainingGrid"></div>        
    </div>
    <div class="col-2">
    <div id="totaltrain"></div>
    <div class="toolbar-btn-container">
        <input id="tb-coherence" class="toolbar-button toolbar-coherence-button" type="button" title="coherence">
    </div>
    </div>
</div>

<div class="row">

    <div class="col-12">
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
include ("./webappli/common/chronoplay.php");
include ("./webappli/common/incjs.php");
?>
<script src="./webappli/public/js/params.js" type="text/javascript"></script>
<script src="./webappli/public/js/speech.js" type="text/javascript"></script>
<script src="./webappli/public/js/chrono.js" type="text/javascript"></script>
<script src="./webappli/public/js/dial/coherence.js" type="text/javascript"></script>
<script src="./webappli/public/js/common.js" type="text/javascript"></script>
<script src="./webappli/public/js/pages/play.js" type="text/javascript"></script>
<script src="https://code.responsivevoice.org/responsivevoice.js?key=JYiKhDFd"></script>
<?php include ("./webappli/common/foot.php"); ?>