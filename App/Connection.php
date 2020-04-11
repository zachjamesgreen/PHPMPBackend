<?php
namespace App;
// Singleton to connect db.
class Connection {
  // Hold the class instance.
  private static $instance = null;
  private $conn;

  private $host;
  private $user;
  private $pass;
  private $name;

  // The db connection is established in the private constructor.
  private function __construct()
  {
      $this->host = $_ENV['DATABASE_HOST'];
      $this->user = $_ENV['DATABASE_USER'];
      $this->pass = $_ENV['DATABASE_PASS'];
      $this->conn = new \PDO("pgsql:host=$this->host;dbname=player_production", $this->user, $this->pass);
  }


    public function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new Connection();
        }
        return self::$instance;

    }

    public function getConnection()
    {
        return $this->conn;
    }
}
