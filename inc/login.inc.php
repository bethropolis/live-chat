<?php
include_once 'dbh.inc.php';
include_once 'error.inc.php';
header('content-type: application/json') ; 
if (isset($_POST['user'])){
    $user = $_POST['user'];
    $pwd = $_POST['pwd'];
   
     if (empty($user)|empty($pwd)) {
      	$err2->err();
      	die();
      }  

       $sql = "SELECT * FROM user WHERE `name`='$user'";
       $result = $conn->query($sql)->fetch_assoc();
      if($user == $result['name'] && $pwd == $result['password']){                 
         print_r( 
             json_encode( 
                  array( 
                  'code'=> 20, 
                  'user'=> $user,
                  'msg'=> 'successfully loged in',
                 'type'=>'success'
                )
             )
          ) ; 
       }else{ 
        $err1->err(); 
        die(); 
      } 
}