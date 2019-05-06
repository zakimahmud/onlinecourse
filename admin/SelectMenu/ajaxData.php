<?php
//Include database configuration file
include('dbConfig.php');

if(isset($_POST["sessionID"]) && !empty($_POST["sessionID"]) ){
    //Get all state data
    $query = $db->query("SELECT * from courseofferlist where intake =".$_POST['intakeID']."  AND session= ".$_POST['sessionID']." AND semester=".$_POST['semesterID']." AND department=".$_POST['departmentID']."");

    //Count total number of rows
    $rowCount = $query->num_rows;

    //Display states list
    if($rowCount > 0){

        while($row = $query->fetch_assoc()){
            echo '<option value="'.$row['id'].'">'.$row['semester'].'</option>';
        }
    }else{
        echo '<option value="">Semester is  not available</option>';
    }
}



?>
