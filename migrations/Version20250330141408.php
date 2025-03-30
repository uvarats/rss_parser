<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250330141408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE feed ADD last_check_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN feed.last_check_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE feed_chat DROP refresh_interval
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE feed_chat DROP last_check_at
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE feed DROP last_check_at
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE feed_chat ADD refresh_interval INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE feed_chat ADD last_check_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN feed_chat.last_check_at IS '(DC2Type:datetime_immutable)'
        SQL);
    }
}
