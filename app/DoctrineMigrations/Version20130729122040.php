<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130729122040 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE ates_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT '(DC2Type:array)', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, ssn VARCHAR(20) NOT NULL, address VARCHAR(50) NOT NULL, phone VARCHAR(20) NOT NULL, date_of_employment DATE NOT NULL, no_days_off INT NOT NULL, role VARCHAR(10) NOT NULL, is_approved TINYINT(1) NOT NULL, is_validated TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_C7A7534192FC23A8 (username_canonical), UNIQUE INDEX UNIQ_C7A75341A0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("DROP TABLE user");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, ssn VARCHAR(20) NOT NULL, address VARCHAR(50) NOT NULL, phone VARCHAR(20) NOT NULL, date_of_employment DATE NOT NULL, email VARCHAR(30) NOT NULL, no_days_off INT NOT NULL, role VARCHAR(10) NOT NULL, password VARCHAR(30) NOT NULL, is_approved TINYINT(1) NOT NULL, is_validated TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("DROP TABLE ates_user");
    }
}
