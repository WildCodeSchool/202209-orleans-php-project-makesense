<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230104153537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE decision DROP first_decision_end_date, DROP conflict_end_date, DROP final_decision_end_date');
        $this->addSql('ALTER TABLE user ADD poster VARCHAR(255) NOT NULL, ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE poster poster VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE decision ADD first_decision_end_date DATE DEFAULT NULL, ADD conflict_end_date DATE DEFAULT NULL, ADD final_decision_end_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP poster, DROP updated_at');
        $this->addSql('ALTER TABLE user CHANGE poster poster VARCHAR(255) NOT NULL');
    }
}
