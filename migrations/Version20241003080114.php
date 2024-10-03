<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241003080114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ad_specification ADD category_specification_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ad_specification ADD CONSTRAINT FK_C30454B015B3967A FOREIGN KEY (category_specification_id) REFERENCES category_specification (id)');
        $this->addSql('CREATE INDEX IDX_C30454B015B3967A ON ad_specification (category_specification_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ad_specification DROP FOREIGN KEY FK_C30454B015B3967A');
        $this->addSql('DROP INDEX IDX_C30454B015B3967A ON ad_specification');
        $this->addSql('ALTER TABLE ad_specification DROP category_specification_id');
    }
}
