<?php
  class db {
    private static $instance = NULL;

    private function __construct() {}

    private function __clone() {}

    public static function getInstance() {
      if (!isset(self::$instance)) {
        $config = parse_ini_file('21guden21jk3ldbnsam.ini.php');
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        self::$instance = new PDO('mysql:host=localhost;dbname='.$config['dbname'].'', $config['username'], $config['password'] , $pdo_options);
      }
      return self::$instance;
    }
  }
?>