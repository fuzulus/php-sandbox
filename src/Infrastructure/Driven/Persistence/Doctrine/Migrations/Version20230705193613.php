<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230705193613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add users table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE users (id CHAR(36) NOT NULL COMMENT \'(DC2Type:userId)\', email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, created_at_timestamp INT NOT NULL, updated_at_timestamp INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE users');
    }
}
