<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241220204532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA app');
        $this->addSql('CREATE TABLE app.post (user_id INT NOT NULL, post_id INT NOT NULL, PRIMARY KEY(user_id, post_id))');
        $this->addSql('CREATE INDEX IDX_9B168052A76ED395 ON app.post (user_id)');
        $this->addSql('CREATE INDEX IDX_9B1680524B89032C ON app.post (post_id)');
        $this->addSql('ALTER TABLE app.post ADD CONSTRAINT FK_9B168052A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE app.post ADD CONSTRAINT FK_9B1680524B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE app.post DROP CONSTRAINT FK_9B168052A76ED395');
        $this->addSql('ALTER TABLE app.post DROP CONSTRAINT FK_9B1680524B89032C');
        $this->addSql('DROP TABLE app.post');
    }
}
