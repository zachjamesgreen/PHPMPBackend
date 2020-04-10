<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Symfony\Component\Dotenv\Dotenv;
use App\Model\Song;
use App\Model\Album;
use App\Model\Artist;

require __DIR__ . '/vendor/autoload.php';
$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

$app = AppFactory::create();


$app->get('/api/songs', function (Request $request, Response $response, $args) {
    $songs = Song::all();
    $payload = json_encode($songs);

    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});
$app->get('/api/songs/artist/{artist_id}', function (Request $request, Response $response, $args) {
    $songs = Song::where(array_keys($args)[0], $args[array_keys($args)[0]]);
    $payload = json_encode($songs);

    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/api/songs/album/{album_id}', function(Request $request, Response $response, $args) {
    $songs = Song::where(array_keys($args)[0], $args[array_keys($args)[0]]);
    $payload = json_encode($songs);

    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/api/album/{id}', function (Request $request, Response $response, $args) {
    $album = Album::where(array_keys($args)[0], $args[array_keys($args)[0]])->fetch();
    $payload = json_encode($album);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});
$app->get('/api/albums', function (Request $request, Response $response, $args) {
    $albums = Album::all();
    $payload = json_encode($albums);

    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});
$app->get('/api/albums/{artist_id}', function (Request $request, Response $response, $args) {
    $albums = Album::where(array_keys($args)[0], $args[array_keys($args)[0]])->fetchAll();
    $payload = json_encode($albums);

    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});
$app->get('/api/artists', function (Request $request, Response $response, $args) {
    $myPDO = new PDO('pgsql:host=localhost;dbname=player_development', 'zach', 'QmDfZx5782');
    $artists = Artist::all()->fetchAll();
    $payload = json_encode($artists);

    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});
$app->get('/api/artist/{id}', function (Request $request, Response $response, $args) {
    $artist = Artist::where(array_keys($args)[0], $args[array_keys($args)[0]])->fetch();
    $payload = json_encode($artist);

    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});
$app->get('/api/search', function (Request $request, Response $response, $args) {
    $q = $request->getQueryParams()['q'];
    $myPDO = new PDO('pgsql:host=localhost;dbname=player_development', 'zach', 'QmDfZx5782');
    $artists = $myPDO->query("SELECT * from artists where name Ilike '$q%';")->fetchAll();
    $albums = $myPDO->query("SELECT * from albums where name Ilike '$q%';")->fetchAll();
    $songs = Song::search($q);
    $payload = json_encode(array('artists' => $artists, 'albums' => $albums, 'songs' => $songs));

    $response->getBody()->write($payload);
    return $response;
    return $response->withHeader('Content-Type', 'application/json');
});
// $app->get('/api/upload', function (Request $request, Response $response, $args) {
//     return $response;
// });


$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write('Home Slim');
    return $response;
});

$app->run();
