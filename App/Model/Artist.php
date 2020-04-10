<?php
namespace App\Model;

use App\Model;
use App\Connection;

class Artist extends Model
{

    public static function all()
    {
        $i = Connection::getInstance();
        $db = $i->getConnection();

        return $db->query("SELECT * from artists;");

    }

    public static function where($field, $arg)
    {
        $i = Connection::getInstance();
        $db = $i->getConnection();
        return $db->query("SELECT * from artists where $field = $arg;");
    }
}
