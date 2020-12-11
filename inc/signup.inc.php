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
       $result = $conn->query($sql);
    if (!is_null($result->fetch_assoc())) {
      	$err4->err();
      	die();
      }  

    $sql = "INSERT INTO `user` (`name`,`password`) VALUES (?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss',$user,$pwd);
   $stmt->execute();   
   print_r(
       json_encode( 
           array( 
               'code'=> 20, 
               'msg'=> 'user successfully created',
               'type'=>'success'
             )
           )
       ) ; 
 }
 