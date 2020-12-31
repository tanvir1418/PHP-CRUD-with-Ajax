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
        #load-button{
            color: black;
            background-color: wheat;
            padding: 10px;
            margin: 20px;
            border-radius: 15px;
        }
        #load-button:hover{
            color: wheat;
            background-color: black;
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
            <td id="table-load">
                <input type="button" id="load-button" value="Load Data">
            </td>
        </tr>
        <tr>
            <td id="table-data">
                <table border="1" width="100%" cellspacing="0" cellpadding="10px">
                
                </table>
            </td>
        </tr>
    </table>
    <script type="text/javascript" src="js/jquery.js"></script>
     <script type="text/javascript">
     
        // When the document is ready then javascript will start working
        $(document).ready(function(){               
            
            // We want to implement ajax functionality on button whose id is 'load button' and the ajax basic syntax.
            $("#load-button").on("click", function(e){
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
            });
        });
    </script>
</body>
</html>