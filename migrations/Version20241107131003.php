<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241107131003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_D4E6F81A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avatar (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, filename VARCHAR(255) DEFAULT NULL, filepath VARCHAR(255) DEFAULT NULL, uploaded_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_1677722FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE center_of_interest (id INT AUTO_INCREMENT NOT NULL, center_of_interest_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE center_of_interest_user (center_of_interest_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A4EDA97C6EB27FB4 (center_of_interest_id), INDEX IDX_A4EDA97CA76ED395 (user_id), PRIMARY KEY(center_of_interest_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE other_info (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, category_socioprofessional VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_A2CD6785A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personal_info (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, civility VARCHAR(20) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, firstname VARCHAR(255) DEFAULT NULL, date_of_birth VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_FA83366AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE avatar ADD CONSTRAINT FK_1677722FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE center_of_interest_user ADD CONSTRAINT FK_A4EDA97C6EB27FB4 FOREIGN KEY (center_of_interest_id) REFERENCES center_of_interest (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE center_of_interest_user ADD CONSTRAINT FK_A4EDA97CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE other_info ADD CONSTRAINT FK_A2CD6785A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE personal_info ADD CONSTRAINT FK_FA83366AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD username VARCHAR(255) DEFAULT NULL, DROP pseudo, CHANGE phone phone VARCHAR(20) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F81A76ED395');
        $this->addSql('ALTER TABLE avatar DROP FOREIGN KEY FK_1677722FA76ED395');
        $this->addSql('ALTER TABLE center_of_interest_user DROP FOREIGN KEY FK_A4EDA97C6EB27FB4');
        $this->addSql('ALTER TABLE center_of_interest_user DROP FOREIGN KEY FK_A4EDA97CA76ED395');
        $this->addSql('ALTER TABLE other_info DROP FOREIGN KEY FK_A2CD6785A76ED395');
        $this->addSql('ALTER TABLE personal_info DROP FOREIGN KEY FK_FA83366AA76ED395');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE avatar');
        $this->addSql('DROP TABLE center_of_interest');
        $this->addSql('DROP TABLE center_of_interest_user');
        $this->addSql('DROP TABLE other_info');
        $this->addSql('DROP TABLE personal_info');
        $this->addSql('ALTER TABLE user ADD pseudo VARCHAR(100) NOT NULL, DROP username, CHANGE phone phone VARCHAR(20) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME DEFAULT NULL');
    }
}
