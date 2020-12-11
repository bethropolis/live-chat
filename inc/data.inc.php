<?php 
include_once 'dbh.inc.php';
header('content-type: application/json') ; 

     $arr = [];
     $i = 0;



     $dt = new DateTime(null, new DateTimeZone('Africa/Nairobi'));  
     $dt->format("Y-m-d H:i:s");   
     $dt = $dt->modify("-15 minutes"); 
     $dt = $dt->format('Y-m-d H:i:s'); 


	$sql = "SELECT `name`,`id`,`last_online` FROM `user` WHERE `last_online`> '$dt'";  
	$result = $conn->query($sql); 
	while($row = $result->fetch_assoc()){ 
        $arr[$i] = $row;    
            $i++; 
	}
	if (empty($arr)){ 
   print_r(
   	    json_encode(
    	     array(
   		   'code' => 20, 
   		   'msg' => 'no one is online', 
   		   'type' => 'successs', 
   	       )
   	     )
      );
      die();         
	}

   print_r(json_encode($arr));         
