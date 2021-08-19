<?php

use Slim\Factory\AppFactory;
use DI\Container;
use Slim\Views\TwigMiddleware;

require __DIR__ . './../vendor/autoload.php';


/***********************************
 * Bootstrapping app in this file to make 
 * index.php less messy
 */

// Load .env file
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->load();



/**
 * Dependency Injection
 */
$container = new Container();

$container->set('config', function() {
    // Get config file
    return include 'config.php';
});

AppFactory::setContainer($container);
$app = AppFactory::create();

// Inject all dependencies into container
include('../src/container.php');

// Add Twig-View Middleware
$app->add(TwigMiddleware::createFromContainer($app));

/**
 * CORS
 * For reference, check https://www.slimframework.com/docs/v4/cookbook/enable-cors.html
 *  */ 

if ($container->get('config')['usingCors'] && $container->get('config')['domain'] != '<domain>'){
    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });
    $app->add(function ($request, $handler) {
        $response = $handler->handle($request);
        return $response
                ->withHeader('Access-Control-Allow-Origin', 'http://mysite')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });
}
