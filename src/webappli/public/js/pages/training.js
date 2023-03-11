function fetchTrainingGrid() {
    $("#trainingGrid").jsGrid({

        height: "350px",
        width: "100%",
        filtering: true,
        inserting: true,
        editing: true,
        sorting: true,
        paging: false,
        autoload: true,
        pageSize: 10,
        pageButtonCount: 5,
        confirmDeleting: false,
        deleteConfirm: "On efface ?",
        rowClass: function (item, itemIndex) {
            return "training-" + itemIndex;            
        },
        controller: {
            loadData: function (filter) {
                filter.action = "fetchgrid";
                return $.ajax({
                    type: "GET",
                    url: "./webappli/controllers/trainings.php",
                    data: filter,
                    success: function (response) {
                        var id_first_training = response[0].id;
                        window.training_id = id_first_training;
                        fetchExerciceTrainingGrid(id_first_training);
                    }
                });
            }
            ,
            insertItem: function (item) {
                return $.ajax({
                    type: "POST",
                    url: "./webappli/controllers/trainings.php",
                    data: item
                });
                
            },
            updateItem: function (item) {
                var res= $.ajax({
                    type: "PUT",
                    url: "./webappli/controllers/trainings.php",
                    data: item
                });
                return false;
            },
            deleteItem: function (item) {
                return $.ajax({
                    type: "DELETE",
                    url: "./webappli/controllers/trainings.php",
                    data: item
                }).done(function () {
                    fetchExerciceTrainingGrid();
                });
            }
        },
        fields: [
            {type: "control"},
            {name: "description", title: "Training", type: "text", width: 80, validate: "required"},
            {name: "date_creation", title: "Date", type: "text", width: 60},
            {name: "commentaire", title: "Commentaire", type: "text", width: 80}
        ],
            onRefreshed: function () {
            var $gridData = $("#trainingGrid .jsgrid-grid-body tbody");

            $gridData.sortable({
                update: function (e, ui) {
                    // array of indexes
                    var exerciceIndexRegExp = /\s*training-(\d+)\s*/;
                    var indexes = $.map($gridData.sortable("toArray", {attribute: "class"}), function (classes) {
                        return exerciceIndexRegExp.exec(classes)[1];
                    });
                    var items = $.map($gridData.find("tr"), function (row) {
                        return $(row).data("JSGridItem");
                    });
                    items[0].action = "drop";
                    $.ajax({
                        type: "PUT",
                        url: "./webappli/controllers/trainings.php",
                        data: {items: items}
                    });

                }
            })
        }
        ,
        rowClick: function (args) {
            window.training_id = args.item.id;
            if (_lasttrainrow != null)
                _lasttrainrow.toggleClass("highlightgridrow");
            var $row = this.rowByItem(args.item);
            $row.toggleClass("highlightgridrow");
            _lasttrainrow = $row;

            fetchExerciceTrainingGrid(args.item.id);

            //fetchExerciceTrainingGrid();
            // $('#trainingcom').val(args.item.commentaire);
            /* console.log(args);
             alert(args.event.currentTarget.cells[1].innerHTML);
             
             alert(args.item.id);*/
            // var prout=$('#grid').jsGrid('option', 'data');     
            // sayResponsive(args.event.currentTarget.cells[1].innerHTML);     
        }

    });
}



/*
 });
 
 
 });*/


