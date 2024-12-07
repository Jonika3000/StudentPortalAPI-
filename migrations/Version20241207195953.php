<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241207195953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE grade_range_id_seq CASCADE');
        $this->addSql('DROP TABLE grade_range');
        $this->addSql('ALTER TABLE "user" ADD reset_token_expiry TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD reset_token VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE grade_range_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE grade_range (id SERIAL NOT NULL, max INT NOT NULL, min INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE "user" DROP reset_token_expiry');
        $this->addSql('ALTER TABLE "user" DROP reset_token');
    }
}
