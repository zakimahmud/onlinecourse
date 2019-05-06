<?php
session_start();
include('includes/config.php');
?>
<?php
if(strlen($_SESSION['alogin'])==0)
{
header('location:index.php');
}
else{
  if(isset($_POST['submit']))
  {

  $course_id1=$_POST['course_id1'];

    print_r($course_id1);
    echo '<br/>';
  $course_id2=$_POST['course_id2'];
  print_r($course_id2);
  echo '<br/>';
  $course_id3=$_POST['course_id3'];
  print_r($course_id3);
  echo '<br/>';
  $course_id4=$_POST['course_id4'];
  print_r($course_id4);
  echo '<br/>';
  $course_id5=$_POST['course_id5'];
  print_r($course_id5);
  echo '<br/>';
  $course_id6=$_POST['course_id6'];
  print_r($course_id6);
  echo '<br/>';
  $course_id7=$_POST['course_id7'];
  print_r($course_id7);
  echo '<br/>';
  $course_id8=$_POST['course_id8'];
  print_r($course_id8);
  echo '<br/>';
  $course_id9=$_POST['course_id9'];
  print_r($course_id9);
  echo '<br/>';
  $intake=$_POST['intake'];
  print_r($intake);
  echo '<br/>';
  $department=$_POST['department'];
  print_r($department);
  echo '<br/>';
  $session=$_POST['session'];
  print_r($session);
  echo '<br/>';
  $semester=$_POST['semester'];
  print_r($semester);
  echo '<br/>';
  $insert=mysqli_query($con,"insert into courseofferlsit(department,intake,session,semester,course1,course2,course3,course4,course5,course6,course7,course8,course9)
  values('$department','$intake','$session','$semester','$course_id1','$course_id2','$course_id3','$course_id4','$course_id5','$course_id6','$course_id7','$course_id8','$course_id9')");
  if($insert)
  {
  $_SESSION['msg']="Course Added Successfully !!";
  }
  else
  {
    $_SESSION['msg']="Error : Course not Added";
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
    <title>Admin | Course</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
          <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
           <script src="jquery.min.js"></script>
		   <!-- <script type="text/javascript">

$(document).ready(function(){

    $('#session').on('change',function(){
        var session = $(this).val();
        var sessionID=session;
        var department =  $('#department').val();
        var departmentID=department;
        var intake =  $('#intake').val();
        var intakeID=intake;
        var semester =  $('#semester').val();
        var semesterID=semester;
        // alert('Correct! You guessed it in ' + intake);
         //alert('Correct! You guessed it in ' + sessionID);

        if(sessionID){
            $.ajax({
                type:'POST',
                url:'SelectMenu/ajaxData.php',

                data: {
                  departmentID: departmentID,
                  intakeID: intakeID,
                sessionID: sessionID,
                semesterID: semesterID
              },
                success:function(html){
                    // alert('Correct! You guessed it in ' + intake);
                   // $('#semester').html(html);
                   //  // $('#semester').html('<option value=""></option>');
                   //
                   //  $('#course').html('<option value="">Select semester first</option>');
                }
            });
        }else{
            $('#session').html('<option value="">Select session first</option>');

        }



    });
    </script> -->
</head>

<body>
<?php include('includes/header.php'); ?>
    <!-- LOGO HEADER END-->
<?php if($_SESSION['alogin']!="")
{
 include('includes/menubar.php');
}
 ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
              <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Course  </h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           Course
                        </div>
<font color="green" align="center"><?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>


                        <div class="panel-body">
                       <form name="dept" method="post">


                         <div class="form-group">
                             <label for="department">Department  </label>
                             <select class="form-control" name="department" id="department" required="required">
                            <option value="">Select A Department</option>
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
                             <label for="Session">semester  </label>
                             <select class="form-control" name="semester" id="semester" required="required">
                            <option value="">Select semester</option>
                            <?php
                         $sql=mysqli_query($con,"select * from semester");
                         while($row=mysqli_fetch_array($sql))
                         {
                         ?>
                         <option value="<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['semester']);?></option>
                         <?php } ?>

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
      <label for="course_id1">course 1*  </label>
      <select class="form-control" name="course_id1" id="course_id1" >
     <option value="0">Select course</option>
     <?php
  $sql=mysqli_query($con,"select * from course");
  while($row=mysqli_fetch_array($sql))
  {
  ?>
  <option value="<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['courseName']);?></option>
  <?php } ?>

      </select>
    </div>

  <div class="form-group">

      <label for="course_id1">course 2*  </label>
      <select class="form-control" name="course_id2" id="course_id2" >
     <option value="0">Select course</option>
     <?php
  $sql=mysqli_query($con,"select * from course");
  while($row=mysqli_fetch_array($sql))
  {
  ?>
  <option value="<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['courseName']);?></option>
  <?php } ?>

      </select>
    </div>
  <div class="form-group">

      <label for="course_id3">course 3  </label>
      <select class="form-control" name="course_id3" id="course_id3" >
     <option value="0">Select course</option>
     <?php
  $sql=mysqli_query($con,"select * from course");
  while($row=mysqli_fetch_array($sql))
  {
  ?>
  <option value="<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['courseName']);?></option>
  <?php } ?>

      </select>
    </div>
  <div class="form-group">

      <label for="course_id4">course 4*  </label>
      <select class="form-control" name="course_id4" id="course_id4" >
     <option value="0">Select course</option>
     <?php
  $sql=mysqli_query($con,"select * from course");
  while($row=mysqli_fetch_array($sql))
  {
  ?>
  <option value="<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['courseName']);?></option>
  <?php } ?>

      </select>
    </div>
  <div class="form-group">

      <label for="course_id1">course 5*  </label>
      <select class="form-control" name="course_id5" id="course_id5" >
     <option value="0">Select course</option>
     <?php
  $sql=mysqli_query($con,"select * from course");
  while($row=mysqli_fetch_array($sql))
  {
  ?>
  <option value="<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['courseName']);?></option>
  <?php } ?>

      </select>
    </div>
  <div class="form-group">

      <label for="course_id1">course 6*  </label>
      <select class="form-control" name="course_id6" id="course_id6" >
     <option value="0">Select course</option>
     <?php
  $sql=mysqli_query($con,"select * from course");
  while($row=mysqli_fetch_array($sql))
  {
  ?>
  <option value="<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['courseName']);?></option>
  <?php } ?>

      </select>
    </div>
  <div class="form-group">

      <label for="course_id7">course 7*  </label>
      <select class="form-control" name="course_id7" id="course_id7" >
     <option value="0">Select course</option>
     <?php
  $sql=mysqli_query($con,"select * from course");
  while($row=mysqli_fetch_array($sql))
  {
  ?>
  <option value="<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['courseName']);?></option>
  <?php } ?>

      </select>
    </div>
  <div class="form-group">

      <label for="course_id8">course 8*  </label>
      <select class="form-control" name="course_id8" id="course_id8" >
     <option value="0">Select course</option>
     <?php
  $sql=mysqli_query($con,"select * from course");
  while($row=mysqli_fetch_array($sql))
  {
  ?>
  <option value="<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['courseName']);?></option>
  <?php } ?>

      </select>
    </div>
  <div class="form-group">

      <label for="course_id9">course 9*  </label>
      <select class="form-control" name="course_id9" id="course_id9" >
     <option value="0">Select course</option>
     <?php
  $sql=mysqli_query($con,"select * from course");
  while($row=mysqli_fetch_array($sql))
  {
  ?>
  <option value="<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['courseName']);?></option>
  <?php } ?>

      </select>
    </div>
  <div class="form-group">

      <label for="course_idTest">Test *  </label>
      <select class="form-control" name="course_idTest" id="course_idTest" >
     <option value="0">Select course</option>
     <?php
  $sql=mysqli_query($con,"select * from course");
  while($row=mysqli_fetch_array($sql))
  {
  ?>
  <option value="<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['courseName']);?></option>
  <?php } ?>

      </select>
    </div>

 <button type="submit" name="submit" class="btn btn-default">Submit</button>
</form>
                            </div>
                            </div>
                    </div>

                </div>
                <font color="red" align="center"><?php echo htmlentities($_SESSION['delmsg']);?><?php echo htmlentities($_SESSION['delmsg']="");?></font>
                <div class="col-md-12">
                    <!--    Bordered Table  -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Manage Course
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Course Code</th>
                                            <th>Course Name </th>
                                            <th>Course Unit</th>
                                            <th>Seat limit</th>
                                             <th>Creation Date</th>
                                             <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$sql=mysqli_query($con,"select * from course");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{
?>


                                        <tr>
                                            <td><?php echo $cnt;?></td>
                                            <td><?php echo htmlentities($row['courseCode']);?></td>
                                            <td><?php echo htmlentities($row['courseName']);?></td>
                                            <td><?php echo htmlentities($row['courseUnit']);?></td>
                                             <td><?php echo htmlentities($row['noofSeats']);?></td>
                                            <td><?php echo htmlentities($row['creationDate']);?></td>
                                            <td>
                                            <a href="edit-course.php?id=<?php echo $row['id']?>">
<button class="btn btn-primary"><i class="fa fa-edit "></i> Edit</button> </a>
  <a href="course.php?id=<?php echo $row['id']?>&del=delete" onClick="return confirm('Are you sure you want to delete?')">
                                            <button class="btn btn-danger">Delete</button>
</a>
                                            </td>
                                        </tr>
<?php
$cnt++;
} ?>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                     <!--  End  Bordered Table  -->
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
