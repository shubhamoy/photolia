<?php
  require_once('helpers.php');
  require_once(__DIR__.'/../loader.php');
  require_once('Session.php');

  class Install
  {
    public static $db;
    private static $instance;
    public static $check;

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
        $cnt = @mysqli_num_rows(@mysqli_query($conn, "SHOW TABLES"));
      } catch (Exception $e) {
        var_dump($e);
      }
      
      if($cnt === 0) {
        self::$db = $conn;
        self::$check = 1;
        return true;
      } else {
        self::$check = 0;
        return false;
      }
    }

    public static function installConfig($data)
    {
      $config = file_get_contents(__DIR__.$data['file'], true);
      $f = file_put_contents(__DIR__.$data['file'], preg_replace($data['search'], $data['replace'], $config), LOCK_EX);

      if($f) {
        return true;
      } else {
        return false;
      }
    }

    public static function installTables($sql)
    {
      foreach($sql as $q) {
        mysqli_query(self::$db, $q) or die(mysqli_error(self::$db));
      }

      return true;
    }

    public static function createUser($query)
    {
      mysqli_query(self::$db, $query) or die(mysqli_error(self::$db));
      return true;
    }
}