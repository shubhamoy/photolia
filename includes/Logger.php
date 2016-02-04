<?php
    require_once('helpers.php');
    require_once(__DIR__.'/../loader.php');
    require_once('Session.php');

    class Logger
    {
        public $log_dir;
        public $log_file;
        private static $instance;
        
        public function __construct()
        {
            $this->log_dir = __DIR__.'/../logs';
            $this->log_file = __DIR__.'/../logs/photolia.log';
            $this->instantiate();
        }
        
        public static function start()
        {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }
            return self::$instance;
        }
        
        public function instantiate()
        {
            if (!is_dir($this->log_dir)) {
                mkdir($this->log_dir);
                touch($this->log_file);
            }
            
            if (!is_file($this->log_file)) {
                touch($this->log_file);
            }
        }
        
        public function add($user, $file, $action=null)
        {
            $entry = get_timestamp()." | ".basename($file)." | ".$user." | ".$action."\n";
            $f = fopen($this->log_file, 'a');
            fwrite($f, $entry);
            fclose($f);
        }
        
        public function get()
        {
            $data=[];
            $f = file($this->log_file, FILE_SKIP_EMPTY_LINES);
            foreach ($f as $line) {
                $bline = explode('|', $line);
                $data[] = $bline;
            }
            return $data;
        }
        
        public function reset()
        {
            unlink($this->log_file);
            $this->instantiate();
            $u = User::getUser($_SESSION['uid'])->username;
            $this->add($u, basename(__FILE__), 'Logs Cleared');
        }
    }
