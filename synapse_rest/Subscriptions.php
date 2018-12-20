<?php

class Subscriptions
{

    public $list_of_subs;
    public $subscriptions_count;
    public $page;
    public $limit;
    public $page_count;


 function __construct($list, $subscount, $page, $limit, $page_count ) {
    $this->list_of_subs = $list;
    $this->subscriptions_count = $subscount;
    $this->page = $page;
    $this->limit= $limit;
    $this->page_count = $page_count;
 }

} // class Subscriptions
?>
