<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201228133414 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pedido (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, usuario_id INTEGER NOT NULL, fecha DATETIME NOT NULL, enviado INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_C4EC16CEDB38439E ON pedido (usuario_id)');
        $this->addSql('DROP INDEX IDX_A7BB0615CCE1908E');
        $this->addSql('CREATE TEMPORARY TABLE __temp__producto AS SELECT id, nombre, peso, stock, descripcion, Categoria, foto, precio FROM producto');
        $this->addSql('DROP TABLE producto');
        $this->addSql('CREATE TABLE producto (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL COLLATE BINARY, peso DOUBLE PRECISION DEFAULT NULL, stock INTEGER NOT NULL, descripcion CLOB DEFAULT NULL COLLATE BINARY, Categoria INTEGER DEFAULT NULL, foto VARCHAR(255) NOT NULL COLLATE BINARY, precio DOUBLE PRECISION NOT NULL, CONSTRAINT FK_A7BB0615CCE1908E FOREIGN KEY (Categoria) REFERENCES categoria (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO producto (id, nombre, peso, stock, descripcion, Categoria, foto, precio) SELECT id, nombre, peso, stock, descripcion, Categoria, foto, precio FROM __temp__producto');
        $this->addSql('DROP TABLE __temp__producto');
        $this->addSql('CREATE INDEX IDX_A7BB0615CCE1908E ON producto (Categoria)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE pedido');
        $this->addSql('DROP INDEX IDX_A7BB0615CCE1908E');
        $this->addSql('CREATE TEMPORARY TABLE __temp__producto AS SELECT id, nombre, peso, stock, descripcion, foto, precio, Categoria FROM producto');
        $this->addSql('DROP TABLE producto');
        $this->addSql('CREATE TABLE producto (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, peso DOUBLE PRECISION DEFAULT NULL, stock INTEGER NOT NULL, descripcion CLOB DEFAULT NULL, foto VARCHAR(255) NOT NULL, precio DOUBLE PRECISION NOT NULL, Categoria INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO producto (id, nombre, peso, stock, descripcion, foto, precio, Categoria) SELECT id, nombre, peso, stock, descripcion, foto, precio, Categoria FROM __temp__producto');
        $this->addSql('DROP TABLE __temp__producto');
        $this->addSql('CREATE INDEX IDX_A7BB0615CCE1908E ON producto (Categoria)');
    }
}
