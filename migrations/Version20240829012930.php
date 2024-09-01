<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240829012930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avaliacoes_trabalhos (trabalhos_id INT NOT NULL, usuarioavaliador_id INT NOT NULL, PRIMARY KEY(trabalhos_id, usuarioavaliador_id))');
        $this->addSql('CREATE INDEX IDX_84E6C7FDF97FA9F5 ON avaliacoes_trabalhos (trabalhos_id)');
        $this->addSql('CREATE INDEX IDX_84E6C7FDE050612 ON avaliacoes_trabalhos (usuarioavaliador_id)');
        $this->addSql('ALTER TABLE avaliacoes_trabalhos ADD CONSTRAINT FK_84E6C7FDF97FA9F5 FOREIGN KEY (trabalhos_id) REFERENCES trabalhos (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE avaliacoes_trabalhos ADD CONSTRAINT FK_84E6C7FDE050612 FOREIGN KEY (usuarioavaliador_id) REFERENCES usuario_avaliador (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE trabalhos_usuarioavaliador DROP CONSTRAINT fk_9bc627eef97fa9f5');
        $this->addSql('ALTER TABLE trabalhos_usuarioavaliador DROP CONSTRAINT fk_9bc627eee050612');
        $this->addSql('DROP TABLE trabalhos_usuarioavaliador');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE trabalhos_usuarioavaliador (trabalhos_id INT NOT NULL, usuarioavaliador_id INT NOT NULL, PRIMARY KEY(trabalhos_id, usuarioavaliador_id))');
        $this->addSql('CREATE INDEX idx_9bc627eee050612 ON trabalhos_usuarioavaliador (usuarioavaliador_id)');
        $this->addSql('CREATE INDEX idx_9bc627eef97fa9f5 ON trabalhos_usuarioavaliador (trabalhos_id)');
        $this->addSql('ALTER TABLE trabalhos_usuarioavaliador ADD CONSTRAINT fk_9bc627eef97fa9f5 FOREIGN KEY (trabalhos_id) REFERENCES trabalhos (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE trabalhos_usuarioavaliador ADD CONSTRAINT fk_9bc627eee050612 FOREIGN KEY (usuarioavaliador_id) REFERENCES usuario_avaliador (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE avaliacoes_trabalhos DROP CONSTRAINT FK_84E6C7FDF97FA9F5');
        $this->addSql('ALTER TABLE avaliacoes_trabalhos DROP CONSTRAINT FK_84E6C7FDE050612');
        $this->addSql('DROP TABLE avaliacoes_trabalhos');
    }
}
