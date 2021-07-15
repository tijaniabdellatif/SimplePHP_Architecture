<?php


namespace Framework;

use App\Blog\Actions\AdminBlogAction;
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
    private FastRouteRouter $managerrouter;

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
     * @param string $path
     * @param $callable
     * @param string|null $name
     */
    public function post(string $path, $callable, ?string $name = null)
    {

        $this->managerrouter
            ->addRoute(new ZendRoute($path, $callable, ['POST'], $name));
    }

    /**
     * @param string $path
     * @param $callable
     * @param string|null $name
     */
    public function delete(string $path, $callable, ?string $name = null)
    {

        $this->managerrouter
            ->addRoute(new ZendRoute($path, $callable, ['DELETE'], $name));
    }

    /**
     * Generate Crud system
     * @param string $prefixPath
     * @param $callable
     * @param string $prefixName
     * @return string
     */
    public function crud(string $prefixPath, $callable, string $prefixName)
    {
        $this->get($prefixPath, $callable, $prefixName.'.index');
        $this->get($prefixPath."/new", $callable, $prefixName.'.create');
        $this->post($prefixPath."/new", $callable);
        $this->get($prefixPath."/{id:\d+}", $callable, $prefixName.'.edit');
        $this->post($prefixPath."/{id:\d+}", $callable);
        $this->delete($prefixPath."/{id:\d+}", $callable, $prefixName.'.delete');
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
     * @param string $name
     * @param array $params
     * @param array $queryParams
     * @return string|null
     */
    public function getGeneratedUri(string $name, array $params = [], array $queryParams = []): ?string
    {
        $uri =  $this->managerrouter
            ->generateUri($name, $params);

        if (!empty($queryParams)) {
            return $uri . '?' .http_build_query($queryParams);
        }

        return $uri;
    }
}
