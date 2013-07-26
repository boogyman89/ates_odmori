<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130726130444 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE privremeni_korisnik (id INT AUTO_INCREMENT NOT NULL, ime VARCHAR(50) NOT NULL, prezime VARCHAR(50) NOT NULL, jmbg VARCHAR(20) NOT NULL, adresa VARCHAR(50) NOT NULL, telefon VARCHAR(20) NOT NULL, pocetak_rada DATE NOT NULL, email VARCHAR(30) NOT NULL, sifra VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE korisnik ADD sifra VARCHAR(30) NOT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE privremeni_korisnik");
        $this->addSql("ALTER TABLE korisnik DROP sifra");
    }
}
