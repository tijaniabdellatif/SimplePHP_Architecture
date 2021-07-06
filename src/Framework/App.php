<?php

namespace Framework;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class App : initialisation of the application
 *
 * @namespace Framework
 */
class App
{
    /**
     * Method with a runing behaviour, it takes a request
     * and return a response
     *
     * @see    run()
     * @param  ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function run(ServerRequestInterface $request):ResponseInterface
    {
        $url = $request->getUri()->getPath();
        if (!empty($url) && $url[-1] === "/") {
            return (new Response())
                ->withStatus(301)
                ->withHeader('Location', substr($url, 0, -1));
        }

        if ($url === '/blog') {
            return new Response(200, [], '<h1>Welcome to my Blog</h1>');
        }

         // return (new Response())
              //->getBody()->write('Bonjour');

        return new Response(404, [], '<h1>Error 404</h1>');
    }
}
