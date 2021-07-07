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
     * It takes generally a list of modules to load
     * @var array $modules
     */
    private array $modules = [];
    /**
     * @var ManagerRouter
     */
    private $routemanager;
    /**
     * App constructor
     * List of modules to load in the application.
     * exemple : BlogModule in order to render a page of the Blog
     * @param array $modules
     */
     public function __construct(array $modules = []){

         $this->routemanager = new ManagerRouter();
         foreach ($modules as $module){
          $this->modules[] = new $module($this->routemanager);
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
        if (!empty($url) && $url[-1] === "/") {
            return (new Response())
                ->withStatus(301)
                ->withHeader('Location', substr($url, 0, -1));
        }

       $result = $this->routemanager->match($request);
        if(is_null($result)) {
            return new Response(
                404
                , [],
                '<h1>Error 404</h1>');
        }

            $params = $result->getParams();
            $request = array_reduce(array_keys($params),
                function ($request,$key) use ($params)
                {

                return $request->withAttribute($key,$params[$key]);

               },$request);

            $response = call_user_func_array(
                $result->getCallback(),
                [$request]);

            if(is_string($response))
            {
                return new Response(200,[],$response);
            }
            else if($response instanceof ResponseInterface)
            {
                return $response;
            }
            else
            {
                Throw new \Exception('the response is not a string or a responseinterface');
            }

        }

}
