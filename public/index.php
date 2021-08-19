<?php
session_start();

/**
 * Initialize app, DI, config and another dependencies
 */
require '../src/bootstrap.php';

/**
 * Routes
 */
require '../src/Routes/api.php';
require '../src/Routes/web.php';
require '../src/Routes/core.php';



$app->run();