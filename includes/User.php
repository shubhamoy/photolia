<?php
    require_once('helpers.php');
    require_once(__DIR__.'/../loader.php');
    
    class User
    {
        private $table;
        public $id;
        public $fname;
        public $lname;
        public $username;
        public $password;
                
        public function __construct()
        {
            $this->table = "users";
        }
        
        private static function instantiate($record)
        {
            $u = new self;
            foreach ($record as $attr=>$val) {
                if ($u->has_attribute($attr)) {
                    $u->$attr = $val;
                }
            }
            return $u;
        }
        
        public static function getAllUsers()
        {
            $db = new Model;
            $users = $db->findAll("users");
            $obj = array();
            foreach ($users as $u) {
                if ($u->id != $_SESSION['uid']) {
                    $obj[] = self::instantiate($u);
                }
            }
            return $obj;
        }
        
        public static function getUser($id=null)
        {
            $db = new Model;
            if ($id == null) {
                $id = $_SESSION['uid'];
            }
            $user = $db->findById($id, 'users');
            return self::instantiate($user);
        }
        
        public static function checkUsername($uname)
        {
            $db = new Model;
            $user = $db->findByField($uname, 'users');
            if ($user) {
                return self::instantiate($user);
            } else {
                return false;
            }
        }
        
        public function fullName()
        {
            return $this->fname." ".$this->lname;
        }
        
        private function has_attribute($attr)
        {
            $object_vars = getPublicVars($this);
            return array_key_exists($attr, $object_vars);
        }
        
        public static function auth($username, $password)
        {
            $db = new Model;
            $u = $db->findFewAnd(['username'=>$username], 'users');
            if ($u) {
                $v = password_verify($password, $u->password);
                return self::instantiate($u);
            }
        }
        
        public static function create($data)
        {
            $db = new Model;
            $u = $db->insert($data, 'users');
            if ($u) {
                return true;
            } else {
                return false;
            }
        }
        
        public static function delete($id)
        {
            $db = new Model;
            $u = $db->softDelete($id, 'users');
            if ($u) {
                return true;
            } else {
                return false;
            }
        }
        
        public static function update($id, $data)
        {
            $db = new Model;
            $u = $db->update($id, $data, 'users');
            if ($u) {
                return true;
            } else {
                return false;
            }
        }
    }
