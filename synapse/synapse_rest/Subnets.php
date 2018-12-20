<?php
 class Subnets
 {
     public $node_id;
     public $subnet_list;
     public $page;
     public $per_page;

     function __construct($id, $list ,$page, $per_page){
       $this->node_id = $id;
       $this->page = $page;
       $this->subnet_list = $list;
       $this->per_page = $per_page;
     }
 }
?>
