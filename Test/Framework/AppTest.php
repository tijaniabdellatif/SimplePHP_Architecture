<?php

namespace Test\Framework;

use App\Blog\BlogModule;
use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Test\Framework\TestModules\ErroredModule;
use Test\Framework\TestModules\StringModule;

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

        $app = new App([
            BlogModule::class
        ]);
        $request = new ServerRequest('GET', '/blog');
        $response = $app->run($request);
        $this->assertStringContainsString('<h1>Welcome to my blog</h1>', (string)$response->getBody());
        $this->assertEquals(200, $response->getStatusCode());


        $requestSingle = new ServerRequest('GET', '/blog/article-de-test');
        $responseSingle = $app->run($requestSingle);
        $this->assertStringContainsString('<h1>Welcome to the post article-de-test</h1>',
            (string)$responseSingle->getBody());
    }


    public function testExceptionIfNoResponse(){

        $app = new App([
                ErroredModule::class
        ]);

        $request = new ServerRequest('GET','/demo');
        $this->expectException(\Exception::class);
        $app->run($request);
    }

    public function testConvertStringToResponse(){

        $app = new App([
            StringModule::class
        ]);

        $request = new ServerRequest('GET','/demo');
        $response = $app->run($request);
        $this->assertInstanceOf(ResponseInterface::class,$response);
        $this->assertEquals('DEMO',(string) $response->getBody());

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