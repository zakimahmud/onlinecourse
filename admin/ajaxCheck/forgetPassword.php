<?php
$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'../../lib/Session.php');
	include_once ($filepath.'../../classes/User.php');
	$usr= new User();

if($_SERVER['REQUEST_METHOD']=='POST'){
   //   $user_email=$_POST['forgetEmail'];
	     $user_email=$_POST['email'];
      // echo $user_email;    
   echo $forget_password=$usr->User_forget_password($user_email);
    // echo $forget_password ;

}

?>
