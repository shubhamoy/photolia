<?php
    require_once('helpers.php');
    require_once(__DIR__.'/../loader.php');

    class Session implements SessionHandlerInterface
    {
        private $savePath;
        private static $timeout = 1800;
        public function __construct()
        {
            ini_set("session.name", "photolia");
            ini_set("session.cookie_httponly", true);
            ini_set("session.use_strict_mode", true);
        }

        public function open($savePath, $sessionName)
        {
            $this->savePath = $savePath;
            if (!is_dir($this->savePath)) {
                mkdir($this->savePath, 0777);
            }

            return true;
        }

        public function close()
        {
            return true;
        }

        public function read($id)
        {
            return (string)@file_get_contents("$this->savePath/sess_$id");
        }

        public function write($id, $data)
        {
            return file_put_contents("$this->savePath/sess_$id", $data) === false ? false : true;
        }

        public function destroy($id)
        {
            $file = "$this->savePath/sess_$id";
            if (file_exists($file)) {
                unlink($file);
            }

            return true;
        }

        public function gc($maxlifetime)
        {
            foreach (glob("$this->savePath/sess_*") as $file) {
                if (filemtime($file) + $maxlifetime < time() && file_exists($file)) {
                    unlink($file);
                }
            }

            return true;
        }
        
        public static function checkSession()
        {
            if (isset($_SESSION['ACTIVITY'])) {
                $r = time() - $_SESSION['ACTIVITY'];
                if ($r > self::$timeout) {
                    unset($_SESSION['uid']);
                    //redirect_to('login.php');
                } else {
                    $_SESSION['ACTIVITY'] = time();
                    return true;
                }
            }
        }
    }

    $session = new Session();
    session_set_save_handler($session, true);
    session_start();
