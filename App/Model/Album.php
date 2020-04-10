<?php
namespace App\Model;

use App\Model;
use App\Connection;

class Album extends Model
{

    public static function all()
    {
        $i = Connection::getInstance();
        $db = $i->getConnection();

        return $db->query("SELECT * from albums;")->fetchAll();

    }

    public static function where($field, $arg)
    {
        $i = Connection::getInstance();
        $db = $i->getConnection();
        return $db->query("SELECT * from albums where $field = $arg;");
    }
}
