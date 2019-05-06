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
$studentName=$_POST['studentname'];
$StudentRegno=$_POST['StudentRegno'];
$intake=$_POST['intake'];
$department=$_POST['department'];
$pincode=$_POST['pincode'];
$password=$_POST['password'];
$confirmPassword=$_POST['confirmPassword'];
if ($password!=$confirmPassword) {
    $_SESSION['msg']="Error : Password Do Not Matched";
}
else {

  $reg=mysqli_query($con,"insert into students(studentName,StudentRegno,department,intake,pincode,password) values('$studentName','$StudentRegno','$department','$intake','$pincode',md5($password))");
  if($reg)
  {
  $_SESSION['msg']="Student Registration Successfully !!";
  $extra="index.php";//
  header('location:index.php');
  exit();

  }
  else
  {
    $_SESSION['msg']="Error : Student not Registerd";
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
    <title>Registration</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body>
<?php include('includes/header.php');?>
    <!-- LOGO HEADER END-->
<?php if($_SESSION['login']!="")
// {
//  include('includes/menubar.php');
// }
 ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
              <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Student Registration  </h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                          Student Registration
                        </div>
<font color="green" align="center"><?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>

                        <div class="panel-body">
                       <form name="reg" method="post" enctype="multipart/form-data">
   <div class="form-group">
    <label for="studentname">Student Name  </label>
    <input type="text" class="form-control" id="studentname" name="studentname"   />
  </div>

 <div class="form-group">
    <label for="studentregno">Student Reg No   </label>
    <input type="text" class="form-control" id="StudentRegno" name="StudentRegno"   placeholder="Student Reg no"  />

  </div>

 <div class="form-group">
    <label for="studentregno">Enter Your Department    </label>
    <select class="form-control" name="department" id="department" required="required">
   <option value="">Select Department</option>
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
    <label for="studentregno">Type Your Intake   </label>
    <input type="text" class="form-control" id="intake" name="intake"   placeholder="Intake"  />

  </div>
 <div class="form-group">
    <label for="studentregno">Password</label>
    <input type="password" class="form-control" id="password" name="password"   placeholder="Enter Your Password"  />

  </div>
 <div class="form-group">
    <label for="studentregno">Confirm Password</label>
    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"   placeholder="Confirm Your Password"  />

  </div>



<div class="form-group">
    <label for="Pincode">Pincode  </label>
    <input type="text" class="form-control" id="pincode" name="pincode"   required />
  </div>








 <button type="submit" name="submit" id="submit" class="btn btn-default">Register</button>
</form>
                            </div>
                            </div>
                    </div>

                </div>

            </div>





        </div>
    </div>
  <?php include('includes/footer.php');?>
    <script src="assets/js/jquery-1.11.1.js"></script>
    <script src="assets/js/bootstrap.js"></script>


</body>
</html>
<?php } ?>
