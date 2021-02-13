<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201228235021 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__pedido AS SELECT id, enviado, User, fecha, precio FROM pedido');
        $this->addSql('DROP TABLE pedido');
        $this->addSql('CREATE TABLE pedido (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, enviado INTEGER NOT NULL, User INTEGER DEFAULT NULL, fecha DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, precio DOUBLE PRECISION NOT NULL, CONSTRAINT FK_C4EC16CE2DA17977 FOREIGN KEY (User) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO pedido (id, enviado, User, fecha, precio) SELECT id, enviado, User, fecha, precio FROM __temp__pedido');
        $this->addSql('DROP TABLE __temp__pedido');
        $this->addSql('CREATE INDEX IDX_C4EC16CE2DA17977 ON pedido (User)');
        $this->addSql('DROP INDEX IDX_DD333C2AC0827E5');
        $this->addSql('DROP INDEX IDX_DD333C29370CFE1');
        $this->addSql('CREATE TEMPORARY TABLE __temp__pedido_producto AS SELECT id, cod_ped_id, cod_prod_id, unidades FROM pedido_producto');
        $this->addSql('DROP TABLE pedido_producto');
        $this->addSql('CREATE TABLE pedido_producto (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, cod_ped_id INTEGER DEFAULT NULL, cod_prod_id INTEGER DEFAULT NULL, unidades INTEGER NOT NULL, CONSTRAINT FK_DD333C2AC0827E5 FOREIGN KEY (cod_ped_id) REFERENCES pedido (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_DD333C29370CFE1 FOREIGN KEY (cod_prod_id) REFERENCES producto (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO pedido_producto (id, cod_ped_id, cod_prod_id, unidades) SELECT id, cod_ped_id, cod_prod_id, unidades FROM __temp__pedido_producto');
        $this->addSql('DROP TABLE __temp__pedido_producto');
        $this->addSql('CREATE INDEX IDX_DD333C2AC0827E5 ON pedido_producto (cod_ped_id)');
        $this->addSql('CREATE INDEX IDX_DD333C29370CFE1 ON pedido_producto (cod_prod_id)');
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
        $this->addSql('DROP INDEX IDX_C4EC16CE2DA17977');
        $this->addSql('CREATE TEMPORARY TABLE __temp__pedido AS SELECT id, fecha, enviado, precio, User FROM pedido');
        $this->addSql('DROP TABLE pedido');
        $this->addSql('CREATE TABLE pedido (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, fecha DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, enviado INTEGER NOT NULL, precio DOUBLE PRECISION NOT NULL, User INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO pedido (id, fecha, enviado, precio, User) SELECT id, fecha, enviado, precio, User FROM __temp__pedido');
        $this->addSql('DROP TABLE __temp__pedido');
        $this->addSql('DROP INDEX IDX_DD333C2AC0827E5');
        $this->addSql('DROP INDEX IDX_DD333C29370CFE1');
        $this->addSql('CREATE TEMPORARY TABLE __temp__pedido_producto AS SELECT id, cod_ped_id, cod_prod_id, unidades FROM pedido_producto');
        $this->addSql('DROP TABLE pedido_producto');
        $this->addSql('CREATE TABLE pedido_producto (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, cod_ped_id INTEGER DEFAULT NULL, cod_prod_id INTEGER DEFAULT NULL, unidades INTEGER NOT NULL)');
        $this->addSql('INSERT INTO pedido_producto (id, cod_ped_id, cod_prod_id, unidades) SELECT id, cod_ped_id, cod_prod_id, unidades FROM __temp__pedido_producto');
        $this->addSql('DROP TABLE __temp__pedido_producto');
        $this->addSql('CREATE INDEX IDX_DD333C2AC0827E5 ON pedido_producto (cod_ped_id)');
        $this->addSql('CREATE INDEX IDX_DD333C29370CFE1 ON pedido_producto (cod_prod_id)');
        $this->addSql('DROP INDEX IDX_A7BB0615CCE1908E');
        $this->addSql('CREATE TEMPORARY TABLE __temp__producto AS SELECT id, nombre, peso, stock, descripcion, foto, precio, Categoria FROM producto');
        $this->addSql('DROP TABLE producto');
        $this->addSql('CREATE TABLE producto (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, peso DOUBLE PRECISION DEFAULT NULL, stock INTEGER NOT NULL, descripcion CLOB DEFAULT NULL, foto VARCHAR(255) NOT NULL, precio DOUBLE PRECISION NOT NULL, Categoria INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO producto (id, nombre, peso, stock, descripcion, foto, precio, Categoria) SELECT id, nombre, peso, stock, descripcion, foto, precio, Categoria FROM __temp__producto');
        $this->addSql('DROP TABLE __temp__producto');
        $this->addSql('CREATE INDEX IDX_A7BB0615CCE1908E ON producto (Categoria)');
    }
}
