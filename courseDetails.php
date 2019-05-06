
<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0)
    {
header('location:index.php');
}
else {

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
    <title>Pincode Verification</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
$(function () {
  // $("#submit").click(function(){
  //  $('#CenterDiv').show();
  // });
  $("#btnPrint").click(function () {
     $('#CenterDiv').show();
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
                        <h1 class="page-head-line">Student Course details</h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                        Course Details
                        </div>
<font color="red" align="center"><?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>

 <form action="courseDetailsPrint.php" name="courseDetailsPrint" method="post" enctype="multipart/form-data">
                        <div class="panel-body">

                        <div class="">


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
                               <label for="semester">semester  </label>
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

  <button type="submit" name="submit" class="btn btn-info">View Details</button>





</form>
                            </div>
                            <!-- End of Panel Body -->
                            
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
