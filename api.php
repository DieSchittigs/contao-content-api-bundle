<?php

/*
Put this into your /web folder
*/

use DieSchittigs\ContaoContentApi\FrontendApi;
use Symfony\Component\HttpFoundation\Request;

$loader = require __DIR__.'/../vendor/autoload.php';

$api = new FrontendApi($loader);

$request = Request::createFromGlobals();
$response = $api->handle($request);
$response->send();
