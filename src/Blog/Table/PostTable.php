<?php


namespace App\Blog\Table;

use App\Blog\Entities\Post;
use App\Framework\Database\PaginatedQuery;
use Laminas\Paginator\Paginator;
use Pagerfanta\Pagerfanta;

class PostTable
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * PostTable constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo=$pdo;
    }

    /**
     * @param int $perpage
     * @param int $currentPage
     * @return Pagerfanta
     */
    public function findPaginated(int $perpage, int $currentPage):Pagerfanta
    {

        $query =  new PaginatedQuery(
            $this->pdo,
            'SELECT * from posts ORDER BY created_at DESC',
            'SELECT COUNT(id) from posts',
            Post::class
        );

        return (new Pagerfanta($query))->setMaxPerPage($perpage)
            ->setCurrentPage($currentPage);

        /**return $this->pdo->query('
             SELECT * FROM posts ORDER BY created_at DESC LIMIT 10
        ')->fetchAll();**/
    }
    /**
     * get an article based on id
     * @param int $id
     * @return Post
     */
    public function find(int $id): Post
    {

        $query = $this->pdo->prepare('SELECT * FROM posts WHERE id=?');
        $query->execute([$id]);
        $query->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        return  $query->fetch();
    }
}
