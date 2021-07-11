<?php


namespace Framework;

use Framework\Router\Route;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Router\FastRouteRouter;
use Zend\Expressive\Router\Route as ZendRoute;

/**
 * Class ManagerRouter : Register a matched route
 * @namespace  Framework
 */
class ManagerRouter
{
    /**
     * @var FastRouteRouter
     */
    private $managerrouter;

    /**
     * ManagerRouter constructor.
     */
    public function __construct()
    {
        $this->managerrouter = new FastRouteRouter();
    }

    /**
     *
     * @param string $path
     * @param callable|string $callable
     * @param string $name
     */
    public function get(string $path, $callable, string $name)
    {

           $this->managerrouter
               ->addRoute(new ZendRoute($path, $callable, ['GET'], $name));
    }

    /**
     *
     * @param ServerRequestInterface $request
     * @return Route|Null
     */
    public function match(ServerRequestInterface $request): ?Route
    {
        /**
         * Result of a route result Zend
         */
         $result = $this->managerrouter->match($request);
        if ($result->isSuccess()) {
            return new Route(
                $result->getMatchedRouteName(),
                $result->getMatchedMiddleware(),
                $result->getMatchedParams()
            );
        }

         return null;
    }

    /**
     * generate an uri based on a request/response
     * @param string $string
     * @param array $array
     */
    public function getGeneratedUri(string $name, array $params): ?string
    {
        return $this->managerrouter
            ->generateUri($name, $params);
    }
}
