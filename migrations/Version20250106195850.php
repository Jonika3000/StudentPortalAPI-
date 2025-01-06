<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250106195850 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student DROP CONSTRAINT fk_b723af339162176f');
        $this->addSql('DROP INDEX idx_b723af339162176f');
        $this->addSql('ALTER TABLE student RENAME COLUMN class_room_id TO classroom_id');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF336278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B723AF336278D5A8 ON student (classroom_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE student DROP CONSTRAINT FK_B723AF336278D5A8');
        $this->addSql('DROP INDEX IDX_B723AF336278D5A8');
        $this->addSql('ALTER TABLE student RENAME COLUMN classroom_id TO class_room_id');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT fk_b723af339162176f FOREIGN KEY (class_room_id) REFERENCES classroom (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_b723af339162176f ON student (class_room_id)');
    }
}
