<?php
namespace App;
use App\Connection;

abstract class Model {
    public static $conn;

    function __construct()
    {
        // $this->conn = Connection::getConnection();
        echo "In Model=>";
    }
}
