<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * CORE FRAMEWORK ROUTES
 * Don't delete these routes unless you know what you are doing! :)
 */
$app->post('/locale', function ($request, $response, $args) {
    //$_SESSION['app_locale'] = $args['locale'];
    $parsedBody = $request->getParsedBody();
    $locale = $parsedBody['locale'];
    /**
     * Check if locale is available
     */
    $available_locales = $this->get('available_locales');
    if (in_array($locale, $available_locales)){
        $_SESSION['app_locale'] = $locale;
    }

    return $response->withHeader('Location', '/');
});

/**
 *
 *  _  _    ___  _  _
 * | || |  / _ \| || |
 * | || |_| | | | || |_
 * |__   _| | | |__   _|
 *    | | | |_| |  | |
 *    |_|  \___/   |_|
 *
 * Catch-all route to serve a 404 Not Found page if none of the routes match
 * NOTE: make sure this route is defined last
 */
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
    return $this->get('view')->render($response, "404.twig");
});
