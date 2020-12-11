<?php  
include_once 'dbh.inc.php';
header('content-type: application/json');

if (isset($_GET['user'])){
	 $user = $_GET['user'];
     $dt = new DateTime(null, new DateTimeZone('Africa/Nairobi'));  
     $dt->format("Y-m-d H:i:s");   
     $dt = $dt->modify("-5 minutes");  
     $dt = $dt->format('Y-m-d H:i:s'); 

     $sql = "SELECT `id` FROM `user` WHERE `name`='$user'";
     $user = $conn->query($sql)->fetch_assoc()['id'];     

	 $sql = "SELECT `user` FROM `request` WHERE  `to_user`='$user' AND `time`>'$dt'";    
	 $result = $conn->query($sql);   

	if ($result->fetch_assoc() != null) {   
		 $sql = "SELECT * FROM `request` WHERE  `to_user`='$user' AND `time`>'$dt' ORDER BY `request`.`id` DESC";  
	     $result = $conn->query($sql)->fetch_assoc();  
        $result = $result['user'];    
         $sql = "SELECT `name`,`id` FROM `user` WHERE `id`='$result'";
         $user = $conn->query($sql)->fetch_assoc(); 
          
	  	print_r(
	  		json_encode(
                [
                    'code'=> 20,
                    'id' =>  $user['id'],
                    'msg'=> $user['name'].' sent you a request',
                    'type'=> 'accept'  

	  			] 
	  		)
	  	); 
	  }else{
	  		print_r(
	  		json_encode(
	  			[
                    'code'=> 22,
                    'msg'=> 'no current request',
                    'type'=> 'info'

	  			]
	  		)
	  	); 
	  }  
	
}