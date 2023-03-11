var accessoires;
var modes;
var disciplines;
var zones;
var _currentRowData;


function fetchDialExerciceGrid() {
    accessoires.unshift({id: 0, intitule: ""});
    modes.unshift({id: 0, intitule: ""});
    disciplines.unshift({id: 0, intitule: ""});
    zones.unshift({id: 0, intitule: ""});
    $("#dialexerciceGrid").jsGrid({

        height: "650px",
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

        controller: {
            loadData: function (filter) {
                filter.action = "dialgrid";
                return $.ajax({
                    type: "GET",
                    url: "./webappli/controllers/exercices.php",
                    data: filter
                });
            }
            ,
            insertItem: function (item) {
                return $.ajax({
                    type: "POST",
                    url: "./webappli/controllers/exercices.php",
                    data: item
                });
            },
            updateItem: function (item) {
                return $.ajax({
                    type: "PUT",
                    url: "./webappli/controllers/exercices.php",
                    data: item,
                    success: function (response) {
                        fetchExerciceTrainingGrid(window.training_id);
                    }
                });
            },
            deleteItem: function (item) {
                return $.ajax({
                    type: "DELETE",
                    url: "./webappli/controllers/exercices.php",
                    data: item,
                    success: function (response) {
                        fetchExerciceTrainingGrid(window.training_id);
                    }
                });
            }
        },

        fields: [
            {type: "control",
                itemTemplate: function () {
                    var $result = jsGrid.fields.control.prototype.itemTemplate.apply(this, arguments);
                    var $downButton = $("<input class='jsgrid-button exercicetraining-down-button btn-addex' type='button' title='Down'>");
                    $result = $result.add($downButton);
                    return $result;

                }
            },
            {name: "description", title: "Exercice", type: "text", width: 40, validate: "required"},
            {name: "nb_series", title: "Séries", type: "number", width: 25, validate: "required",
                /*default val*/
                insertTemplate: function () {
                    var input = this.__proto__.insertTemplate.call(this);
                    input.val(1);
                    return input;
                }
            },
            {name: "tmp", title: "Temps", type: "number", width: 27, validate: "required",
                insertTemplate: function () {
                    var input = this.__proto__.insertTemplate.call(this);
                    input.val(20);
                    return input;
                }
            },
            {name: "tmp_prepa", title: "Prepa", type: "number", width: 25, validate: "required",
                insertTemplate: function () {
                    var input = this.__proto__.insertTemplate.call(this);
                    input.val(0);
                    return input;
                }
            },
            {name: "tmp_repos", title: "Repos", type: "number", width: 25, validate: "required",
                insertTemplate: function () {
                    var input = this.__proto__.insertTemplate.call(this);
                    input.val(0);
                    return input;
                }
            },
            {name: "poids", title: "Poids", type: "number", width: 25,
                insertTemplate: function () {
                    var input = this.__proto__.insertTemplate.call(this);
                    input.val(0);
                    return input;
                }
            },
            {name: "nb_repetitions", title: "Reps", type: "number", width: 25, validate: "required",
                insertTemplate: function () {
                    var input = this.__proto__.insertTemplate.call(this);
                    input.val(0);
                    return input;
                }
            },
            {name: "pds_deg", title: "Pds deg", type: "number", width: 25,
                insertTemplate: function () {
                    var input = this.__proto__.insertTemplate.call(this);
                    input.val(0);
                    return input;
                }
            },
            {name: "tmp_deg", title: "Tmp deg", type: "number", width: 25,
                insertTemplate: function () {
                    var input = this.__proto__.insertTemplate.call(this);
                    input.val(0);
                    return input;
                }
            },
            {name: "accessoire_id", title: "Access.", type: "select", width: 20, items: accessoires, valueField: "id", textField: "intitule"},
            {name: "mode_id", title: "Mode", type: "select", width: 20, items: modes, valueField: "id", textField: "intitule"},
            {name: "discipline_id", title: "Discipl.", type: "select", width: 25, items: disciplines, valueField: "id", textField: "intitule"},
            {name: "zone_id", title: "Zone", type: "select", width: 20, items: zones, valueField: "id", textField: "intitule"},
            {name: "commentaire", title: "Commentaire", type: "text", width: 40}



        ]
        ,
        rowClick: function (args) {

            var data = new Object();
            // alert(window.training_id);
            data.exercice_id = args.item.id;
            data.training_id = window.training_id;
            data.commentaire = args.item.commentaires;
            data.nb_repetitions = args.item.nb_repetitions;
            data.nb_series = args.item.nb_series;
            data.pds_deg = args.item.pds_deg;
            data.poids = args.item.poids;
            data.tmp = args.item.tmp;
            data.tmp_deg = args.item.tmp_deg;
            data.tmp_prepa = args.item.tmp_prepa;
            data.tmp_repos = args.item.tmp_repos;

            // _currentRowData = data;
            $.ajax({
                type: "POST",
                url: "./webappli/controllers/exercicestrainings.php",
                data: data
            });
            fetchExerciceTrainingGrid(window.training_id);


        }
    });
}


$(function () {

    $.getJSON('./webappli/controllers/modes.php', function (jsonData) {
        modes = jsonData;
        $.getJSON('./webappli/controllers/disciplines.php', function (jsonData) {
            disciplines = jsonData;
            $.getJSON('./webappli/controllers/zones.php', function (jsonData) {
                zones = jsonData;
                $.getJSON('./webappli/controllers/accessoires.php', function (jsonData) {
                    accessoires = jsonData;
                    fetchDialExerciceGrid();
                });
            });
        });
    });
});

