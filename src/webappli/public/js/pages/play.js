function fetchTrainingGrid() {
    $("#trainingGrid").jsGrid({

        height: "110px",
        width: "100%",
        filtering: false,
        inserting: false,
        editing: false,
        sorting: true,
        paging: false,
        autoload: true,
        pageSize: 10,
        pageButtonCount: 5,
        confirmDeleting: false,
        deleteConfirm: "On efface ?",

        controller: {
            loadData: function (filter) {
                filter.action = "fetchgrid";
                return $.ajax({
                    type: "GET",
                    url: "./webappli/controllers/trainings.php",
                    data: filter,
                    success: function (response) {
                        var id_first_training = response[0].id;
                        fetchExerciceTrainingGrid(id_first_training);
                    }
                });
            }           
        },
        fields: [
            {name: "description", title: "Training", type: "text", width: 80, validate: "required"}
        ]
        ,
        rowClick: function (args) {
            if (_lasttrainrow !=null) _lasttrainrow.toggleClass("highlightgridrow");
            var $row = this.rowByItem(args.item); 
            $row.toggleClass("highlightgridrow");
            _lasttrainrow =$row;
            fetchExerciceTrainingGrid(args.item.id);
        }
    });
}

function fetchExerciceTrainingGrid(id_training) {
    $("#exerciceTrainingGrid").jsGrid({

        height: "450px",
        width: "100%",
        filtering: false,
        inserting: false,
        editing: false,
        sorting: false,
        paging: false,
        autoload: true,
        pageSize: 10,
        pageButtonCount: 5,
        confirmDeleting: false,
        deleteConfirm: "On efface ?",

        controller: {
            loadData: function (filter) {
                filter.training_id = parseInt(id_training);
                filter.action = "fetchgrid";
                return $.ajax({
                    type: "GET",
                    url: "./webappli/controllers/exercicestrainings.php",
                    data: filter                            
                });
            }
        },
      
        fields: [
            {name: "description", title: "Ex.", type: "text", width: 40, validate: "required"},
            {name: "nb_series", title: "Sér.", type: "number", width: 10, validate: "required"},
            {name: "tmp", title: "Tmp", type: "number", width: 10, validate: "required"},            
            {name: "tmp_prepa", title: "Prep", type: "number", width: 10, validate: "required"},
            {name: "tmp_repos", title: "Rep", type: "number", width: 10, validate: "required"},
            {name: "poids", title: "Pds", type: "number", width: 10},
            {name: "goto", title: "Go", type: "number", width: 10},
            {name: "nb_goto", title: "NbGo", type: "number", width: 10}
            
        ]
        ,
        rowClick: function (args) {
            window.current_ex_id = args.item.id;   
            if (_lastexrow !=null) _lastexrow.toggleClass("highlightgridrow");
            var $row = this.rowByItem(args.item); 
            $row.toggleClass("highlightgridrow");
            _lastexrow =$row;
        },
        onDataLoaded: function(data) {
               window.play_ex_items = data;
               var totaltrain = getTotalByTraining();
               $('#totaltrain').html( totaltrain);
        }

    });
}

$("#tb-coherence").click(function () {    
    gocoherence();
});


var _lastexrow;
var _lasttrainrow;

$(function () {
    window.current_ex_id = 0;  
    fetchTrainingGrid();
  


});


