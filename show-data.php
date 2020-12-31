<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        *{
            text-align:center;
            font-size: 20px;
        }
        h1{
            font-size: 48px;
        }
        #main{
            margin: 10px auto;
        }
        #save-button{
            color: black;
            background-color: wheat;
            padding: 10px;
            margin: 20px;
            border-radius: 15px;
        }
        #save-button:hover{
            color: wheat;
            background-color: black;
            cursor: pointer;
        }
        #success-message{
            background: #DEF1D8;
            color: green;
            padding: 10px;
            margin: 10px;
            display: none;
            position: absolute;
            right: 15px;
            top: 15px;
        }
        #error-message{
            background: #EFDCDD;
            color: red;
            padding: 10px;
            margin: 10px;
            display: none;
            position: absolute;
            right: 15px;
            top: 15px;
        }
        .delete-btn{
            background: red;
            color: #fff;
            border: 0;
            padding: 4px 10px;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
    <title>Ajax Basic</title>
</head>
<body>
    <table id="main" border="0" cellspacing="0">
        <tr>
            <td id="header">
                <h1>PHP with Ajax</h1>
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
            <td id="table-data">
                
            </td>
        </tr>
    </table>

    <div id="error-message"></div>
    <div id="success-message"></div>


    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript">
     
        // When the document is ready then javascript will start working
        $(document).ready(function(){   

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

            loadTable();

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

        });
    </script>
</body>
</html>