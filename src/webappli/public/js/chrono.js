
var m = 0; // Minute
var s = 0; // Seconde

var temps; // Contiendra l'exécution de notre code 
var bo = true; // Permettra de contrôler l'exécution du code
var _deconne = false;

var _volSnd = parseFloat(getParam('volume_beep'));




function playThatSound(soundname) {
    var snd = document.getElementById(soundname);
    snd.volume = _volSnd;
    snd.play();
}

function indiqueTempsBySound() {
    if ((s === 0) && (m > 0)) {
        sayus(m + ' minute',1);
    }
    if ((m === 0) && ((s === 30) || (s === 10))) {
        sayus(s + ' secondes',1);
    }

    if (m === 0 && s <= 3 && s > 0) {
        playThatSound('audiobeep2');
    }
    if (m === 0 && s === 0) {
        playThatSound('audiobeep1');
    }

}

function go() {
    var isfirst = true;
    temps = setInterval(function ()
    {
        s--;
        if (s === 0 && m === 0) {
            _timerOn = false;
            clearInterval(temps);

        }
        if (s < 0)
        {
            m--;
            s = 59;
        }



        if (!isfirst) {
            indiqueTempsBySound();
        }
        isfirst = false;

        $("#s").html(dchiffre(s));
        $("#m").html(dchiffre(m));





    }, 1000);
}

function waitFor(condition, callback) {
    if (!condition()) {
        //console.log('waiting');
        window.setTimeout(waitFor.bind(null, condition, callback), 100); /* this checks the flag every 100 milliseconds*/
    } else {
        //console.log('done');
        callback();
    }
}

var _timerOn = false;

function doExo(tmp, descr, nextdescr, saynext) {

    if (tmp <= 0) {
        _timerOn = false;
        return;
    }
    m = Math.trunc(tmp / 60);
    s = (tmp % 60);

    var phrase = descr;
    if (_cptserie > 1) {
        phrase += ", serie " + _cptserie;
    }
    if (m > 0) {
        phrase += ", " + m + " minute";
    }
    if (s > 0) {
        phrase += ", " + s + " seconde";
    }
    if (_cptserie === 1 && saynext && nextdescr!=="") {
        phrase += " prochain :       " + nextdescr;
    }



    sayus(phrase,1);

    _timerOn = true;
    go();

}


var _isrowplayed = false;

function playRow(tmp, tmp_prepa, tmp_repos, description, nextdescr) {
    if (tmp_prepa > 0) {

        doExo(tmp_prepa, "preparation " + description, nextdescr, false);
        //waitFor(() => _timerOn === false, () => console.log('got you'));            
        waitFor(() => _timerOn === false, () => doExo(tmp, description, nextdescr, true));
        if (tmp_repos > 0) {
            waitFor(() => _timerOn === false, () => doExo(tmp_repos, "repos", nextdescr, false));
            waitFor(() => _timerOn === false, () => _isrowplayed = true);
        } else
        {
            waitFor(() => _timerOn === false, () => _isrowplayed = true);
        }
    } else {
        doExo(tmp, description, nextdescr, true);
        console.log('tmp_repos='+tmp_repos);
        if (tmp_repos > 0) {
            waitFor(() => _timerOn === false, () => doExo(tmp_repos, "repos", nextdescr, false));
            waitFor(() => _timerOn === false, () => _isrowplayed = true);
        } else
        {
            waitFor(() => _timerOn === false, () => _isrowplayed = true);
        }
    }
}



var _cptserie = 0;

function playitm(itm) {
    var tmp = parseInt(itm['tmp']);
    var tmp_prepa = parseInt(itm['tmp_prepa']);
    var tmp_repos = parseInt(itm['tmp_repos']);
    var idx = parseInt(itm['idx']);


    _rowsclasses[idx - 1].toggleClass("highlightgridrow");
    if (_lastexrow != null){
        _lastexrow.toggleClass("highlightgridrow");
        //scroller
        _lastexrow.scrollrow();
        
    }
    _lastexrow = _rowsclasses[idx - 1];


    var nextitm = window.play_ex_items.data[idx];  // index + 1) 
    var nextdescr = "";
    if (nextitm != null)
    {
        nextdescr = nextitm['description'];
    }

    playRow(tmp, tmp_prepa, tmp_repos, itm['description'], nextdescr);



}

