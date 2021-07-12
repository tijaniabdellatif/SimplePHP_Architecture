<?php


namespace App\Framework\Database;

use Pagerfanta\Adapter\AdapterInterface;

class PaginatedQuery implements AdapterInterface
{
    /**
     * @var \PDO
     */
    private $pdo;
    /**
     * @var string
     */
    private $query;
    /**
     * @var string
     */
    private $countQuery;

    /**
     * @var $entity
     */
    private $entity;

    /**
     * PaginatedQuery constructor.
     * @param \PDO $pdo
     * @param string $query
     * @param string $countQuery
     */
    public function __construct(\PDO $pdo, string $query, string $countQuery, string $entity)
    {

        $this->pdo = $pdo;
        $this->query = $query;
        $this->countQuery = $countQuery;
        $this->entity = $entity;
    }
     
    public function getNbResults():int
    {
        return $this->pdo->query($this->countQuery)->fetchColumn();
    }

    /**
     * @param int $offset
     * @param int $length
     * @return array
     */
    public function getSlice($offset, $length):array
    {

        $statement = $this->pdo->prepare(
            $this->query.' LIMIT :offset,:length'
        );
        $statement->bindParam('offset', $offset, \PDO::PARAM_INT);
        $statement->bindParam('length', $length, \PDO::PARAM_INT);
        $statement->setFetchMode(\PDO::FETCH_CLASS, $this->entity);
        $statement->execute();
        return $statement->fetchAll();
    }
}
