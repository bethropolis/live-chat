<?php  
include_once 'dbh.inc.php';
header('content-type: application/json');
if (isset($_POST['user'])){
$user = $_POST['user'];
$sql = "SELECT `id` FROM `user` WHERE `name`='$user'";
$user = $conn->query($sql)->fetch_assoc()['id']; 

$sql = "DELETE FROM `request` WHERE `user`='$user'" ;
$conn->query($sql);

$sql = "DELETE FROM `chat` WHERE `who_from` = '$user' OR `who_to`='$user'";
$conn->query($sql);

$sql = "DELETE FROM `user` WHERE `id`='$user'" ;
$conn->query($sql);
print_r(	  	
	  json_encode(
                [
                    'code'=> 20, 
                    'msg'=>' user deleted',
                    'type'=> 'success'  

	  		  ] 
	  	 )
	  ); 


}