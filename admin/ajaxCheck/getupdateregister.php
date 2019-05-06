<?php 
$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'../../lib/Session.php');
	include_once ($filepath.'../../classes/User.php');
	$usr= new User();
	
if($_SERVER['REQUEST_METHOD']=='POST'){

    $full_name=$_POST['full_name'];
    $university_name=$_POST['university_name'];
    $email=$_POST['email'];
    $mobileNo=$_POST['mobileNo'];
    $Address=$_POST['Address'];
    $Gender=$_POST['Gender'];
  
    // echo $Address;
    //  echo "<br/";
    // echo $mobileNo;
    // echo "<br/";
    // echo $university_name;
    //  echo "<br/";
    // echo $email;
    //  echo "<br/";
    // echo $full_name;
    //  echo "<br/";
    // echo $Gender;


    $user_Reg=$usr->user_update_profile($full_name,$university_name,$email,$mobileNo,$Address,$Gender);
   
   
}

		
			

?>