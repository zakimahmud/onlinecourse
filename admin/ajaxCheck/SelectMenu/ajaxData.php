<?php
//Include database configuration file
include('dbConfig.php');

if(isset($_POST["sessionID"]) && !empty($_POST["sessionID"]) ){
    //Get all state data
    $query = $db->query("SELECT semester.id,semester.semester from courseofferlist,semester where courseofferlist.intake =".$_POST['intake']."  AND courseofferlist.session= ".$_POST['sessionID']." AND courseofferlist.semester=semester.id");

    //Count total number of rows
    $rowCount = $query->num_rows;

    //Display states list
    if($rowCount > 0){
        echo '<option value="">Select session</option>';
        while($row = $query->fetch_assoc()){
            echo '<option value="'.$row['id'].'">'.$row['semester'].'</option>';
        }
    }else{
        echo '<option value="">Semester is  not available</option>';
    }
}



?>
