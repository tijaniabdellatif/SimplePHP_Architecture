<?php

namespace Framework;

use GuzzleHttp\Psr7\Response;
use Psr\Container\ContainerInterface;
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
     * It takes generally a list of modules to load
     * @var array $modules
     */
    private array $modules = [];
    /**
     * @var ManagerRouter
     */
    private $routemanager;


    /**
     * @var $container
     */
    private $container;
    /**
     * App constructor
     * List of modules to load in the application.
     * exemple : BlogModule in order to render a page of the Blog
     * @param array $modules
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container, array $modules = [])
    {


        $this->container = $container;
        foreach ($modules as $module) {
            $this->modules[] = $container->get($module);
        }
    }

    /**
     * Method with a running behaviour, it takes a request
     * and return a response
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Exception
     * @see    run()
     */
    public function run(ServerRequestInterface $request):ResponseInterface
    {
        $url = $request->getUri()->getPath();
        $parsedBody = $request->getParsedBody();
        if (array_key_exists('_method', $parsedBody) &&
            in_array($parsedBody['_method'], ['DELETE','PUT'])) {
            $request = $request->withMethod($parsedBody['_method']);
        }
        if (!empty($url) && $url[-1] === "/") {
            return (new Response())
                ->withStatus(301)
                ->withHeader('Location', substr($url, 0, -1));
        }

        $result = $this->container->get(ManagerRouter::class)->match($request);
        if (is_null($result)) {
            return new Response(
                404,
                [],
                '<h1>Error 404</h1>'
            );
        }

            $params = $result->getParams();
            $request = array_reduce(
                array_keys($params),
                function ($request, $key) use ($params) {

                    return $request->withAttribute($key, $params[$key]);
                },
                $request
            );

            $callback = $result->getCallback();
        if (is_string($callback)) {
            $callback = $this->container->get($callback);
        }
            $response = call_user_func_array($callback, [$request]);

        if (is_string($response)) {
            return new Response(200, [], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        } else {
            throw new \Exception('the response is not a string or a responseinterface');
        }
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer():ContainerInterface
    {

            return $this->container;
    }
}
