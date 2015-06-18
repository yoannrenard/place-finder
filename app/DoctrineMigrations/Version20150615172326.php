<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150615172326 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE place_update_proposal (id INT AUTO_INCREMENT NOT NULL, place_id INT DEFAULT NULL, operation ENUM(\'remove\', \'add\', \'replace\', \'move\', \'copy\'), field VARCHAR(50) NOT NULL, value VARCHAR(255) NOT NULL, create_dt DATETIME NOT NULL, appliedDt DATETIME DEFAULT NULL, status ENUM(\'new\', \'rejected\', \'applied\'), INDEX IDX_49300506DA6A219 (place_id), PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE place_update_proposal ADD CONSTRAINT FK_49300506DA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE place_update_proposal');
    }
}
