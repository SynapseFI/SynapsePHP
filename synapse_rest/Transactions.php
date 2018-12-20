<?php

class Transactions
{
  public $list_of_trans;
  public $trans_count;
  public $page;
  public $limit;
  public $page_count;

 function __construct($transcount, $list, $limit, $page_count, $page) {

    $this->list_of_trans = $list;
    $this->trans_count = $transcount;
    $this->limit = $limit;
    $this->page_count = $page_count;
    $this->page = $page;
 }

} // class Transactions




?>
