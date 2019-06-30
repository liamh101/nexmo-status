<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190509185157 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Make latest status a relationship to an event';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE call_log CHANGE latest_status latest_status INT DEFAULT NULL');
        $this->addSql('ALTER TABLE call_log ADD CONSTRAINT FK_D663C42EAF94D69E FOREIGN KEY (latest_status) REFERENCES event (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D663C42EAF94D69E ON call_log (latest_status)');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE call_log DROP FOREIGN KEY FK_D663C42EAF94D69E');
        $this->addSql('DROP INDEX UNIQ_D663C42EAF94D69E ON call_log');
        $this->addSql('ALTER TABLE call_log CHANGE latest_status latest_status VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