var goto;
var nbgoto;
var cptgoto = 0;
var _id = 0;
var index = 0;
var lastidx;


function playnext() {
    var itm = window.play_ex_items.data[index];

    if (_cptserie > 1) {
        _isrowplayed = false;
        _cptserie--;
        playitm(itm);
        waitFor(() => _isrowplayed, () => playnext());
    } else
    {
        if (index < lastidx) {
            goto = itm['goto'];
            nbgoto = itm['nb_goto'];
            id = itm['id'];
            //console.log ("desc="+itm['description']);
            //console.log ("goto="+goto);
            //console.log ("nbgoto="+nbgoto);
            //console.log ("cptgoto="+cptgoto);
            //if (cptgoto===0) cptgoto=nbgoto;            
            if (cptgoto === 0 && nbgoto > 0 && _id !== id) {
                cptgoto = nbgoto;
                _id = id;
            }
            if (_id === _id && cptgoto > 0) {
                index -= goto;
                if (index < 0)
                    index = 0;
                cptgoto--;
            } else {
                index++;
            }


            itm = window.play_ex_items.data[index];
            _isrowplayed = false;

            if (_cptserie === 1)
                _cptserie = parseInt(itm['nb_series']);
            playitm(itm);



            // aya
            waitFor(() => _isrowplayed, () => playnext());
        } else
        {
            stop();
        }
    }
}


function doplay() {
    if (_prepa_on)
        return;

    var $gridData = $("#exerciceTrainingGrid .jsgrid-grid-body tbody");
    _rowsclasses = $.map($gridData.find("tr"), function (row) {
        return $(row);
    });



    //alert(window.current_ex_id);
    var phrase_on = getParam('phrases_on');
    var _deconne = ((phrase_on != null) && (phrase_on === 'on'));

    if (bo)
    {
        /*if (_lastexrow != null)
         _lastexrow.toggleClass("highlightgridrow");*/

        if (_deconne) {
            managePhrases();
        }

        $("#start").html('<i class="fas fa-pause"></i>');
        var items = window.play_ex_items.data;
        if (window.current_ex_id === 0) {
            window.current_ex_id = items[0].id;
        }
        var itm = items.find(x => x.id === window.current_ex_id);
        lastidx = items.length - 1;  // items[items.length - 1].idx;

        var idx = parseInt(itm['idx']);
        index = idx - 1;

        _isrowplayed = false;
        _cptserie = parseInt(itm['nb_series']);
        playitm(itm);
        waitFor(() => _isrowplayed, () => playnext());


        // On affecte false à bo pour empécher un second Intervalle de se lancer
        bo = false;
    } else
    {
        stop();
    }
}


$("#start").click(function ()
{
    doplay();

});

function stop()
{
    clearInterval(timerinsulte);

    $("#start").html('<i class="fas fa-play"></i>');
    clearInterval(temps); // On stop l'interval	    

    $("#s").html(dchiffre(s));
    $("#m").html(dchiffre(m));
    bo = true;
    _deconne = false;
}


var _prepa_on = false;

function doprepa() {
    if (bo && !_prepa_on) {
        _prepa_on = true;
        $("#prepa").html('<i class="fas fa-toggle-on"></i>');
        var prmPrepa = getParam('tmp_prepa');
        var tmp;
        if (prmPrepa != null)
            tmp = parseInt(prmPrepa);
        else
            tmp = 10;
        m = Math.trunc(tmp / 60);
        s = (tmp % 60);

        var phrase = "preparation " + s + " secondes";
        sayus(phrase,1);

        _timerOn = true;
        go();
        // waitFor(() => _timerOn === false, () => afterPrepPlayed());
        waitFor(() => _timerOn === false, function () {
            _prepa_on = false;
            $("#prepa").html('<i class="fas fa-toggle-off"></i>');
            doplay();

        });
    }
}


$("#prepa").click(function ()
{

    doprepa();


    //
});
