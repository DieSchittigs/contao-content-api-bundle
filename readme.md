## Installation

    composer require dieschittigs/contao-content-api

Put a file called "api.php" into your /web folder.
Paste the following contents into it:

    <?php

    use DieSchittigs\ContaoContentApi\FrontendApi;
    use Symfony\Component\HttpFoundation\Request;

    $loader = require __DIR__.'/../vendor/autoload.php';

    $api = new FrontendApi($loader);

    $request = Request::createFromGlobals();
    $response = $api->handle($request);
    $response->send();


## Usage

TODO
