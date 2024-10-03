<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241003074136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ad_specification (id INT AUTO_INCREMENT NOT NULL, ad_id INT DEFAULT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_C30454B04F34D596 (ad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_specification (id INT AUTO_INCREMENT NOT NULL, subcategory_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, is_required TINYINT(1) NOT NULL, INDEX IDX_10E43FD15DC6FE57 (subcategory_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ad_specification ADD CONSTRAINT FK_C30454B04F34D596 FOREIGN KEY (ad_id) REFERENCES ad (id)');
        $this->addSql('ALTER TABLE category_specification ADD CONSTRAINT FK_10E43FD15DC6FE57 FOREIGN KEY (subcategory_id) REFERENCES sub_category (id)');
        $this->addSql('ALTER TABLE ad ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE ad ADD CONSTRAINT FK_77E0ED58A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_77E0ED58A76ED395 ON ad (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ad_specification DROP FOREIGN KEY FK_C30454B04F34D596');
        $this->addSql('ALTER TABLE category_specification DROP FOREIGN KEY FK_10E43FD15DC6FE57');
        $this->addSql('DROP TABLE ad_specification');
        $this->addSql('DROP TABLE category_specification');
        $this->addSql('ALTER TABLE ad DROP FOREIGN KEY FK_77E0ED58A76ED395');
        $this->addSql('DROP INDEX IDX_77E0ED58A76ED395 ON ad');
        $this->addSql('ALTER TABLE ad DROP user_id');
    }
}
