<?php
include_once 'dbh.inc.php';
include_once 'error.inc.php';
header('content-type: application/json') ; 

$result = array();
if (isset($_POST['from'])) { 

$message = $_POST['message']; 
$from = $_POST['from'];
$to =  $_POST['to']; 
 
    $sql = "SELECT `id` FROM `user` WHERE `name`='$from'";
    $user = $conn->query($sql); 
    if ($user->fetch_assoc() != null) { 
    $from = $conn->query($sql)->fetch_assoc()['id']; 	
    }else{
    	$err7->err();
    	die();  
    }  

if (!empty($message) && !empty($from)) {
	$query = "INSERT INTO chat (`message`, `who_from`, `who_to` ) VALUES ('".$message."','".$from."', '".$to."')";   
	$conn->query($query); 
	$result = print_r(
		json_encode(
			array(
                 'code'=> 20,
                 'msg'=> 'message successfully sent',
                 'type'=> 'success'
			)
		)
	);
	die();
 }else{ 
 	 $err2->err(); 
 	 die();
 }
} 
if (isset($_GET['start'])){ 

$start = $_GET['start']; 
$from = $_GET['from']; 
$to = $_GET['to'];

$sql = "SELECT `id` FROM `user` WHERE `name`='$from'"; 
$user = $conn->query($sql); 
  if ($user->fetch_assoc() != null) { 
   $from = $conn->query($sql)->fetch_assoc()['id']; 	
 }else{
   $err7->err();
   die();  
 } 
 
$items = $conn->query("SELECT * FROM `chat` WHERE `id`>".$start." AND (`who_to`='$to' OR `who_to`='$from')  AND (`who_from`='$from' OR `who_from`='$to');");           
while ($row = $items->fetch_assoc()) { 
	$result['items'][]= $row;  
 }    
}  
  
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
print_r(json_encode($result));