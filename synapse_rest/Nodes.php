<?php

class Nodes
{
  public $list_of_nodes;
  public $nodes_count;
  public $limit;
  public $page_count;
  public $page;

 function __construct($nodescount, $list, $page, $page_count, $limit) {

    $this->list_of_nodes = $list;
    $this->nodes_count = $nodescount;
    $this->limit = $limit;
    $this->page_count = $page_count;
    $this->page = $page;
 }

} // class Nodes
?>
