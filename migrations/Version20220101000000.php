<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220101000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create "father", "grand" and "son" tables';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE father (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_id INTEGER DEFAULT NULL, label_father VARCHAR(31) NOT NULL, CONSTRAINT FK_CF2531B8727ACA70 FOREIGN KEY (parent_id) REFERENCES grand (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_CF2531B8727ACA70 ON father (parent_id)');
        $this->addSql('CREATE TABLE grand (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, label_grand VARCHAR(31) NOT NULL)');
        $this->addSql('CREATE TABLE son (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_id INTEGER DEFAULT NULL, label_son VARCHAR(31) NOT NULL, CONSTRAINT FK_E199342C727ACA70 FOREIGN KEY (parent_id) REFERENCES father (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_E199342C727ACA70 ON son (parent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE father');
        $this->addSql('DROP TABLE grand');
        $this->addSql('DROP TABLE son');
    }
}
