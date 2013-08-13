<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130812150304 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE request CHANGE vacation_request_id user_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE request ADD CONSTRAINT FK_3B978F9FA76ED395 FOREIGN KEY (user_id) REFERENCES employee (id)");
        $this->addSql("CREATE INDEX IDX_3B978F9FA76ED395 ON request (user_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE request DROP FOREIGN KEY FK_3B978F9FA76ED395");
        $this->addSql("DROP INDEX IDX_3B978F9FA76ED395 ON request");
        $this->addSql("ALTER TABLE request CHANGE user_id vacation_request_id INT DEFAULT NULL");
    }
}
