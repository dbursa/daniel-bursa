<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Register routes here
 *
 * In inline routes, access container like $this->get()
 * In controller routes, access container like $this->container->get()
 */

/**
 * Basic simple route
 */
$app->get('/phi-slim-starter/', function (Request $request, Response $response) {
    return $this->get('view')->render($response, 'index.twig');
});

