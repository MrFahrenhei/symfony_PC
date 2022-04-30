<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220430025450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        //$this->abortIf($this->connection->getDatabase()->getName() !== 'sqlite', "Migration can only be executed safely on \'sqlite\'.");

        $this->addSql('CREATE TABLE medicos (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, crm INTEGER NOT NULL, nome VARCHAR(255) NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        //$this->abortIf($this->connection->getDatabase()->getName() !== 'sqlite', "Migration can only be executed safely on \'sqlite\'.");

        $this->addSql('DROP TABLE medicos');
    }
}
