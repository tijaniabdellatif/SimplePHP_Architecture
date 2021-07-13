<?php


namespace App\Blog\Actions;

use App\Blog\Table\PostTable;
use Framework\Actions\RouterAction;
use Framework\ManagerRouter;
use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdminBlogAction
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
    private $router;
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
    public function __construct(RendererInterface $renderer, PostTable $postTable, ManagerRouter  $router)
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
        if ($request->getMethod()==='DELETE') {
            return $this->delete($request);
        }
        if (substr((string) $request->getUri(), - 3) ==='new') {
            return $this->create($request);
        }

        $slug = $request->getAttribute('id');
        if ($slug) {
            return $this->edit($request);
        } else {
            return $this->index($request);
        }
    }


    public function index(ServerRequestInterface  $request): string
    {
        $params = $request->getQueryParams();
        $items = $this->postTable->findPaginated(9, $params['p'] ?? 1);
        return $this->renderer->render('@blog/admin/index', compact('items'));
    }

    /**
     * @param ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface|string
     */
    public function edit(ServerRequestInterface $request)
    {
        $item = $this->postTable->find($request->getAttribute('id'));

        if ($request->getMethod() === 'POST') {
            $params = $this->getDBParams($request);
            $params = array_merge($params, [

                'updated_at' => date('Y-m-d H:i:s')

            ]);
            $this->postTable->update($item->id, $params);
            return $this->redirect('blog.admin.index');
        }
        return $this->renderer->render('@blog/admin/edit', compact('item'));
    }

    /**
     * @param ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface|string
     */
    public function create(ServerRequestInterface $request)
    {

        if ($request->getMethod() === 'POST') {
            $params = $this->getDBParams($request);
            $params = array_merge($params, [

                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $this->postTable->insert($params);
            return $this->redirect('blog.admin.index');
        }
        return $this->renderer->render('@blog/admin/create');
    }

    /**
     * @param ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete(ServerRequestInterface $request)
    {

            $this->postTable->delete($request->getAttribute('id'));
            return $this->redirect('blog.admin.index');
    }

    private function getDBParams(ServerRequestInterface $request)
    {

        return array_filter($request->getParsedBody(), function ($key) {

            return in_array($key, ['name','content','slug']);
        }, ARRAY_FILTER_USE_KEY);
    }
}
