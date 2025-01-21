<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250121214832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE like_id_seq CASCADE');
        $this->addSql('CREATE TABLE "likes" (id SERIAL NOT NULL, user_id INT NOT NULL, post_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_49CA4E7DA76ED395 ON "likes" (user_id)');
        $this->addSql('CREATE INDEX IDX_49CA4E7D4B89032C ON "likes" (post_id)');
        $this->addSql('COMMENT ON COLUMN "likes".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE "likes" ADD CONSTRAINT FK_49CA4E7DA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "likes" ADD CONSTRAINT FK_49CA4E7D4B89032C FOREIGN KEY (post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "like" DROP CONSTRAINT fk_ac6340b3a76ed395');
        $this->addSql('ALTER TABLE "like" DROP CONSTRAINT fk_ac6340b34b89032c');
        $this->addSql('DROP TABLE "like"');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SCHEMA app');
        $this->addSql('CREATE SEQUENCE like_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "like" (id SERIAL NOT NULL, user_id INT NOT NULL, post_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_ac6340b34b89032c ON "like" (post_id)');
        $this->addSql('CREATE INDEX idx_ac6340b3a76ed395 ON "like" (user_id)');
        $this->addSql('COMMENT ON COLUMN "like".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE "like" ADD CONSTRAINT fk_ac6340b3a76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "like" ADD CONSTRAINT fk_ac6340b34b89032c FOREIGN KEY (post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "likes" DROP CONSTRAINT FK_49CA4E7DA76ED395');
        $this->addSql('ALTER TABLE "likes" DROP CONSTRAINT FK_49CA4E7D4B89032C');
        $this->addSql('DROP TABLE "likes"');
    }
}
