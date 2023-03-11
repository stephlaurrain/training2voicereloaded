$("#paramGrid").jsGrid({
       
            height: "600px",
            width: "100%",
            filtering: true,
            inserting: true,
            editing: true,
            sorting: true,
            paging: true,
            autoload: true,
            pageSize: 10,
            pageButtonCount: 5,
            confirmDeleting:false,
            deleteConfirm: "On efface ?",
         
            controller: {
                loadData: function(filter) {
                    return $.ajax({
                        type: "GET",
                        url: "./webappli/controllers/params.php",
                        data: filter
                    });
                }
                ,
                insertItem: function(item) {
                    return $.ajax({
                        type: "POST",
                        url: "./webappli/controllers/params.php",
                        data: item
                    });
                },
                updateItem: function(item) {
                    return $.ajax({
                        type: "PUT",
                        url: "./webappli/controllers/params.php",
                        data: item
                    });
                },
                deleteItem: function(item) {
                    return $.ajax({
                        type: "DELETE",
                        url: "./webappli/controllers/params.php",
                        data: item
                    });
        }
    },
        fields: [
            { type: "control" },
            { name: "cle", type: "text", title: "Clé", width: 150, validate: "required" },
            { name: "valeur", type: "text", title: "Valeur", width: 150, validate: "required" }
            
        ]        
 
});