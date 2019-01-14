<?php

class Node
{

function __construct($payload, $userID, $nodeID, $nodeType, $full_dehydrate) {


   $this->node_id = $nodeID;
   $this->user_id = $userID;
   $this->body = $payload;
   $this->type = $nodeType;
   $this->full_dehydrate = $full_dehydrate;

 }

} // class Node

?>
