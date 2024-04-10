<?php
class Database
{
  public function __construct()
  {
    die('Init function error');
  }

  public static function dbConnect()
  {
    $mysqli = null;
    
    //try connecting to your database
    require_once ("/home/dfroger1/DBrogers.php");
    try {
      $mysqli = new PDO('mysql:host=' . DBHOST . ';dbname=' . DBNAME, USERNAME, PASSWORD);

    } catch (PDOException $e) {
      //catch a potential error, if unable to connect
      echo "Error!: " . $e->getMessage() . "<br />";
      die("Could not connect to server " . DBNAME . "<br />");
    }

    return $mysqli;
  }

  public static function dbDisconnect()
  {
    $mysqli = null;
  }
}
?>