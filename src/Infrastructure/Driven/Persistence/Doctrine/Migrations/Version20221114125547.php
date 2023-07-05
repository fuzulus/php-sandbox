<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221114125547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add pokemons and pokedex_entries tables.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE pokedex_entries (id CHAR(36) NOT NULL COMMENT \'(DC2Type:pokedexEntryId)\', pokemon_id CHAR(36) NOT NULL COMMENT \'(DC2Type:pokemonId)\', number VARCHAR(255) NOT NULL, created_at_timestamp INT NOT NULL, updated_at_timestamp INT DEFAULT NULL, UNIQUE INDEX UNIQ_F2275AE32FE71C3E (pokemon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pokemons (id CHAR(36) NOT NULL COMMENT \'(DC2Type:pokemonId)\', name VARCHAR(20) NOT NULL, first_type VARCHAR(20) NOT NULL, second_type VARCHAR(20) NOT NULL, created_at_timestamp INT NOT NULL, updated_at_timestamp INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pokedex_entries ADD CONSTRAINT FK_F2275AE32FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemons (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE pokedex_entries DROP FOREIGN KEY FK_F2275AE32FE71C3E');
        $this->addSql('DROP TABLE pokedex_entries');
        $this->addSql('DROP TABLE pokemons');
    }
}
