<?php
	require_once('helpers.php');
    require_once(__DIR__.'/../loader.php');
    require_once('Session.php');

    class Install
    {
    	public static $db;
    	private static $instance;

    	public function __construct($dsn)
    	{
			$this->checkDB($dsn);
    	}

    	public static function start($dsn)
        {
            if (is_null(self::$instance)) {
                self::$instance = new self($dsn);
            }
            return self::$instance;
        }

        public function checkDB($dsn)
        {
			try {
			 	$conn = @new mysqli($dsn['host'], 
			 						$dsn['username'], 
			 						$dsn['password'], 
			 						$dsn['dbname']);
    		} catch (Exception $e) {
    			var_dump($e);
    		}

    		$cnt = mysqli_num_rows(mysqli_query($conn, "SHOW TABLES"));

    		if($cnt === 0) {
    			self::$db = $conn;
    			return true;
    		} else {
    			return false;
    		}
        }

        public static function installConfig($data)
        {
        	$config = file_get_contents(__DIR__.'/config.php');
        	
   			$search = ["/HOST', '\w*'/", 
   					   "/USER', '\w*'/",
   					   "/PWD', '\w*'/", 
   					   "/DBNAME', '\w*'/"];

   			$replace = ["HOST', '".$data['HOST']."'", 
   						"USER', '".$data['USER']."'",
   						"PWD', '".$data['PWD']."'", 
   						"DBNAME', '".$data['DBNAME']."'"];

   			
   			file_put_contents(__DIR__.'/config.php', preg_replace($search, $replace, $config));

   			return true;
        }

        public static function installTables($sql)
        {
			foreach($sql as $q) {
				mysqli_query(self::$db, $q) or die(mysqli_error(self::$db));
			}
        	
        	return true;
        }

        public static function createUser($data)
        {
        	$query = "INSERT INTO `users` VALUES(1, '".$data['user']."', '".$data['pwd']."', '".$data['fname']."', '".$data['lname']."', '".get_timestamp()."', '".get_timestamp()."', NULL);";

        	mysqli_query(self::$db, $query) or die(mysqli_error(self::$db));
        	return true;
        }

    }