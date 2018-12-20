<?php
 class Transaction
 {
     function __construct($id, $body){
       $this->id = $id;
       // $this->node_id = $nodeid;
       // $this->user_id = $userid;
       $this->body = $body;
     }
 }//class Transaction
?>
