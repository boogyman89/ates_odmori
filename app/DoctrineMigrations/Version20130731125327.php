<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130731125327 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE request CHANGE id_admin id_admin INT DEFAULT NULL, CHANGE submitted submitted DATETIME NOT NULL, CHANGE pdf pdf VARCHAR(200) DEFAULT NULL");
        $this->addSql("ALTER TABLE employee DROP role, CHANGE first_name first_name VARCHAR(50) NOT NULL, CHANGE last_name last_name VARCHAR(50) NOT NULL, CHANGE ssn ssn VARCHAR(20) NOT NULL, CHANGE address address VARCHAR(50) NOT NULL, CHANGE phone phone VARCHAR(20) NOT NULL, CHANGE date_of_employment date_of_employment DATE NOT NULL, CHANGE no_days_off no_days_off INT NOT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE employee ADD role VARCHAR(10) DEFAULT NULL, CHANGE first_name first_name VARCHAR(50) DEFAULT NULL, CHANGE last_name last_name VARCHAR(50) DEFAULT NULL, CHANGE ssn ssn VARCHAR(20) DEFAULT NULL, CHANGE address address VARCHAR(50) DEFAULT NULL, CHANGE phone phone VARCHAR(20) DEFAULT NULL, CHANGE date_of_employment date_of_employment DATE DEFAULT NULL, CHANGE no_days_off no_days_off INT DEFAULT NULL");
        $this->addSql("ALTER TABLE request CHANGE id_admin id_admin INT NOT NULL, CHANGE submitted submitted DATE NOT NULL, CHANGE pdf pdf VARCHAR(200) NOT NULL");
    }
}
