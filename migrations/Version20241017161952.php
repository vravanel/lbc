<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241017161952 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE specification_type (id INT AUTO_INCREMENT NOT NULL, sub_category_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, type VARCHAR(30) NOT NULL, options JSON DEFAULT NULL, INDEX IDX_C45D205BF7BFE87C (sub_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE specification_type ADD CONSTRAINT FK_C45D205BF7BFE87C FOREIGN KEY (sub_category_id) REFERENCES sub_category (id)');
        $this->addSql('ALTER TABLE ad ADD state VARCHAR(255) NOT NULL, ADD specifications JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE ad_specification ADD specification_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ad_specification ADD CONSTRAINT FK_C30454B086F60D4E FOREIGN KEY (specification_type_id) REFERENCES specification_type (id)');
        $this->addSql('CREATE INDEX IDX_C30454B086F60D4E ON ad_specification (specification_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ad_specification DROP FOREIGN KEY FK_C30454B086F60D4E');
        $this->addSql('ALTER TABLE specification_type DROP FOREIGN KEY FK_C45D205BF7BFE87C');
        $this->addSql('DROP TABLE specification_type');
        $this->addSql('ALTER TABLE ad DROP state, DROP specifications');
        $this->addSql('DROP INDEX IDX_C30454B086F60D4E ON ad_specification');
        $this->addSql('ALTER TABLE ad_specification DROP specification_type_id');
    }
}
