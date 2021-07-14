<?php


namespace Test\Framework;

use Framework\ManagerRouter;
use GuzzleHttp\Psr7\ServerRequest;

class RouterTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ManagerRouter
     */
    private $routerManager;

    /**
     * Function to setUp the tests
     */
    public function setUp(): void
    {
        $this->routerManager = new ManagerRouter();
    }

    /**
     * Method to test the method when a request is on
     */
    public function testGetMethod()
    {
        $request = new ServerRequest('GET','/blog');
        $this->routerManager->get('/blog',function(){
            return 'hello';
        },'blog');
        $result = $this->routerManager->match($request);

        $this->assertEquals('blog',$result->getName());

        $this->assertEquals('hello',call_user_func_array($result->getCallback(),[$request]));


    }

    public function testGetMethodUrlNotExists()
    {
        $request = new ServerRequest('GET','/blog');
        $this->routerManager->get('/blogaza',function(){
            return 'hello';
        },'blog');
        $result = $this->routerManager->match($request);
        $this->assertEquals(null,$result);

    }

    public function testGetMethodWithParams()
    {
        $request = new ServerRequest('GET','/blog/mon-slug-8');
        $this->routerManager->get('/blog',function(){
            return 'test';
        },'posts');
        $this->routerManager->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}',function(){
            return 'hello';
        },'post.show');
        $result = $this->routerManager->match($request);
        $this->assertEquals('post.show',$result->getName());
        $this->assertEquals('hello',call_user_func_array($result->getCallback(),[$request]));
        $this->assertEquals(['slug' => 'mon-slug','id'=>'8'],$result->getParams());

        /* Test invalid URL*/
        $result = $this->routerManager
            ->match(new ServerRequest('GET','/blog/mon_slug-8s'));

        $this->assertEquals(NULL,$result);
    }

    public function testGenerateUri()
    {

        $this->routerManager->get('/blog',function(){
            return 'test';
        },'posts');
        $this->routerManager->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}',function(){
            return 'hello';
        },'post.show');

        $uri = $this->routerManager->getGeneratedUri('post.show',['slug'=>'mon-article','id' => 18]);
        $this->assertEquals('/blog/mon-article-18',$uri);

    }
}