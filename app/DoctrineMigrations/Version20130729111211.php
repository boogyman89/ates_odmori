<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130729111211 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, ssn VARCHAR(20) NOT NULL, address VARCHAR(50) NOT NULL, phone VARCHAR(20) NOT NULL, date_of_employment DATE NOT NULL, email VARCHAR(30) NOT NULL, no_days_off INT NOT NULL, role VARCHAR(10) NOT NULL, password VARCHAR(30) NOT NULL, is_approved TINYINT(1) NOT NULL, is_validated TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("DROP TABLE korisnik");
        $this->addSql("DROP TABLE privremeni_korisnik");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE korisnik (id INT AUTO_INCREMENT NOT NULL, ime VARCHAR(50) NOT NULL, prezime VARCHAR(50) NOT NULL, jmbg VARCHAR(20) NOT NULL, adresa VARCHAR(50) NOT NULL, telefon VARCHAR(20) NOT NULL, pocetak_rada DATE NOT NULL, email VARCHAR(30) NOT NULL, br_slobodnih_dana INT NOT NULL, privilegija VARCHAR(10) NOT NULL, sifra VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE privremeni_korisnik (id INT AUTO_INCREMENT NOT NULL, ime VARCHAR(50) NOT NULL, prezime VARCHAR(50) NOT NULL, jmbg VARCHAR(20) NOT NULL, adresa VARCHAR(50) NOT NULL, telefon VARCHAR(20) NOT NULL, pocetak_rada DATE NOT NULL, email VARCHAR(30) NOT NULL, sifra VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("DROP TABLE user");
    }
}
