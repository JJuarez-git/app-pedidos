<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201216000403 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categoria (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion CLOB DEFAULT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__producto AS SELECT id, nombre, peso, stock FROM producto');
        $this->addSql('DROP TABLE producto');
        $this->addSql('CREATE TABLE producto (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL COLLATE BINARY, peso DOUBLE PRECISION DEFAULT NULL, stock INTEGER NOT NULL, descripcion CLOB DEFAULT NULL, Categoria INTEGER DEFAULT NULL, CONSTRAINT FK_A7BB0615CCE1908E FOREIGN KEY (Categoria) REFERENCES categoria (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO producto (id, nombre, peso, stock) SELECT id, nombre, peso, stock FROM __temp__producto');
        $this->addSql('DROP TABLE __temp__producto');
        $this->addSql('CREATE INDEX IDX_A7BB0615CCE1908E ON producto (Categoria)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP INDEX IDX_A7BB0615CCE1908E');
        $this->addSql('CREATE TEMPORARY TABLE __temp__producto AS SELECT id, nombre, peso, stock FROM producto');
        $this->addSql('DROP TABLE producto');
        $this->addSql('CREATE TABLE producto (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, peso DOUBLE PRECISION DEFAULT NULL, stock INTEGER NOT NULL)');
        $this->addSql('INSERT INTO producto (id, nombre, peso, stock) SELECT id, nombre, peso, stock FROM __temp__producto');
        $this->addSql('DROP TABLE __temp__producto');
    }
}
