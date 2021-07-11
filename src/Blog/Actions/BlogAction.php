<?php


namespace  App\Blog\Actions;

use App\Blog\Table\PostTable;
use Framework\Actions\RouterAction;
use Framework\ManagerRouter;
use Framework\Renderer\RendererInterface;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

class BlogAction
{
    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var PostTable
     */
    private $postTable;
    /**
     * @var ManagerRouter
     */
    private  $router;
    /**
     * Trait RouterAction
     */
    use RouterAction;

    /**
     * BlogAction constructor.
     * @param RendererInterface $renderer
     * @param \PDO $pdo
     * @param ManagerRouter $router
     */
    public function __construct(RendererInterface $renderer, PostTable $postTable,ManagerRouter  $router)
    {
        $this->renderer=$renderer;
        $this->postTable = $postTable;
        $this->router = $router;
    }

    /**
     * @param ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface|string
     */
    public function __invoke(ServerRequestInterface  $request)
    {

        $slug = $request->getAttribute('id');
        if ($slug) {
            return $this->show($request);
        } else {
            return $this->index();
        }
    }

    /**
     * @return string
     */
    public function index(): string
    {
        $posts = $this->postTable->findPaginated();

        return $this->renderer->render('@blog/index',compact('posts'));
    }


    /**
     * @param ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface|string
     */
    public function show(ServerRequestInterface $request):string
    {
        $slug = $request->getAttribute('slug');
        $data = $this->postTable->find($request->getAttribute('id'));


         if($data->slug !== $slug)
         {
            return $this->redirect('blog.show',[

                 'slug'=>$data->slug,
                 'id' => $data->id

             ]);
         }


        return $this->renderer->render(
            '@blog/show',
            ['post' => $data]
        );
    }
}
