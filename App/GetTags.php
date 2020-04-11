<?php
namespace App;

require_once('vendor/james-heinrich/getid3/getid3/getid3.php'); // /var/www/phpplayer

class GetTags
{

    /**
     * @var string
     */
    public $format;

    /**
     * @var string
     */
    public $artist;

    /**
     * @var string
     */
    public $albumTitle;

    /**
     * @var string
     */
    public $songTitle;

    /**
     * @var int
     */
    public $trackNumber;

    /**
    * @var integer
    */
    public $year;

    /**
    * @var string
    */
    public $bpm;

    /**
    * @var string
    */
    public $genre;

    public $s;


    // array to return info in one fell swoop
    // $info = [];

    // img
    // public $img;

    // Id3 instance
    // $i = new GetId3();

    public function __construct($file){
        $i = new \getID3();
        $this->s = $i->analyze($file);
        // echo '<pre>';
        // print_r($this->s);
        $this->format = $this->s['audio']['dataformat'];
        if($this->artist = $this->s['tags']['id3v2']['band'][0]){
        }else{
            $this->artist = $this->s['tags']['id3v2']['artist'][0];
        }
        $this->albumTitle = $this->s['tags']['id3v2']['album'][0];
        $this->songTitle  = $this->s['tags']['id3v2']['title'][0];
        $this->trackNumber = $this->setTrackNumber($this->s['tags']['id3v2']['track_number'][0]);
        $this->year = isset($this->s['tags']['id3v2']['year']) ? $this->s['tags']['id3v2']['year'][0] : null;
        $this->bpm = isset($this->s['tags']['id3v2']['bpm']) ? $this->s['tags']['id3v2']['bpm'][0] : null;
        $this->genre = isset($this->s['tags_html']['id3v2']['genre']) ? $this->extractGenre($this->s['tags_html']['id3v2']['genre']) : null; // if more than one combne
        // $img = $s['comments']['picture'][0]['data'];

    }
    // return track number
    private function setTrackNumber($num){
        $n = explode('/', $num);
        return $n[0];
    }
    // if genre array has more than on item make a comma sep string
    public function extractGenre($a){
        if (count($a) > 1) {
            $string= implode(', ', $a);
        } else {
            $this->genre = $this->s['tags_html']['id3v2']['genre'][0];
        }
        $this->genre = $string;
        return $this->genre;
    }

    public function getFormat(){
        return $this->format;
    }
    public function getArtist(){
        return $this->artist;
    }
    public function getAlbumTitle(){
        return $this->albumTitle;
    }
    public function getSongTitle(){
        return $this->songTitle;
    }
    public function getTrackNumber(){
        return $this->trackNumber;
    }
    public function getBpm(){
        return $this->bpm;
    }
    public function getYear(){
        return $this->year;
    }

    public function getGenre(){
        return $this->genre;
    }

    public function getAnalyze(){
        return $this->s;
    }


    public function getInfo(){
        return $this->info = [
            'songTitle' => $this->getSongTitle(),
            'artist' => $this->getArtist(),
            'albumTitle' => $this->getAlbumTitle(),
            'trackNumber' => $this->getTrackNumber(),
            'year' => $this->getYear(),
            'bpm' => $this->getBpm(),
            'genre' => $this->getGenre()
        ];
    }
}
