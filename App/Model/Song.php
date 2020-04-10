<?php
namespace App\Model;

use App\Model;
use App\Connection;

class Song extends Model
{

    public static function all()
    {
        $i = Connection::getInstance();
        $db = $i->getConnection();

        $song = array();
        $songs = array();
        $result = $db->query("select songs.id, artists.id as artist_id, artists.name as artist, albums.id as album_id, albums.name as album_title, songs.name
        from songs left outer join artists on artists.id = songs.artist_id left outer join albums on albums.id = songs.album_id;")->fetchAll();
        foreach ($result as $row) {
            $song['id'] = $row['id'];
            $song['artist_id'] = $row['artist_id'];
            $song['album_id'] = $row['album_id'];
            $song['name'] = $row['name'];
            $song['artist'] = ['id' => $song['artist_id'], 'name' => $row['artist']];
            $song['album'] = ['id' => $song['album_id'], 'name' => $row['album_title']];
            array_push($songs, $song);
        }
        return $songs;
    }

    public static function where($field, $arg)
    {
        $i = Connection::getInstance();
        $db = $i->getConnection();

        $song = array();
        $songs = array();
        $result = $db->query("
            select songs.id, artists.id as artist_id, artists.name as artist, albums.id as album_id, albums.name as album_title, songs.name
            from songs
            left outer join artists on artists.id = songs.artist_id
            left outer join albums on albums.id = songs.album_id
            where songs.$field = $arg;")->fetchAll();
        foreach ($result as $row) {
            $song['id'] = $row['id'];
            $song['artist_id'] = $row['artist_id'];
            $song['album_id'] = $row['album_id'];
            $song['name'] = $row['name'];
            $song['artist'] = ['id' => $song['artist_id'], 'name' => $row['artist']];
            $song['album'] = ['id' => $song['album_id'], 'name' => $row['album_title']];
            array_push($songs, $song);
        }
        return $songs;
    }

    public static function search($arg)
    {
        $i = Connection::getInstance();
        $db = $i->getConnection();

        $song = array();
        $songs = array();
        $result = $db->query("
            select songs.id, artists.id as artist_id, artists.name as artist, albums.id as album_id, albums.name as album_title, songs.name
            from songs
            left outer join artists on artists.id = songs.artist_id
            left outer join albums on albums.id = songs.album_id
            where songs.name Ilike '$arg%';");
        if ($result == false) return [];
        foreach ($result->fetchAll() as $row) {
            $song['id'] = $row['id'];
            $song['artist_id'] = $row['artist_id'];
            $song['album_id'] = $row['album_id'];
            $song['name'] = $row['name'];
            $song['artist'] = ['id' => $song['artist_id'], 'name' => $row['artist']];
            $song['album'] = ['id' => $song['album_id'], 'name' => $row['album_title']];
            array_push($songs, $song);
        }
        return $songs;
    }
}
