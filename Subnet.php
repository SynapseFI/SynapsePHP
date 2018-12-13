<?php
 class Subnet
 {
     public $node_id;
     public $subnet_id;
     public $user_id;
     public $body;

     function __construct($node_id, $subnetid, $userid, $body){
       $this->node_id = $node_id;
       $this->subnet_id = $subnetid;
       $this->user_id = $user_id;
       $this->body = $body;
     }
 }
?>
