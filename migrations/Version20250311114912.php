<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250311114912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE feed_chat (id SERIAL NOT NULL, feed_id INT NOT NULL, chat_id BIGINT NOT NULL, refresh_interval INT DEFAULT NULL, last_check_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E50A19FD51A5BC03 ON feed_chat (feed_id)');
        $this->addSql('COMMENT ON COLUMN feed_chat.last_check_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN feed_chat.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN feed_chat.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE feed_chat ADD CONSTRAINT FK_E50A19FD51A5BC03 FOREIGN KEY (feed_id) REFERENCES feed (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE feed DROP last_read_at');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feed_chat DROP CONSTRAINT FK_E50A19FD51A5BC03');
        $this->addSql('DROP TABLE feed_chat');
        $this->addSql('ALTER TABLE feed ADD last_read_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN feed.last_read_at IS \'(DC2Type:datetime_immutable)\'');
    }
}
