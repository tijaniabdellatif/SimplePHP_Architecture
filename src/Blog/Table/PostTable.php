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

    /**
     * @param int $id
     * @param array $fields
     * @return bool
     */
    public function update(int $id, array $params):bool
    {
           $fieldQuery = $this->buildFieldsQuery($params);

           $params["id"] = $id;
           $statement = $this->pdo->prepare(
               "UPDATE posts SET $fieldQuery WHERE id = :id"
           );
          return  $statement->execute($params);
    }

    /**
     * @param array $params
     * @return bool
     */
    public function insert(array $params):bool
    {

        $fields= array_keys($params);
        $values = array_map(function ($field) {
            return ':'.$field;
        }, $fields);


        $statement = $this->pdo->prepare(
            "INSERT INTO posts (" . join(',', $fields)  . ") 
            VALUES (". join(',', $values) .")"
        );
        return $statement->execute($params);
    }

    /**
     * @param int $id
     * @return bool
     *
     */
    public function delete(int $id):bool
    {

        $statement = $this->pdo->prepare("
          DELETE FROM posts WHERE id = ?
        ");

        return $statement->execute([$id]);
    }

    private function buildFieldsQuery(array $params)
    {
        return join(', ', array_map(function ($field) {
            return "$field = :$field";
        }, array_keys($params)));
    }
}
