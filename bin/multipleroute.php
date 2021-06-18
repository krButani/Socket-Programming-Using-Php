<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Psr\Http\Message\RequestInterface;
use Ratchet\Http\Router;
use Ratchet\Http\HttpServerInterface;
use Ratchet\ConnectionInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpFoundation\Request;
use MyApp\HomePage;
use MyApp\RealTimeData;

    require dirname(__DIR__) . '/vendor/autoload.php';

   

	class RealTimeServer extends WsServer {
	    public function __construct() {
	        parent::__construct(new RealTimeData());
	    }
	}

    $collection = new RouteCollection();
	$collection->add('home', new Route('/home', [
	    '_controller' => new WsServer(new HomePage()),
	]));

	$collection->add('realtime', new Route('/realtime', [
	    '_controller' => RealTimeServer::class,
	]));

	$urlMatcher = new UrlMatcher($collection, new RequestContext());
	$router = new Router($urlMatcher);

	$server = IoServer::factory(
	    new HttpServer($router),
	    8080
	);
	$server->run();