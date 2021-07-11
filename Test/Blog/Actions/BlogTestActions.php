<?php


namespace Test\Blog\Actions;

use App\Blog\Actions\BlogAction;
use App\Blog\Table\PostTable;
use Framework\ManagerRouter;
use Framework\Renderer\RendererInterface;
use GuzzleHttp\Psr7\ServerRequest;
use Prophecy\Argument;


class BlogTestActions extends \PHPUnit\Framework\TestCase
{
    /**
     * @var BlogAction
     */
    private $action;
    private $renderer;
    private  $pdo;
    private $router;
    private $postTable;

   public function setUp(): void
   {
      $this->renderer =  $this->prophesize(RendererInterface::class);
      $this->postTable = $this->prophesize(PostTable::class);

      $this->router = $this->prophesize(ManagerRouter::class);
      $this->action = new BlogAction(
          $this->renderer->reveal(),
          $this->postTable->reveal(),
          $this->router->reveal()
      );
   }

   public function makePost(int $id,string $slug): \stdClass{

       $post = new \stdClass();
       $post->id=$id;
       $post->slug = $slug;

       return $post;
   }

    public function testShowRedirect()
   {
       $post = $this->makePost(9,'ahaha');
       $this->router->getGeneratedUri('blog.show',['id'=>$post->id,'slug'=>$post->slug])->willReturn('/demo2');
       $this->postTable->find($post->id)->willReturn($post);

       $request = (new ServerRequest('GET','/',[],''))
           ->withAttribute('id',$post->id)
           ->withAttribute('slug','demo');

       $response = call_user_func_array($this->action,[$request]) ;
       $this->assertEquals(301,$response->getStatusCode());
       $this->assertEquals(['/demo2'],$response->getHeader('location'));
   }
}