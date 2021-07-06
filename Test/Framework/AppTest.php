<?php

namespace Test\Framework;

use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class AppTest : Unit testing initialization of application
 * @package Test\Framework
 */
class AppTest extends TestCase
{
    /**
     *
     * Function to test trailing slashes
     */
    public function testRedirectTrailingSlash()
    {

        $app = new App();
        $request = new ServerRequest('GET', '/demolish/');
        $response = $app->run($request);
        $this->assertContains('/demolish', $response->getHeader('Location'));
        $this->assertEquals(301, $response->getStatusCode());

    }

    /**
     * Function to test running blog with url
     */
    public function testBlog()
    {

        $app = new App();
        $request = new ServerRequest('GET', '/blog');
        $response = $app->run($request);
        $this->assertStringContainsString('<h1>Welcome to my Blog</h1>', (string)$response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
    }


    /**
     * Function to test 404 errors
     */
    public function testError404()
    {

        $app = new App();
        $request = new ServerRequest('GET', '/badly');
        $response = $app->run($request);
        $this->assertStringContainsString('<h1>Error 404</h1>', (string)$response->getBody());
        $this->assertEquals(404, $response->getStatusCode());

    }
}