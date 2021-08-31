<?php

declare(strict_types=1);

use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use Nyholm\Psr7Server\ServerRequestCreator;
use App\Handler;

require_once 'vendor/autoload.php';

if (file_exists('function/vendor/autoload.php')) {
    require_once 'function/vendor/autoload.php';
}

(function () {
    $psr17Factory = new Psr17Factory();

    $creator = new ServerRequestCreator(
        $psr17Factory, // ServerRequestFactory
        $psr17Factory, // UriFactory
        $psr17Factory, // UploadedFileFactory
        $psr17Factory  // StreamFactory
    );

    $serverRequest = $creator->fromGlobals();

    // Create a new emitter and emits the response returned by the handle function in the Handler class
    (new SapiEmitter())->emit(
        (new Handler())->handle($serverRequest, new Response())
    );
})();