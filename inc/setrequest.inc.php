<?php  
include_once 'dbh.inc.php';
include_once 'error.inc.php';
header('content-type: application/json');

if (isset($_GET['user'])) {
	$user = $_GET['user'];
	$to = $_GET['to'];

    $sql = "SELECT `id` FROM `user` WHERE `name`='$user'";
    $user = $conn->query($sql); 
    if ($user->fetch_assoc() != null) { 
    $user = $conn->query($sql)->fetch_assoc()['id']; 	
    }else{
    	$err7->err();
    	die();  
    }  
     if($user == $to){ 
         print_r(
         	json_encode( 
         		array(
         			'code' => 4,
         			 'msg'=> "can't message yourself",
         			 'type'=> 'error'  
         		)
         	)
         );
         die();
     }

    $sql= "INSERT INTO `request` (`user`,`to_user`) VALUES ('$user','$to')";
     if($conn->query($sql)){ 
         print_r(
         	json_encode( 
         		array(
         			'code' => 20,
         			 'msg'=> "user has been notified",
         			 'type'=> 'success' 
         		)
         	)
         );
     }else{
     	print_r(
         	json_encode(
         		array(
         			'code' => 5,
         			 'msg'=> "user could not be notified",
         			 'type'=> 'error'
         		)
         	)
         );
     }
} 