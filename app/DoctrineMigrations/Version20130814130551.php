<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130814130551 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE ext_translations (id INT AUTO_INCREMENT NOT NULL, locale VARCHAR(8) NOT NULL, object_class VARCHAR(255) NOT NULL, field VARCHAR(32) NOT NULL, foreign_key VARCHAR(64) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX translations_lookup_idx (locale, object_class, foreign_key), UNIQUE INDEX lookup_unique_idx (locale, object_class, field, foreign_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE holidays ADD created DATETIME NOT NULL, ADD updated DATETIME NOT NULL");
        $this->addSql("ALTER TABLE request ADD user_id INT DEFAULT NULL, ADD created DATETIME NOT NULL, ADD updated DATETIME NOT NULL, DROP id_user, DROP submitted, DROP edit_time");
        $this->addSql("ALTER TABLE request ADD CONSTRAINT FK_3B978F9FA76ED395 FOREIGN KEY (user_id) REFERENCES employee (id)");
        $this->addSql("CREATE INDEX IDX_3B978F9FA76ED395 ON request (user_id)");
        $this->addSql("ALTER TABLE employee ADD created DATETIME NOT NULL, ADD updated DATETIME NOT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE ext_translations");
        $this->addSql("ALTER TABLE employee DROP created, DROP updated");
        $this->addSql("ALTER TABLE holidays DROP created, DROP updated");
        $this->addSql("ALTER TABLE request DROP FOREIGN KEY FK_3B978F9FA76ED395");
        $this->addSql("DROP INDEX IDX_3B978F9FA76ED395 ON request");
        $this->addSql("ALTER TABLE request ADD id_user INT NOT NULL, ADD submitted DATETIME NOT NULL, ADD edit_time DATETIME NOT NULL, DROP user_id, DROP created, DROP updated");
    }
}
