

var r = 1;
var sens = true;
var tmps = 0;

function fillCircle(r, color)
{
    var canvas = $("#canvas2");
    var context = canvas[0].getContext("2d");

    context.beginPath();
    context.rect(0, 0, 100, 100);
    // context.clearRect(0, 0, canvas.width, canvas.height);
    context.fillStyle = "white";
    context.fill();

    context.beginPath();
    context.fillStyle = color;
    context.arc(50, 50, r, 0, 2 * Math.PI);
    context.fill();
}




function gocoherence() {
    $("#coherencedial").show();
    $("#coherencedial").dialog(
            {
                resizable: false,
                width: 100,
                closeOnEscape: false,
                open: function (event, ui) {

                }});

    timercoherence = setInterval(function ()
    {
        var color;
        if (sens) {
            r++;
            tmps++;
            color = "#FF4422";
            //console.log(tmps);
        } else {
            tmps--;
            r--;
            color = "#000000";
        }
        ;
        if (sens && r === 50) {
            var canvas = $("#canvas2");//document.getElementById("canvas2");
            var context = canvas[0].getContext("2d");
            sens = !sens;
        }
        ;
        if (!sens && r === 0) {

            sens = !sens;
        }
        ;
        //console.log("rayon=" + r + " couleur=" + color);

        fillCircle(r, color);
    }, 100);

}

$("#coherencedial").on("dialogclose", function(event) {
      clearInterval(timercoherence);
 });

$(function () {
    $("#coherencedial").hide();
}
);