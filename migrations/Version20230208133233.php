<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230208133233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            "INSERT INTO category (name, color)
             VALUES 
        ('RH', '#9B084F'),
        ('Administratif', '#24673A'),
        ('Finance', '#E36164'),
        ('R&D', '#474136'),
        ('Juridique', '#70AF90'),
        ('Marketing', '#F3976B')
        "
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql("TRUNCATE TABLE category");
    }
}
