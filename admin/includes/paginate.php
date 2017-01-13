<?php

    class Paginate
    {

        public $total_items;
        public $items_per_page;
        public $total_pages;
        public $current_page;


        public function __construct($current_page=1,$total_items=0,$items_per_page=4)
        {
            $this->items_per_page=(int)$items_per_page;
            $this->current_page=(int)$current_page;
            $this->total_items=(int)$total_items;
        }


        public function next()
        {
            return $this->current_page + 1;
        }//end of next method

        public function previous(){
            return $this->current_page-1;
        }
        public function has_next(){

            return $this->total_pages() > $this->current_page ? true:false;
        }
        public function has_previous(){

            return $this->current_page-1 >= 1 ? true:false;
        }
        public function offset(){

            return ($this->current_page -1)*$this->items_per_page;
        }
        public function total_pages(){
            return ceil(($this->total_items) / ($this->items_per_page));
        }


    }//end of Paginate class

?>