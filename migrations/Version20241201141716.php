<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241201141716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE teacher_lesson (teacher_id INT NOT NULL, lesson_id INT NOT NULL, PRIMARY KEY(teacher_id, lesson_id))');
        $this->addSql('CREATE INDEX IDX_EDFFA60641807E1D ON teacher_lesson (teacher_id)');
        $this->addSql('CREATE INDEX IDX_EDFFA606CDF80196 ON teacher_lesson (lesson_id)');
        $this->addSql('ALTER TABLE teacher_lesson ADD CONSTRAINT FK_EDFFA60641807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teacher_lesson ADD CONSTRAINT FK_EDFFA606CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lesson DROP CONSTRAINT fk_f87474f384365182');
        $this->addSql('DROP INDEX idx_f87474f384365182');
        $this->addSql('ALTER TABLE lesson DROP teachers_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE teacher_lesson DROP CONSTRAINT FK_EDFFA60641807E1D');
        $this->addSql('ALTER TABLE teacher_lesson DROP CONSTRAINT FK_EDFFA606CDF80196');
        $this->addSql('DROP TABLE teacher_lesson');
        $this->addSql('ALTER TABLE lesson ADD teachers_id INT NOT NULL');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT fk_f87474f384365182 FOREIGN KEY (teachers_id) REFERENCES teacher (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_f87474f384365182 ON lesson (teachers_id)');
    }
}
