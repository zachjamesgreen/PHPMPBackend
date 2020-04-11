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

    public static function search($arg)
    {
        $i = Connection::getInstance();
        $db = $i->getConnection();

        $song = array();
        $songs = array();
        $result = $db->query("SELECT * FROM albums WHERE name Ilike '$arg%';")->fetchAll();
        if ($result == false) return [];
        return $result;
    }
}
