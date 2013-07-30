<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130729123206 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE ates_user CHANGE first_name first_name VARCHAR(50) DEFAULT NULL, CHANGE last_name last_name VARCHAR(50) DEFAULT NULL, CHANGE ssn ssn VARCHAR(20) DEFAULT NULL, CHANGE address address VARCHAR(50) DEFAULT NULL, CHANGE phone phone VARCHAR(20) DEFAULT NULL, CHANGE date_of_employment date_of_employment DATE DEFAULT NULL, CHANGE no_days_off no_days_off INT DEFAULT NULL, CHANGE role role VARCHAR(10) DEFAULT NULL, CHANGE is_approved is_approved TINYINT(1) DEFAULT NULL, CHANGE is_validated is_validated TINYINT(1) DEFAULT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE ates_user CHANGE first_name first_name VARCHAR(50) NOT NULL, CHANGE last_name last_name VARCHAR(50) NOT NULL, CHANGE ssn ssn VARCHAR(20) NOT NULL, CHANGE address address VARCHAR(50) NOT NULL, CHANGE phone phone VARCHAR(20) NOT NULL, CHANGE date_of_employment date_of_employment DATE NOT NULL, CHANGE no_days_off no_days_off INT NOT NULL, CHANGE role role VARCHAR(10) NOT NULL, CHANGE is_approved is_approved TINYINT(1) NOT NULL, CHANGE is_validated is_validated TINYINT(1) NOT NULL");
    }
}