<?php 
include_once 'dbh.inc.php';
header('content-type: application/json') ; 
if (isset($_GET['user'])){
    $user = $_GET['user'];
    $sql = "UPDATE `user` SET `last_online`=CURRENT_TIMESTAMP WHERE `name`='$user'";
      $conn->query($sql); 
    print_r(
             json_encode( 
                  array(  
                  'code'=> 20, 
                  'user'=> $user, 
                  'msg'=> 'updated',
                 'type'=>'success'
                )
             )
          ) ; 
}