<?php

namespace Framework\Actions;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * Add methods for using router
 * Trait RouterAction
 * @package Framework\Actions
 */
trait RouterAction
{

    /**
     * Send a redirection Response 301
     * @param string $path
     * @param array $params
     * @return ResponseInterface
     *
     */
    public function redirect(string $path, array $params = []):ResponseInterface
    {
        $redirectUri = $this->router->getGeneratedUri($path, $params);
            return (new Response())
                ->withStatus(301)
                ->withHeader('location', $redirectUri);
    }
}
