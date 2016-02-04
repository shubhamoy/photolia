<?php
    require_once('helpers.php');
    require_once(__DIR__.'/../loader.php');
    require_once('Session.php');
    class Auth
    {
        public $uid;
        private $isLoggedIn = false;
        
        public function login($user)
        {
            if ($user) {
                $this->uid = $user->id;
                $_SESSION['uid'] = $this->uid;
                $this->isLoggedIn = true;
            }
        }
        
        public function logout()
        {
            unset($_SESSION['uid']);
            unset($this->uid);
            $this->isLoggedIn = false;
            redirect_to('login.php');
        }
        
        public static function isLoggedIn()
        {
            if (isset($_SESSION['uid'])) {
                return true;
            } else {
                return false;
            }
        }
        
        public function checkLogin()
        {
            if (isset($_SESSION['uid'])) {
                $this->uid = $_SESSION['uid'];
                $this->isLoggedIn = true;
            } else {
                unset($this->uid);
                $this->loggedIn = false;
            }
        }
    }
