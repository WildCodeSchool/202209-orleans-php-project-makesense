<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230205215532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, decision_id INT DEFAULT NULL, decision_status VARCHAR(30) DEFAULT NULL, status_color CHAR(7) DEFAULT NULL, status_days_left VARCHAR(100) DEFAULT NULL, UNIQUE INDEX UNIQ_7B00651CBDEE7539 (decision_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651CBDEE7539 FOREIGN KEY (decision_id) REFERENCES decision (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE status DROP FOREIGN KEY FK_7B00651CBDEE7539');
        $this->addSql('DROP TABLE status');
    }
}
