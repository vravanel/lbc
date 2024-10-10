<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241010080950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_specification DROP FOREIGN KEY FK_10E43FD15DC6FE57');
        $this->addSql('DROP INDEX IDX_10E43FD15DC6FE57 ON category_specification');
        $this->addSql('ALTER TABLE category_specification CHANGE subcategory_id sub_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category_specification ADD CONSTRAINT FK_10E43FD1F7BFE87C FOREIGN KEY (sub_category_id) REFERENCES sub_category (id)');
        $this->addSql('CREATE INDEX IDX_10E43FD1F7BFE87C ON category_specification (sub_category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_specification DROP FOREIGN KEY FK_10E43FD1F7BFE87C');
        $this->addSql('DROP INDEX IDX_10E43FD1F7BFE87C ON category_specification');
        $this->addSql('ALTER TABLE category_specification CHANGE sub_category_id subcategory_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category_specification ADD CONSTRAINT FK_10E43FD15DC6FE57 FOREIGN KEY (subcategory_id) REFERENCES sub_category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_10E43FD15DC6FE57 ON category_specification (subcategory_id)');
    }
}
