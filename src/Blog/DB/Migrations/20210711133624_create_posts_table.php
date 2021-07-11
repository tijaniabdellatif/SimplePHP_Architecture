<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePostsTable extends AbstractMigration
{


    public function change(): void
    {
          $this->table('posts')
              ->addColumn('name', 'string')
              ->addColumn('slug', 'string')
              ->addColumn('content', 'text', ['limit'=>\Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG])
              ->addColumn('created_at', 'datetime')
              ->addColumn('updated_at', 'datetime')
              ->create();
    }
}
