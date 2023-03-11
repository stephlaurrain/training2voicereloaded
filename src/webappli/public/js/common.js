function dchiffre(nb)
{
    if (nb < 10) 
    {
        nb = "0" + nb; 
    }

    return nb;
}

(function($) {
    $.fn.scrollrow = function() {
        var parentdiv=$(this).parent().closest('div');
       /* parentdiv.animate({
            scrollTop: $(this).offset().top + 'px'
        }, 'fast');
        */
       parentdiv.scrollTop(parentdiv.scrollTop() + 20);
       /*
        var ypos = $(this).offset().top;
        parentdiv.animate({
            scrollTop: $(this).scrollTop()+ypos
        }, 'fast');
        
        */
        /*org
        parentdiv.animate({
            scrollTop: $(this).outerHeight()}, 'fast');*/
        return this;
    }
})(jQuery);

function doTotal(line){
    var nbseries = line.nb_series;
    var tmp = line.tmp;
    var repos = line.tmp_repos;
    var prepa = line.tmp_prepa;
    return (tmp * nbseries) + (repos * nbseries) + (prepa * nbseries);
}

function getTotalByTraining() {
    var exercicestrainings_col = window.play_ex_items.data;
   
    var total = 0;
    var cptgoto = 0;
    var gId = 0;
    var indexEx = 0;
    var nbEx = exercicestrainings_col.length;
    if (nbEx > 0) {
        do {
            goto = exercicestrainings_col[indexEx].goto;
            nbGoto = exercicestrainings_col[indexEx].nb_goto;
            id = exercicestrainings_col[indexEx].id;
            total += doTotal(exercicestrainings_col[indexEx]);
            if ((cptgoto===0) && (nbGoto>0) && (gId!==id)) {
                cptgoto=nbGoto;
                gId=id;
            } 
            if (id===gId&&cptgoto>0) {
               indexEx-=goto;
               if (indexEx<0) indexEx=0;
               cptgoto--;
            }
            else {
                indexEx++;
            }
        } while (indexEx < nbEx);
    }

    m =Math.trunc(total / 60);
    s = total % 60;
    totalastime = dchiffre(m) + ":" + dchiffre(s);
    return totalastime;
}


