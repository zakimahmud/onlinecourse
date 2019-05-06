<?php 
$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'../../lib/Session.php');
	include_once ($filepath.'../../classes/User.php');
	$usr= new User();
	
if($_SERVER['REQUEST_METHOD']=='POST'){

    $full_name=$_POST['full_name'];
    $university_name=$_POST['university_name'];
    $password=$_POST['password'];
    $email=$_POST['email'];
    $mobileNo=$_POST['mobileNo'];
    $Address=$_POST['Address'];
    $Gender=$_POST['Gender'];
   


    $user_Reg=$usr->user_Registration($full_name,$university_name,$email,$password,$mobileNo,$Address,$Gender);
   
   
}

		
			

?>