<?php

declare(strict_types=1);

namespace App;
use Psr\Http\Message\{ResponseInterface as Response, ServerRequestInterface as Request};

class Handler
{
    public function handle(Request $request, Response $response): Response
    {
        $response->getBody()->write('Hello OpenFaaS!');
        return $response->withStatus(200);
    }
}