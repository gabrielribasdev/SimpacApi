<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240829013900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE avaliacoes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE avaliacoes (id INT NOT NULL, trabalho_id INT DEFAULT NULL, avaliador_id INT DEFAULT NULL, nota INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3E765028FE6B892 ON avaliacoes (trabalho_id)');
        $this->addSql('CREATE INDEX IDX_3E76502868934662 ON avaliacoes (avaliador_id)');
        $this->addSql('ALTER TABLE avaliacoes ADD CONSTRAINT FK_3E765028FE6B892 FOREIGN KEY (trabalho_id) REFERENCES trabalhos (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE avaliacoes ADD CONSTRAINT FK_3E76502868934662 FOREIGN KEY (avaliador_id) REFERENCES usuario_avaliador (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE avaliacoes_id_seq CASCADE');
        $this->addSql('ALTER TABLE avaliacoes DROP CONSTRAINT FK_3E765028FE6B892');
        $this->addSql('ALTER TABLE avaliacoes DROP CONSTRAINT FK_3E76502868934662');
        $this->addSql('DROP TABLE avaliacoes');
    }
}
