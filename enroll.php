<?php
session_start();


include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])==1 or strlen($_SESSION['pcode'])==0)
    {
header('location:index.php');
}
else{

if(isset($_POST['submit']))
{
$studentregno=$_POST['studentregno'];
$pincode=$_POST['Pincode'];
$session=$_POST['session'];
$dept=$_POST['department_id'];
$course=$_POST['course'];
$sem=$_POST['semester'];


$conditionSql="select * from courseenrolls where studentRegno='$studentregno' AND course='$course' AND semester='$sem' AND session='$session'  ";
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
where courseenrolls.studentRegno='".$_SESSION['login']."' AND semester.id='$sem' ";


$retTotalCredit2=mysqli_query($con,$countCreditSql2);
$rowTotalCredit2=mysqli_fetch_array($retTotalCredit2);
$sumCredit2=$rowTotalCredit2['TotalCredit'];




$sumofCredit=$rowCredit['courseCredit'];
$sumCreditFinal=$sumofCredit+$sumCredit2;
echo $sumCredit2;
echo $sumCreditFinal;

//Logic of PReRequisite Course
$sqlCheckPrequisite="Select preRequisiteID FROM course where course.id='$course'";
$retpreRequisite=mysqli_query($con,$sqlCheckPrequisite);
$rowPreRequisite=mysqli_fetch_array($retpreRequisite);
$preRequisiteID=$rowPreRequisite['preRequisiteID'];

if ($preRequisiteID==0) {

//End of  PReRequisite Course SQL
if ($sumCreditFinal<19) {
$insertStatement=mysqli_query($con,"insert into courseenrolls(studentRegno,session,department,course,semester) values('$studentregno','$session','$dept','$course','$sem')");

if($insertStatement)
{
$_SESSION['msg']="Enroll Successfully !!";

$countCreditSql="select SUM(course.courseCredit) as TotalCredit
from courseenrolls
join course on course.id=courseenrolls.course
join session on session.id=courseenrolls.session
join department on department.id=courseenrolls.department
join semester on semester.id=courseenrolls.semester
where courseenrolls.studentRegno='".$_SESSION['login']."' AND semester.id='$sem' ";


$retTotalCredit=mysqli_query($con,$countCreditSql);
$rowTotalCredit=mysqli_fetch_array($retTotalCredit);
$sumCredit=$rowTotalCredit['TotalCredit'];
}
else
{
  $_SESSION['msgError']="Error : Not Enroll";

}
}
else {
  $_SESSION['msgError']="Sorry! Credit Limit Exceed For This Semester !!";
  echo "<script>
alert('Sorry !! Credit Limit Exceed');
window.location.href='enroll.php';
</script>";

}

}
// End of preRequisiteID 0 Start of ELSE
else {
    //$_SESSION['msg']="Sorry! First You Have to Complete Prerequiste Course !!";

    $sqlchekEnroll="SELECT course FROM courseenrolls where courseenrolls.studentRegno='".$_SESSION['login']."' AND courseenrolls.course='$preRequisiteID' ";

    $retCheckEnroll=mysqli_query($con,$sqlchekEnroll);
    $rowcheckEnroll=mysqli_fetch_array($retCheckEnroll);
    print_r($rowcheckEnroll);
    if ($rowcheckEnroll>0) {
      if ($sumCreditFinal<19) {
      $insertStatement=mysqli_query($con,"insert into courseenrolls(studentRegno,session,department,course,semester) values('$studentregno','$session','$dept','$course','$sem')");

      if($insertStatement)
      {
      $_SESSION['msg']="Enroll Successfully !!";

      $countCreditSql="select SUM(course.courseCredit) as TotalCredit
      from courseenrolls
      join course on course.id=courseenrolls.course
      join session on session.id=courseenrolls.session
      join department on department.id=courseenrolls.department
      join semester on semester.id=courseenrolls.semester
      where courseenrolls.studentRegno='".$_SESSION['login']."' AND semester.id='$sem' ";


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
      window.location.href='enroll.php';
      </script>";

      }
    }
    else {
      $sqlPreRequisiteName="SELECT * FROM course where course.id='$preRequisiteID' ";

      $retPreRequisiteName=mysqli_query($con,$sqlPreRequisiteName);
      $rowPreRequisiteName=mysqli_fetch_array($retPreRequisiteName);
      $preRequsiteName=$rowPreRequisiteName['courseName'];
      $_SESSION['msgError']="Sorry!Prerequiste Course Incomplete!!First You Have to Complete : ".$preRequsiteName;
    }
}
//End of ELSE preRequisiteID Condition

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
        // alert('Correct! You guessed it in ' + intake);
         //alert('Correct! You guessed it in ' + sessionID);

        if(sessionID){
            $.ajax({
                type:'POST',
                url:'ajaxCheck/SelectMenu/ajaxData.php',
                // data:'sessionID='+sessionID,
                data: {
                  intake: intake,
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
<?php include('includes/header.php');?>
    <!-- LOGO HEADER END-->
<?php if($_SESSION['login']!="")
{
 include('includes/menubar.php');
}
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
<font color="red" align="center">
  <?php echo htmlentities($_SESSION['msgError']);?>
  <?php echo htmlentities($_SESSION['msgError']=""); ?>
</font>
<?php
$sql=mysqli_query($con,"select students.department as deptID, students.studentName,students.StudentRegno,department.department,students.intake,students.pincode,students.studentPhoto from students,department where department.id=students.department AND StudentRegno='".$_SESSION['login']."'");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{ ?>

                        <div class="panel-body">
                       <form name="dept" method="post" enctype="multipart/form-data">
   <div class="form-group">
    <label for="studentname">Student Name  </label>
    <input type="text" class="form-control" id="studentname" name="studentname" value="<?php echo htmlentities($row['studentName']);?>"  />
  </div>

 <div class="form-group">
    <label for="studentregno">Student ID   </label>
    <input type="text" class="form-control" id="studentregno" name="studentregno" value="<?php echo htmlentities($row['StudentRegno']);?>"  placeholder="Student Reg no" readonly />

  </div>
 <div class="form-group">
    <label for="studentregno">Department  </label>
    <input type="text" class="form-control" id="department" name="department" value="<?php echo htmlentities($row['department']);?>"  placeholder="Student Reg no" readonly />
   <input type="hidden" name="department_id" value="<?php echo $row['deptID'];?>">
  </div>
 <div class="form-group">
    <label for="studentregno">Intake   </label>
    <input type="text" class="form-control" id="intake" name="intake" value="<?php echo htmlentities($row['intake']);?>"  placeholder="Student Intake no" readonly />

  </div>



<!-- <div class="form-group">
    <label for="Pincode">Pincode  </label>
    <input type="text" class="form-control" id="Pincode" name="Pincode" readonly value="<?php echo htmlentities($row['pincode']);?>" required />
  </div> -->

<div class="form-group">
    <label for="Pincode">Student Photo  </label>
   <?php if($row['studentPhoto']==""){ ?>
   <img src="studentphoto/noimage.png" width="200" height="200"><?php } else {?>
   <img src="studentphoto/<?php echo htmlentities($row['studentPhoto']);?>" width="200" height="200">
   <?php } ?>
  </div>
 <?php } ?>

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
