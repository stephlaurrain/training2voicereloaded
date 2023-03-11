var timerinsulte;

_isspeaking = false;
function voiceStartCallback() {
    _isspeaking = true;
    //console.log("Voice started");
}

function voiceEndCallback() {
    _isspeaking = false;
   // console.log("Voice ended");
}

function sayResponsive(phrase, priority) {
    // var voicelist = responsiveVoice.getVoices();
    // ayaaa responsiveVoice.speak(phrase, "French Female",{pitch: 2, rate:0.1});
    //mouglalis responsiveVoice.speak(phrase, "French Female",{pitch: 0.1, rate:0.6});
    if (_isspeaking && priority === 1) {
        responsiveVoice.cancel();
        _isspeaking = false;
    }

    if (!_isspeaking) {
        responsiveVoice.speak(phrase, "French Female", {pitch: 0.6, rate: 1, onstart: voiceStartCallback, onend: voiceEndCallback});
    }
}



function sayTTS(phrase, priority) {


    var msg = new SpeechSynthesisUtterance();
    msg.voice = speechSynthesis.getVoices().filter(function (voice) {
        return voice.name === 'french-France';
    })[0];

    msg.volume = 0.5; // 0 to 1
    msg.pitch = 1.7;  //0.5 male 0 to 2
    msg.rate = 0.6; // 0.1 to 10
    msg.text = phrase;
    msg.lang = 'fr-FR';
    if (_isspeaking && priority === 1) {
        speechSynthesis.cancel();
        _isspeaking = false;
    }



    if (!_isspeaking) {
        speechSynthesis.speak(msg);
    }
    msg.onstart = function (event) {
        _isspeaking = true;
    }
    msg.onend = function (event) {
        _isspeaking = false;
    }

}

function sayus(phrase, priority) {
    var typeVoice = getParam('type_voice');
    if (typeVoice === "responsive") {
        sayResponsive(phrase, priority);
    } else
    {
        sayTTS(phrase, priority);
    }
}



function managePhrases() {
    var freq_voice;
    var freq_voice = getParam('freq_voice');
    if (freq_voice === null) {
        freq_voice = 10;
    }

    var phrasestab = [];
    phrasestab = _phrase_array;
    timerinsulte = setInterval(function ()
    {
        var tablen = phrasestab.length;
        var rndidxphrase = Math.floor(Math.random() * Math.floor(tablen));
        var rndwhendoit = Math.floor(Math.random() * Math.floor(parseInt(freq_voice)));

        $('#debug').html(rndwhendoit);
        if (rndwhendoit === 1) {
            $('#debug').html(phrasestab[rndidxphrase].texte);
            sayus(phrasestab[rndidxphrase].texte, 0);
        }
    }, 2000);
}
