<?php


namespace Framework\Router;

/**
 * Class Route : Representation of a single route
 * @namespace  Framework\Router
 * @see Class Route
 */
class Route
{
    /**
     * @var string
     */
    private  $name;
    /**
     * @var callable
     */
    private $callback;
    /**
     * @var array;
     */
    private $params;

    /**
     * Route constructor.
     * @param string $name
     * @param callable $callback
     * @param array $params
     */
    public function __construct(string $name,callable $callback,array $params)
    {
         $this->name=$name;
         $this->callback=$callback;
         $this->params=$params;
    }
    /**
     *  getName() function to get the route name
     * @return string
     */
    public function getName(): string{

        return $this->name;
    }

    /**
     * getCallback() function to get the callback function
     * of the route
     * @return callable
     */
    public function getCallback(): callable{

        return $this->callback;

    }

    /**
     * getParams() function to get the parameters of
     * an url
     * @return array of String
     */
    public function getParams(): array{

        return $this->params;

    }
}