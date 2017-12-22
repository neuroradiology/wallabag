<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Added indexes on wallabag_entry.url and wallabag_entry.given_url and wallabag_entry.user_id.
 */
class Version20171218135243 extends AbstractMigration implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    private $indexGivenUrl = 'IDX_entry_given_url';

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $entryTable = $schema->getTable($this->getTable('entry'));
        $this->skipIf($entryTable->hasIndex($this->indexGivenUrl), 'It seems that you already played this migration.');

        switch ($this->connection->getDatabasePlatform()->getName()) {
            case 'mysql':
                $sql = 'CREATE INDEX ' . $this->indexGivenUrl . ' ON ' . $this->getTable('entry') . ' (url (255), given_url (255), user_id);';
                break;
            case 'postgresql':
                $sql = 'CREATE INDEX ' . $this->indexGivenUrl . ' ON ' . $this->getTable('entry') . ' (url, given_url, user_id);';
                break;
        }

        $this->addSql($sql);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $entryTable = $schema->getTable($this->getTable('entry'));
        $this->skipIf(false === $entryTable->hasIndex($this->indexGivenUrl), 'It seems that you already played this migration.');

        $entryTable->dropIndex($this->indexGivenUrl);
    }

    private function getTable($tableName)
    {
        return $this->container->getParameter('database_table_prefix') . $tableName;
    }
}
