<?php
    $conn = mysqli_connect("localhost","root","","test")  or die("Connection failed");

    $sql = "SELECT * FROM students";
    $result = mysqli_query($conn, $sql) or die("SQL Query failed");

    $output = "";
    if(mysqli_num_rows($result) > 0){
        $output = '<table border="1" width="100%" cellspacing="0" cellpadding="10px">
                    <tr>
                        <th width="60px">Id</th>
                        <th>Name</th>
                        <th width="90px">Edit</th>
                        <th width="90px">Delete</th>
                    </tr>';
                    while($row = mysqli_fetch_assoc($result)){
                        $output .= "<tr><td>{$row['id']}</td><td>{$row['first_name']} {$row['last_name']}</td><td><button class='edit-btn' data-eid='{$row['id']}'>Edit</button></td><td><button class='delete-btn' data-id='{$row['id']}'>Delete</button></td></tr>";
                    }
        $output .= "</table>";

        mysqli_close($conn);

        echo $output;
    }else{
        echo "<h2>Record Not Found.</h2>";
    }

    // data- is introduced in HTML5
    // data-id is used to delete a field by using id.
    // data-eid is used to edit a field by using id.
?>