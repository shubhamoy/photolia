<?php
require_once('helpers.php');
require_once(__DIR__.'/../loader.php');

class Pagination
{
    public $current_page;
    public $per_page;
    public $total;
    
    public function __construct($page=1, $per_page=20, $total=0)
    {
        $this->current_page    = (int)$page;
        $this->per_page    = (int)$per_page;
        $this->total    = (int)$total;
    }
    
    public function offset()
    {
        return ($this->current_page - 1) * $this->per_page;
    }
    public function total_pages()
    {
        return ceil($this->total / $this->per_page);
    }
    
    public function prev_page()
    {
        return $this->current_page - 1;
    }
    
    public function next_page()
    {
        return $this->current_page + 1;
    }
    
    public function has_prev_page()
    {
        return $this->prev_page() >= 1 ? true : false;
    }
    
    public function has_next_page()
    {
        return $this->next_page() <= $this->total_pages() ? true : false;
    }
}
