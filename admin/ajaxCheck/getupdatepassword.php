<?php 
$filepath = realpath(dirname(__FILE__));
  include_once ($filepath.'../../lib/Session.php');
    include_once ($filepath.'../../classes/User.php');
    $usr= new User();
    //Session::init();
    //$user_id=$_SESSION['userid'];
if($_SERVER['REQUEST_METHOD']=='POST'){

   
    $password1=$_POST['password1'];
    $password2=$_POST['password2'];
    $password3=$_POST['password3'];
    $user_id=$_POST['user_id'];

    $user_Reg=$usr->user_Update_Password($password1,$password2,$password3,$user_id);
   
   
}

        
            




 
   