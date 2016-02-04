<?php
require_once('helpers.php');
require_once(__DIR__.'/../loader.php');

class Comment
{
    private $table;
    public $id;
    public $pid;
    public $author;
    public $body;
    public $allowed;
    public $created_at;
    public $updated_at;
            
    public function __construct()
    {
        $this->table = "comments";
    }
    
    /**
    * Factory Pattern
    */
    public static function make($pid, $author, $body)
    {
        $c = new Comment;
        $c->pid = (int)$pid;
        $c->author = $author;
        $c->body = $body;
        return $c;
    }
    
    public static function findComments($pid)
    {
        $db = new Model;
        $comments = $db->findByField(['pid'=>$pid], "comments");
        $obj = array();
        foreach ($comments as $c) {
            if ($c->allowed == 1) {
                $obj[] = self::instantiate($c);
            }
        }
        return $obj;
    }

    public static function findAllComments()
    {
        $db = new Model;
        $comments = $db->findAll("comments");
        $obj = array();
        foreach ($comments as $c) {
            $obj[] = self::instantiate($c);
        }
        return $obj;
    }

    
    private static function instantiate($record)
    {
        $c = new self;
        foreach ($record as $attr=>$val) {
            if ($c->has_attribute($attr)) {
                $c->$attr = $val;
            }
        }
        return $c;
    }
    
    private function has_attribute($attr)
    {
        $object_vars = getPublicVars($this);
        return array_key_exists($attr, $object_vars);
    }
    

    public function create()
    {
        $db = new Model;
        $data = array(
            "pid" => $this->pid,
            "author" => $this->author,
            "body" => $this->body,
            "allowed" => 0
            );
        $c = $db->insert($data, $this->table);
        if ($c) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function delete($id)
    {
        $db = new Model;
        $c = $db->softDelete($id, 'comments');
        if ($c) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function update($id, $data)
    {
        $db = new Model;
        $c = $db->update($id, $data, 'comments');
        if ($c) {
            return true;
        } else {
            return false;
        }
    }
    
    public function save($data)
    {
        return isset($this->id) ? $this->update($data) : $this->create($data);
    }
}
