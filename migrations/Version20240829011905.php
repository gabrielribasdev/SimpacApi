<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240829011905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE trabalhos_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE trabalhos (id INT NOT NULL, area_id INT DEFAULT NULL, curso_id INT DEFAULT NULL, modelo_id INT DEFAULT NULL, protocolo INT DEFAULT NULL, titulo VARCHAR(255) DEFAULT NULL, data_cadastro TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, data_atualizacao TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75C122AABD0F409C ON trabalhos (area_id)');
        $this->addSql('CREATE INDEX IDX_75C122AA87CB4A1F ON trabalhos (curso_id)');
        $this->addSql('CREATE INDEX IDX_75C122AAC3A9576E ON trabalhos (modelo_id)');
        $this->addSql('CREATE TABLE trabalhos_usuarioavaliador (trabalhos_id INT NOT NULL, usuarioavaliador_id INT NOT NULL, PRIMARY KEY(trabalhos_id, usuarioavaliador_id))');
        $this->addSql('CREATE INDEX IDX_9BC627EEF97FA9F5 ON trabalhos_usuarioavaliador (trabalhos_id)');
        $this->addSql('CREATE INDEX IDX_9BC627EEE050612 ON trabalhos_usuarioavaliador (usuarioavaliador_id)');
        $this->addSql('ALTER TABLE trabalhos ADD CONSTRAINT FK_75C122AABD0F409C FOREIGN KEY (area_id) REFERENCES area_atuacao (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE trabalhos ADD CONSTRAINT FK_75C122AA87CB4A1F FOREIGN KEY (curso_id) REFERENCES cursos (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE trabalhos ADD CONSTRAINT FK_75C122AAC3A9576E FOREIGN KEY (modelo_id) REFERENCES modelo_avaliativo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE trabalhos_usuarioavaliador ADD CONSTRAINT FK_9BC627EEF97FA9F5 FOREIGN KEY (trabalhos_id) REFERENCES trabalhos (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE trabalhos_usuarioavaliador ADD CONSTRAINT FK_9BC627EEE050612 FOREIGN KEY (usuarioavaliador_id) REFERENCES usuario_avaliador (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE trabalhos_id_seq CASCADE');
        $this->addSql('ALTER TABLE trabalhos DROP CONSTRAINT FK_75C122AABD0F409C');
        $this->addSql('ALTER TABLE trabalhos DROP CONSTRAINT FK_75C122AA87CB4A1F');
        $this->addSql('ALTER TABLE trabalhos DROP CONSTRAINT FK_75C122AAC3A9576E');
        $this->addSql('ALTER TABLE trabalhos_usuarioavaliador DROP CONSTRAINT FK_9BC627EEF97FA9F5');
        $this->addSql('ALTER TABLE trabalhos_usuarioavaliador DROP CONSTRAINT FK_9BC627EEE050612');
        $this->addSql('DROP TABLE trabalhos');
        $this->addSql('DROP TABLE trabalhos_usuarioavaliador');
    }
}
