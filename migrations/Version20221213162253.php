<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221213162253 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD firstname LONGTEXT NOT NULL, ADD lastname LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE firstname firstname VARCHAR(255) NOT NULL, CHANGE lastname lastname VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD is_approved TINYINT(1) NOT NULL');
        $this->addSql('CREATE TABLE decision (id INT AUTO_INCREMENT NOT NULL, title LONGTEXT NOT NULL, decision_start_time DATE NOT NULL, details LONGTEXT NOT NULL, impact LONGTEXT NOT NULL, gain LONGTEXT NOT NULL, risk LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD image_name VARCHAR(255) NOT NULL, ADD image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP image');
        $this->addSql('ALTER TABLE user CHANGE image_name poster VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE poster poster_file VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE poster_file poster VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD updated_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE user DROP firstname, DROP lastname');
        $this->addSql('ALTER TABLE user CHANGE firstname firstname LONGTEXT NOT NULL, CHANGE lastname lastname LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE user DROP is_approved');
        $this->addSql('DROP TABLE decision');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE user DROP image_name, DROP image');
        $this->addSql('ALTER TABLE user ADD image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE poster image_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE poster_file poster VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE poster poster_file VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user DROP updated_at');
    }
}
