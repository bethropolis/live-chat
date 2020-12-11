<?php
class Err{
    public $code;
    public $err_msg;
    public $print;

   public function __construct($status){
       $this->code = $status;  
   }
   public function err(){
    $status = $this->code ;  
       $error_array = ['wrong information given','user does not exist','empty fields','user not found','username already exist','can not send message','wrong password','you are not autorised'];
       $this->print = print_r( 
             json_encode(  
                array(
                    'code'=> $status, 
                    'msg'=> $error_array[$status],
                    'type'=>'error'
                )
             ) 
       ); 
       return $this->print; 
   }
   
} 
$err1 = new Err(1);
$err2 = new Err(2);
$err3 = new Err(3);
$err4 = new Err(4);
$err5 = new Err(5);
$err6 = new Err(6);
$err7 = new Err(7);