function fetchExerciceTrainingGrid(id_training) {
    $("#exerciceTrainingGrid").jsGrid({

        height: "450px",
        width: "100%",
        filtering: false,
        inserting: false,
        editing: true,
        sorting: false,
        paging: false,
        autoload: true,
        pageSize: 10,
        pageButtonCount: 5,
        confirmDeleting: false,
        deleteConfirm: "On efface ?",
        rowClass: function (item, itemIndex) {
            return "exercice-" + itemIndex;
        },

        controller: {
            loadData: function (filter) {
                filter.training_id = parseInt(id_training);
                filter.action = "fetchgrid";
                return $.ajax({
                    type: "GET",
                    url: "./webappli/controllers/exercicestrainings.php",
                    data: filter
                            /*,
                             success: function (response) {                        
                             // alert(id_training);
                             }*/
                });
            }
            ,
            updateItem: function (item) {
                var res = $.ajax({
                    type: "PUT",
                    url: "./webappli/controllers/exercicestrainings.php",
                    data: item
                });
                fetchExerciceTrainingGrid(id_training);
                return res;
            },
            deleteItem: function (item) {

                var res = $.ajax({
                    type: "DELETE",
                    url: "./webappli/controllers/exercicestrainings.php",
                    data: item
                });
                fetchExerciceTrainingGrid(id_training);
                return res;

            },
        },

        fields: [
            {type: "control"},
            {name: "description", title: "Exercice", width: 40, validate: "required"},
            {name: "nb_series", title: "Séries", type: "number", width: 25, validate: "required"},
            {name: "tmp", title: "Temps", type: "number", width: 27, validate: "required"},
            {name: "tmp_prepa", title: "Prepa", type: "number", width: 25, validate: "required"},
            {name: "tmp_repos", title: "Repos", type: "number", width: 25, validate: "required"},
            {name: "poids", title: "Poids", type: "number", width: 25},
            {name: "nb_repetitions", title: "Reps", type: "number", width: 25, validate: "required"},
            {name: "pds_deg", title: "Pds deg", type: "number", width: 25},
            {name: "tmp_deg", title: "Tmp deg", type: "number", width: 25},
            {name: "accessoire", title: "Accessoire", width: 30},
            {name: "mode", title: "Mode", width: 30},
            {name: "discipline", title: "Discipline", width: 30},
            {name: "zone", title: "Zone", width: 30},
            {name: "commentaire", title: "Commentaire", type: "text", width: 40},
            {name: "goto", title: "Go", type: "number", width: 25},
            {name: "nb_goto", title: "NbGo", type: "number", width: 25} /*,
             {name: "idx", title: "Idx", type: "number", width: 25}*/
        ]
        ,
        onRefreshed: function () {
            var $gridData = $("#exerciceTrainingGrid .jsgrid-grid-body tbody");

            $gridData.sortable({
                update: function (e, ui) {
                    // array of indexes
                    var exerciceIndexRegExp = /\s*exercice-(\d+)\s*/;
                    var indexes = $.map($gridData.sortable("toArray", {attribute: "class"}), function (classes) {
                        return exerciceIndexRegExp.exec(classes)[1];
                    });
                    //alert("Reordered indexes: " + indexes.join(", "));

                    // arrays of items
                    var items = $.map($gridData.find("tr"), function (row) {
                        return $(row).data("JSGridItem");
                    });
                    //console && console.log("Reordered items", items);
                    items[0].action = "drop";
                    $.ajax({
                        type: "PUT",
                        url: "./webappli/controllers/exercicestrainings.php",
                        data: {items: items}
                    });

                }
            })
        },
        rowClick: function (args) {
            window.current_ex_id = args.item.id;
            if (_lastexrow != null)
                _lastexrow.toggleClass("highlightgridrow");
            var $row = this.rowByItem(args.item);
            $row.toggleClass("highlightgridrow");
            _lastexrow = $row;

        },
        onDataLoaded: function (data) {
            window.play_ex_items = data;
            var totaltrain = getTotalByTraining();
            $('#totaltrain').html(totaltrain);
        }
    });
}

$("#tb-up").click(function () {

    alert(window.training_id);
});


// lancement exercicedial
$("#tb-add").click(function () {
    $("#exercicedial").show();
    $("#exercicedial").dialog(
            {
                resizable: true,
                width: 1400,
                closeOnEscape: true,
            });
    fetchDialExerciceGrid();

});

$("#tb-play").click(function () {
    window.location.href = "play.php";
});

$("#tb-duplicate").click(function () {
    var filter = new Object();
    filter.training_id = window.training_id;
    filter.action = "duplicate";
    return $.ajax({
        type: "GET",
        url: "./webappli/controllers/trainings.php",
        data: filter
        ,
        success: function (response) {
            fetchTrainingGrid();
        }
    });
});

$("#tb-coherence").click(function () {
    // window.location.href = "coherence.php";
    gocoherence();
});


var _lastexrow;
var _lasttrainrow;

$(function () {
    window.training_id = 0;
    window.current_ex_id = 0;
    $("#exercicedial").hide();
    
    $("#chronodial").dialog(
            {
                resizable: false,
                width: 200,
                closeOnEscape: false,
                open: function (event, ui) {
                    $(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
                }});
    fetchTrainingGrid();



});


