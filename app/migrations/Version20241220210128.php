<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241220210128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app.post DROP CONSTRAINT fk_9b168052a76ed395');
        $this->addSql('ALTER TABLE app.post DROP CONSTRAINT fk_9b1680524b89032c');
        $this->addSql('DROP TABLE app.post');
        $this->addSql('ALTER TABLE "user" ADD posts_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649D5E258C5 FOREIGN KEY (posts_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8D93D649D5E258C5 ON "user" (posts_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SCHEMA app');
        $this->addSql('CREATE TABLE app.post (user_id INT NOT NULL, post_id INT NOT NULL, PRIMARY KEY(user_id, post_id))');
        $this->addSql('CREATE INDEX idx_9b1680524b89032c ON app.post (post_id)');
        $this->addSql('CREATE INDEX idx_9b168052a76ed395 ON app.post (user_id)');
        $this->addSql('ALTER TABLE app.post ADD CONSTRAINT fk_9b168052a76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE app.post ADD CONSTRAINT fk_9b1680524b89032c FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649D5E258C5');
        $this->addSql('DROP INDEX IDX_8D93D649D5E258C5');
        $this->addSql('ALTER TABLE "user" DROP posts_id');
    }
}
