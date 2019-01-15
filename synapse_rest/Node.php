<?php

class Node
{

function __construct($payload, $userID, $nodeID, $nodeType) {


   $this->node_id = $nodeID;
   $this->user_id = $userID;
   $this->body = $payload;
   $this->type = $nodeType;

 }

} // class Node

?>
