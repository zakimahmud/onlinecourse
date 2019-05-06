
<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0)
    {
header('location:index.php');
}
else{
  if(isset($_POST['submit']))
  {
    $session=$_POST['session'];
    $semester=$_POST['semester'];

    $sqlSemester=mysqli_query($con,"select * from semester where id='$semester'");
     $rowSemester=mysqli_fetch_array($sqlSemester);
    $semesterName=$rowSemester['semester'];

    $sqlSession=mysqli_query($con,"select * from session where id='$session'");
     $rowSession=mysqli_fetch_array($sqlSession);
    $sessionName=$rowSession['session'];

    $retrieveSQL="select courseenrolls.course as cid, course.courseCode as courseCode,course.courseName as courname,course.courseCredit as Credit,session.session as session,department.department as dept,courseenrolls.enrollDate as edate ,semester.semester as sem from courseenrolls
    join course on course.id=courseenrolls.course
    join session on session.id=courseenrolls.session
    join department on department.id=courseenrolls.department
    join semester on semester.id=courseenrolls.semester
    where courseenrolls.studentRegno='".$_SESSION['login']."' AND courseenrolls.semester='$semester' AND courseenrolls.session='$session' ";
    $sqlResult=mysqli_query($con,$retrieveSQL);
    $sqlResult2=mysqli_query($con,$retrieveSQL);


?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Course Details Print</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
$(function () {
  $("#btnPrint").click(function () {
      var contents = $("#CenterDiv").html();
      var frame1 = $('<iframe />');
      frame1[0].name = "frame1";
      frame1.css({ "position": "absolute", "top": "-1000000px" });
      $("body").append(frame1);
      var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
      frameDoc.document.open();
      //Create a new HTML document.
      frameDoc.document.write('<html><head><title>Online Course Management System</title>');
      frameDoc.document.write('</head><body>');
      //Append the external CSS file.
      frameDoc.document.write('<link href="style.css" rel="stylesheet" type="text/css" />');
      //Append the DIV contents.
      frameDoc.document.write(contents);
      frameDoc.document.write('</body></html>');
      frameDoc.document.close();
      setTimeout(function () {
          window.frames["frame1"].focus();
          window.frames["frame1"].print();
          frame1.remove();
      }, 500);
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
                        <h1 class="page-head-line">Course Details</h1>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                      Course Details
                        </div>



                        <div class="panel-body" id="CenterDiv">
                          <div class="table-responsive table-bordered">
                              <table class="table">
                          <table>
                            <tbody>

                          <?php $sql=mysqli_query($con,"select * from students where StudentRegno='".$_SESSION['login']."'");

                          while($row_info=mysqli_fetch_array($sql))
                          { ?>

                        <tr>
                          <td></td>
                          <td colspan="2"><b>StudentRegno</b></td>
                          <td>:</td>
                          <td></td>
                          <td>&nbsp; <i><?php echo $row_info['StudentRegno']; ?></i> </td>
                        </tr>
                        <tr>
                          <td></td>
                          <td colspan="2"><b>Student Name</td>
                          <td>:</td>
                          <td></td>
                          <td>&nbsp;<i> <?php echo $row_info['studentName']; ?> </i></td>

                        </tr>

                        <tr>
                          <td></td>
                          <td colspan="2"><b>Session</b></td>
                          <td>: </td>
                          <td></td>
                          <td>&nbsp;<i><?php echo $sessionName; ?><i></td>

                        </tr>
                        <tr>
                          <td></td>
                          <td colspan="2"><b>Session</b></td>
                          <td>:</td>
                          <td></td>
                          <td>&nbsp; <i><?php echo $semesterName; ?><i> </td>
                        </tr>


                          <?php } ?>

                          </tbody>
            </table>
          </div>

            <div class="table-responsive table-bordered">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Course Name </th>
                            <th>Course Code </th>
                            <th>Session </th>
                            <th> Department</th>
                              <th>Credit</th>
                                <th>Semester</th>
                             <th>Enrollment Date</th>

                        </tr>
                    </thead>
                    <tbody>
<?php

$numRowsCredit=mysqli_fetch_array($sqlResult);
if($numRowsCredit>0)
{
  $countCreditSql2="select SUM(course.courseCredit) as TotalCredit
  from courseenrolls
  join course on course.id=courseenrolls.course
  join session on session.id=courseenrolls.session
  join department on department.id=courseenrolls.department
  join semester on semester.id=courseenrolls.semester
  where courseenrolls.studentRegno='".$_SESSION['login']."' AND semester.id='$semester' AND courseenrolls.session='$session' ";


  $retTotalCredit2=mysqli_query($con,$countCreditSql2);
  $rowTotalCredit2=mysqli_fetch_array($retTotalCredit2);
  $sumCredit2=$rowTotalCredit2['TotalCredit'];

$cnt=1;
while($row_Course=mysqli_fetch_array($sqlResult2))
{
?>


                        <tr>
                            <td><?php echo $cnt;?></td>
                            <td><?php echo $row_Course['courname'];?></td>
                            <td><?php echo $row_Course['courseCode'];?></td>
                            <td><?php echo $row_Course['session'];?></td>
                            <td><?php echo $row_Course['dept'];?></td>
                            <td><?php echo $row_Course['Credit'];?></td>
                            <td><?php echo $row_Course['sem'];?></td>
                             <td><?php echo $row_Course['edate'];?></td>
                            <td>


                            </td>
                        </tr>
<?php
$cnt++;
} } else { ?>
  <tr class="btn-danger">
  <td colspan="8">No Course Available</td>
   </tr>
<?php } ?>
            <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>---------</td>
            <td></td>

            </tr>
            <tr class="btn-danger">
              <td></td>
              <td></td>
              <td></td>
              <td class="btn-danger" colspan="2"><b>TotalCredit:</b></td>
              <td ><?php echo $sumCredit2; ?></td>
              <td colspan="2"></td>

            </tr>

                    </tbody>
                </table>
            </div>
<hr style="height:1px; border:none; color:#000; background-color:#000; width:90%; text-align:right; margin: 0 0 0 auto;">

                            </div>
                            <button class="btn btn-primary hidden-print btn pull-right btn-lg" id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
                            </div>
                    </div>

                </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
  <?php include('includes/footer.php');?>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.11.1.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
</body>
</html>
<?php } }?>
