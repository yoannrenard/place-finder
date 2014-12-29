<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141228132601 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `place_categories` (`place_id` INT NOT NULL, `placecategory_id` INT NOT NULL, INDEX `IDX_1433D060DA6A219` (`place_id`), INDEX `IDX_1433D0605FCDFB92` (`placecategory_id`), PRIMARY KEY(`place_id`, `placecategory_id`))');
        $this->addSql('CREATE TABLE `place_category` (`id` INT AUTO_INCREMENT NOT NULL, `name` VARCHAR(50) NOT NULL, PRIMARY KEY(`id`))');
        $this->addSql('ALTER TABLE `place_categories` ADD CONSTRAINT `FK_1433D060DA6A219` FOREIGN KEY (`place_id`) REFERENCES `place` (`id`) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `place_categories` ADD CONSTRAINT `FK_1433D0605FCDFB92` FOREIGN KEY (`placecategory_id`) REFERENCES `place_category` (`id`) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `place_categories` DROP FOREIGN KEY FK_1433D0605FCDFB92');
        $this->addSql('DROP TABLE `place_categories`');
        $this->addSql('DROP TABLE `place_category`');
    }
}
