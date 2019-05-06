<?php
session_start();


include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])==1)
    {
header('location:index.php');
}
else{

if(isset($_POST['submit']))
{
$student_id=$_POST['student_id'];
$department=$_POST['department'];
$semester=$_POST['intake'];
$course=$_POST['course'];
$session=$_POST['session'];
$semester=$_POST['semester'];


$conditionSql="select * from courseenrolls where studentRegno='$student_id' AND course='$course' AND semester='$semester' AND session='$session'  ";
$resultCondition=mysqli_query($con,$conditionSql);
 $rowcount=mysqli_num_rows($resultCondition);

 if ($rowcount>0){

   echo "<script>
 alert('Sorry !! This Course is allready Registered');
 window.location.href='enroll.php';
 </script>";


 }

else {

$sqlRetCredit="select courseCredit FROM course WHERE course.id='$course';";
$resultCredit=mysqli_query($con,$sqlRetCredit);
$rowCredit=mysqli_fetch_array($resultCredit);

$countCreditSql2="select SUM(course.courseCredit) as TotalCredit
from courseenrolls
join course on course.id=courseenrolls.course
join session on session.id=courseenrolls.session
join department on department.id=courseenrolls.department
join semester on semester.id=courseenrolls.semester
where courseenrolls.studentRegno='$student_id' AND semester.id='$semester' ";


$retTotalCredit2=mysqli_query($con,$countCreditSql2);
$rowTotalCredit2=mysqli_fetch_array($retTotalCredit2);
$sumCredit2=$rowTotalCredit2['TotalCredit'];




$sumofCredit=$rowCredit['courseCredit'];
$sumCreditFinal=$sumofCredit+$sumCredit2;
// echo $sumCredit2;
// echo $sumCreditFinal;
if ($sumCreditFinal<19) {
$insertStatement=mysqli_query($con,"insert into courseenrolls(studentRegno,session,department,course,semester) values('$student_id','$session','$department','$course','$semester')");

if($insertStatement)
{
$_SESSION['msg']="Enroll Successfully !!";

$countCreditSql="select SUM(course.courseCredit) as TotalCredit
from courseenrolls
join course on course.id=courseenrolls.course
join session on session.id=courseenrolls.session
join department on department.id=courseenrolls.department
join semester on semester.id=courseenrolls.semester
where courseenrolls.studentRegno='$student_id' AND semester.id='$semester' AND courseenrolls.session='$session' ";


$retTotalCredit=mysqli_query($con,$countCreditSql);
$rowTotalCredit=mysqli_fetch_array($retTotalCredit);
$sumCredit=$rowTotalCredit['TotalCredit'];
}
else
{
  $_SESSION['msg']="Error : Not Enroll";

}
}
else {
  $_SESSION['msg']="Sorry! Credit Limit Exceed For This Semester !!";
  echo "<script>
alert('Sorry !! Credit Limit Exceed');
window.location.href='enrollCourse.php';
</script>";

}

}

}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Course Enroll</title>

    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />




    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
          <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
           <script src="jquery.min.js"></script>
		   <script type="text/javascript">

$(document).ready(function(){

    $('#session').on('change',function(){
        var session = $(this).val();
        var sessionID=session;
        var semesterID=0;
        var intake =  $('#intake').val();
        var student_id =  $('#student_id').val();
        // alert('Correct! You guessed it in ' + intake);
         //alert('Correct! You guessed it in ' + sessionID);

        if(sessionID){
            $.ajax({
                type:'POST',
                url:'ajaxCheck/SelectMenu/ajaxData.php',
                // data:'sessionID='+sessionID,
                data: {
                  intake: intake,
                  student_id: student_id,
                sessionID: sessionID,
                semesterID: semesterID
              },
                success:function(html){
                   $('#semester').html(html);
                    // $('#semester').html('<option value=""></option>');

                    $('#course').html('<option value="">Select semester first</option>');
                }
            });
        }else{
            $('#session').html('<option value="">Select session first</option>');

        }



    });


    //Course

    $('#semester').on('change',function(){
        var semester = $(this).val();
        var semesterID=semester;

        var intake =  $('#intake').val();

        var sessionID =  $('#session').val();
        var student_id =  $('#student_id').val();

        //alert('Correct! You guessed it in ' + intake);
        //  alert('Correct! You guessed it in ' + sessionID);
         //alert('Correct! You guessed Semester ID  ' + semesterID);

        if(semesterID){
            $.ajax({
                type:'POST',
                url:'ajaxCheck/SelectMenu/ajaxData2.php',
                // data:'sessionID='+sessionID,
                data: {
                  intake: intake,
                  semesterID: semesterID,
                  student_id: student_id,
                  sessionID: sessionID
              },
                success:function(html){
                   $('#course').html(html);
                    //$('#course').html('<option value="">acca</option>');


                }
            });
        }else{
            $('#semester').html('<option value="">Select Semester First</option>');

        }
    });







});
</script>






</head>

<body>
<?php include('includes/header.php');


 include('includes/menubar.php');

 ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
              <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Course Enroll </h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                          Course Enroll
                        </div>
<font color="green" align="center">
  <?php echo htmlentities($_SESSION['msg']);?>
  <?php echo htmlentities($_SESSION['msg']=""); ?>
</font>

  <div class="panel-body">
<form name="courseEnrollForm" method="post" enctype="multipart/form-data">


  <div class="form-group">
      <label for="student_id">Student ID:  </label>
    <input class="form-control" type="text" name="student_id"  id="student_id" value="" placeholder="Enter student_id">
    </div>
<div class="form-group">
    <label for="department">department  </label>
    <select class="form-control" name="department" id="department" required="required">
   <option value="">Select department</option>
   <?php
$sql=mysqli_query($con,"select * from department");
while($row=mysqli_fetch_array($sql))
{
?>
<option value="<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['department']);?></option>
<?php } ?>

    </select>
  </div>
  <div class="form-group">
      <label for="seatlimit">Intake   </label>
      <select class="form-control intake" name="intake" id="intake">
        <option value="27">27</option>
        <option value="28">28</option>
        <option value="29">29</option>
        <option value="30">30</option>
        <option value="31">31</option>
        <option value="32">32</option>
        <option value="33">33</option>
        <option value="34">34</option>
        <option value="35">35</option>
        <option value="36">36</option>
        <option value="37">37</option>
        <option value="38">38</option>

      </select>
    </div>
<div class="form-group">
    <label for="Session">Session  </label>
    <select class="form-control" name="session" id="session" required="required">
   <option value="">Select Session</option>
   <?php
$sql=mysqli_query($con,"select * from session");
while($row=mysqli_fetch_array($sql))
{
?>
<option value="<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['session']);?></option>
<?php } ?>

    </select>
  </div>


<div class="form-group">
    <label for="Semester">Semester  </label>
    <select class="form-control" name="semester" id="semester" required="required">
           <option value="">Select Session first</option>
    </select>
  </div>


<div class="form-group">
    <label for="Course">Course  </label>
    <select class="form-control" name="course" id="course" required="required">
      <option value="">Select Course</option>
    </select>
    <span id="course-availability-status1" style="font-size:12px;">
  </div>

  <div class="form-group">

      <input type="text" class="form-control" id="totalCredit" name="totalCredit" readonly value="Max Credit Can be Taken: 18" required />
    </div>



 <button type="submit" name="submit" id="submit" class="btn btn-default">Enroll</button>
</form>
                            </div>
                            </div>
                    </div>

                </div>

            </div>





        </div>
    </div>
  <?php include('includes/footer.php');?>

    <script src="assets/js/bootstrap.js"></script>
      <script src="assets/js/jquery-1.11.1.js"></script>
<script>

function courseAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'cid='+$("#course").val(),
type: "POST",
success:function(data){
$("#course-availability-status1").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>


</body>
</html>
<?php } ?>
