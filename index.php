<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD with Ajax</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <table id="main" border="0" cellspacing="0">
        <tr>
            <td id="header">
                <h1>PHP CRUD with Ajax</h1>
                <div id="search-bar">
                    <label for="">Search :</label>
                    <input type="text" id="search" autocomplete="off">
                </div>
            </td>
        </tr>
        <tr>
            <td id="table-form">
                <!-- form tag is only use for resetting those input field using jQuery -->
                <form id="addForm">
                    First Name : <input type="text" id="fname">&nbsp;&nbsp;
                    Last Name : <input type="text" id="lname">
                    <input type="submit" id="save-button" value="Save">
                </form>
            </td>
        </tr>
        <tr>
            <!-- all data are shown on this table -->
            <td id="table-data">
                
            </td>
        </tr>
    </table>

    <div id="error-message"></div>
    <div id="success-message"></div>

    <!-- Modal form for edit data -->
    <div id="modal">
        <div id="modal-form">
            <h2>Edit Form</h2>
            <table cellpadding="10px" width="100%">
                
            </table>
            <!-- for close special css on css file  -->
            <div id="close-btn">X</div>
        </div>
    </div>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript">
     
        // When the document is ready then javascript will start working
        $(document).ready(function(){   

            // when index.php page is loaded then this function will trigger automatically by loadTable() function
            function loadTable(){
                $.ajax({
                    // Where the ajax query will perform
                    url: "ajax-load.php",
                    
                    // We want to sent data by POST method (default value is GET). Don't need to use (optional) 'form' tag for ajax work.
                    type: "POST",                             
                    // data will return from ajax-load.php file and show output on table(ID: table data) without loading the page.
                    success : function(data){                 
                        $("#table-data").html(data);
                    }
                });
            }

            // Load or Refresh table
            loadTable();

            // Insert data or save data to database
            $("#save-button").on("click", function(e){
                // prevent default is used to stop the default activity
                e.preventDefault();

                var fname = $("#fname").val();
                var lname = $("#lname").val();

                if(fname == "" || lname == ""){
                    $("#error-message").html("All fields are required.").slideDown();
                    $("#success-message").slideUp();
                }else{
                    $.ajax({
                        url : "ajax-insert.php",
                        type : "POST",
                        data : {first_name: fname, last_name: lname}, //data sent in object form
                        success : function(data){
                            if(data == 1){
                                loadTable();  //Table is loaded after insertion
                                $("#addForm").trigger("reset");
                                $("#success-message").html("Data Inserted Successfully.").slideDown();
                                $("#error-message").slideUp();
                            }else{
                                $("#error-message").html("Can't Save Record.").slideDown();
                                $("#success-message").slideUp();
                            }                         
                        }
                    });
                }
                
            });


            // at the time of save data, save button is static so that upper process is followed.
            // as the delete button is dynamically loaded so that process discussed below must be followed in this type of cases.
            $(document).on("click", ".delete-btn", function(){
                if(confirm("Do you really want to delete this record ?")){
                    var studentId = $(this).data("id");
                    var element = this;
                    $.ajax({
                        url : "ajax-delete.php",
                        type : "POST",
                        data : {id : studentId},
                        success: function(data){
                            if(data == 1){
                                $(element).closest("tr").fadeOut();
                                // don't refresh the table only remove the element which we want to delete and take those below tr(table row) to one step upper to show like table is refreshing. all this work is done by jQuery.
                            }else{
                                $("#error-message").html("Can't Delete Record.").slideDown();
                                $("#success-message").slideUp();
                            }
                        }
                    });
                }
                
            });

            //load data to update modal form
            $(document).on("click", ".edit-btn", function(){
                $("#modal").show();
                var studentId = $(this).data("eid");
                
                $.ajax({
                    url : "load-update-form.php",
                    type : "POST",
                    data : { id: studentId },
                    success : function(data){
                        $("#modal-form table").html(data);
                    }
                });
            });

            //Hide Modal Box
            $("#close-btn").on("click", function(){
                $("#modal").hide();
            });

            //Save update form
            $(document).on("click", "#edit-submit", function(){
                var stuId = $("#edit-id").val();
                var fname = $("#edit-fname").val();
                var lname = $("#edit-lname").val();

                $.ajax({
                    url : "ajax-update-form.php",
                    type : "POST",
                    data : {id: stuId, first_name: fname, last_name: lname},
                    success : function(data){
                        if(data == 1){
                            $("#modal").hide();
                            loadTable();
                        }
                    } 
                });
            });

            // Live Search
            $("#search").on("keyup", function(){
                var search_term = $(this).val();
                $.ajax({
                    url : "ajax-live-search.php",
                    type : "POST",
                    data : { search : search_term },
                    success : function(data){
                        $("#table-data").html(data);
                    }
                });
            });

        });
        
    </script>
</body>
</html>