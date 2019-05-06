<?php
//Include database configuration file
include('dbConfig.php');

if(isset($_POST["semesterID"]) && !empty($_POST["semesterID"])){
    //Get all city data
 $query = $db->query("SELECT course.id as courseID,course.courseCode as Code,course.courseName as courseName from  course where EXISTS(SELECT * from courseofferlist where courseofferlist.session=".$_POST['sessionID']." and courseofferlist.semester=".$_POST['semesterID']." and courseofferlist.intake=".$_POST['intake']." and ( course1=course.id OR course2=course.id OR course3=course.id OR course4=course.id  OR course5=course.id OR course6=course.id OR course7=course.id OR course8=course.id OR course9=course.id  ))");
   //$query=$db->query("Select * FROM course");
    //Count total number of rows
    $rowCount = $query->num_rows;

    //Display cities list
    if($rowCount > 0){
        echo '<option value="">Select Course</option>';
        while($row = $query->fetch_assoc()){
            echo '<option value="'.$row['courseID'].'">'.$row['Code'].'  :   '.$row['courseName'].'</option>';
        }
    }
    else{
        echo '<option value="">Course not available</option>';
    }
}



?>
