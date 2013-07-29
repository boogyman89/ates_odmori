<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130729105633 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE holidays (id INT AUTO_INCREMENT NOT NULL, id_admin INT NOT NULL, date DATE NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE request (id INT AUTO_INCREMENT NOT NULL, id_user INT NOT NULL, id_admin INT NOT NULL, submitted DATE NOT NULL, `from` DATE NOT NULL, `to` DATE NOT NULL, state VARCHAR(100) NOT NULL, pdf VARCHAR(200) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("DROP TABLE neradni_dani");
        $this->addSql("DROP TABLE zahtev");
        $this->addSql("ALTER TABLE slava CHANGE id_korisnik id_user INT NOT NULL, CHANGE datum date DATE NOT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE neradni_dani (id INT AUTO_INCREMENT NOT NULL, id_admin INT NOT NULL, datum DATE NOT NULL, naziv VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE zahtev (id INT AUTO_INCREMENT NOT NULL, id_user INT NOT NULL, id_admin INT NOT NULL, podnet DATE NOT NULL, od DATE NOT NULL, do DATE NOT NULL, status VARCHAR(100) NOT NULL, pdf VARCHAR(200) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("DROP TABLE holidays");
        $this->addSql("DROP TABLE request");
        $this->addSql("ALTER TABLE slava CHANGE id_user id_korisnik INT NOT NULL, CHANGE date datum DATE NOT NULL");
    }
}
