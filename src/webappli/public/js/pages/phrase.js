$("#phraseGrid").jsGrid({
       
            height: "600px",
            width: "100%",
            filtering: true,
            inserting: true,
            editing: true,
            sorting: true,
            paging: false,
            autoload: true,
            pageSize: 10,
            pageButtonCount: 5,
            confirmDeleting:false,
            deleteConfirm: "On efface ?",
         
            controller: {
                loadData: function(filter) {
                    return $.ajax({
                        type: "GET",
                        url: "./webappli/controllers/phrases.php",
                        data: filter
                    });
                }
                ,
                insertItem: function(item) {
                    return $.ajax({
                        type: "POST",
                        url: "./webappli/controllers/phrases.php",
                        data: item
                    });
                },
                updateItem: function(item) {
                    return $.ajax({
                        type: "PUT",
                        url: "./webappli/controllers/phrases.php",
                        data: item
                    });
                },
                deleteItem: function(item) {
                    return $.ajax({
                        type: "DELETE",
                        url: "./webappli/controllers/phrases.php",
                        data: item
                    });
        }
    },
        fields: [
            { type: "control" },
            { name: "texte", type: "text", title: "Texte", width: 150, validate: "required" }                        
        ]        
 
});