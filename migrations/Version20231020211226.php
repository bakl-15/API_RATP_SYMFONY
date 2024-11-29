<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231020211226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE node_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE line (id INT NOT NULL, name VARCHAR(255) NOT NULL, idrefliga VARCHAR(255) DEFAULT NULL, idrefligc VARCHAR(255) DEFAULT NULL, cod_ligf VARCHAR(255) DEFAULT NULL, res_com VARCHAR(255) DEFAULT NULL, code_resf VARCHAR(255) DEFAULT NULL, res_stif VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE node (id INT NOT NULL, line_id INT DEFAULT NULL, station_id INT DEFAULT NULL, is_terminus BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_857FE8454D7B7542 ON node (line_id)');
        $this->addSql('CREATE INDEX IDX_857FE84521BDB235 ON node (station_id)');
        $this->addSql('CREATE TABLE station (id INT NOT NULL, name VARCHAR(255) NOT NULL, name_long VARCHAR(255) DEFAULT NULL, name_iv VARCHAR(255) DEFAULT NULL, x VARCHAR(255) DEFAULT NULL, y VARCHAR(255) DEFAULT NULL, geo_point VARCHAR(255) DEFAULT NULL, main BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE station_line (station_id INT NOT NULL, line_id INT NOT NULL, PRIMARY KEY(station_id, line_id))');
        $this->addSql('CREATE INDEX IDX_3F2793CB21BDB235 ON station_line (station_id)');
        $this->addSql('CREATE INDEX IDX_3F2793CB4D7B7542 ON station_line (line_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE node ADD CONSTRAINT FK_857FE8454D7B7542 FOREIGN KEY (line_id) REFERENCES line (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE node ADD CONSTRAINT FK_857FE84521BDB235 FOREIGN KEY (station_id) REFERENCES station (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE station_line ADD CONSTRAINT FK_3F2793CB21BDB235 FOREIGN KEY (station_id) REFERENCES station (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE station_line ADD CONSTRAINT FK_3F2793CB4D7B7542 FOREIGN KEY (line_id) REFERENCES line (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE node DROP CONSTRAINT FK_857FE8454D7B7542');
        $this->addSql('ALTER TABLE station_line DROP CONSTRAINT FK_3F2793CB4D7B7542');
        $this->addSql('ALTER TABLE node DROP CONSTRAINT FK_857FE84521BDB235');
        $this->addSql('ALTER TABLE station_line DROP CONSTRAINT FK_3F2793CB21BDB235');
        $this->addSql('DROP SEQUENCE node_id_seq CASCADE');
        $this->addSql('DROP TABLE line');
        $this->addSql('DROP TABLE node');
        $this->addSql('DROP TABLE station');
        $this->addSql('DROP TABLE station_line');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
