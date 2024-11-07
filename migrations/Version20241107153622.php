<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241107153622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, address VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avatar (id INT AUTO_INCREMENT NOT NULL, filename VARCHAR(255) DEFAULT NULL, filepath VARCHAR(255) DEFAULT NULL, uploaded_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE center_of_interest (id INT AUTO_INCREMENT NOT NULL, center_of_interest_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE other_info (id INT AUTO_INCREMENT NOT NULL, category_socioprofessional VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personal_info (id INT AUTO_INCREMENT NOT NULL, civility VARCHAR(20) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, firstname VARCHAR(255) DEFAULT NULL, date_of_birth VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_center_of_interest (user_id INT NOT NULL, center_of_interest_id INT NOT NULL, INDEX IDX_F3A1F373A76ED395 (user_id), INDEX IDX_F3A1F3736EB27FB4 (center_of_interest_id), PRIMARY KEY(user_id, center_of_interest_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_center_of_interest ADD CONSTRAINT FK_F3A1F373A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_center_of_interest ADD CONSTRAINT FK_F3A1F3736EB27FB4 FOREIGN KEY (center_of_interest_id) REFERENCES center_of_interest (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD address_id INT DEFAULT NULL, ADD avatar_id INT DEFAULT NULL, ADD other_info_id INT DEFAULT NULL, ADD personal_info_id INT DEFAULT NULL, ADD phone VARCHAR(10) DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP firtname, DROP lastname, CHANGE username username VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64986383B10 FOREIGN KEY (avatar_id) REFERENCES avatar (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494ED65F94 FOREIGN KEY (other_info_id) REFERENCES other_info (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649DEACC8D3 FOREIGN KEY (personal_info_id) REFERENCES personal_info (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F5B7AF75 ON user (address_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64986383B10 ON user (avatar_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6494ED65F94 ON user (other_info_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649DEACC8D3 ON user (personal_info_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F5B7AF75');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64986383B10');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494ED65F94');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649DEACC8D3');
        $this->addSql('ALTER TABLE user_center_of_interest DROP FOREIGN KEY FK_F3A1F373A76ED395');
        $this->addSql('ALTER TABLE user_center_of_interest DROP FOREIGN KEY FK_F3A1F3736EB27FB4');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE avatar');
        $this->addSql('DROP TABLE center_of_interest');
        $this->addSql('DROP TABLE other_info');
        $this->addSql('DROP TABLE personal_info');
        $this->addSql('DROP TABLE user_center_of_interest');
        $this->addSql('DROP INDEX UNIQ_8D93D649F5B7AF75 ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D64986383B10 ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D6494ED65F94 ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D649DEACC8D3 ON user');
        $this->addSql('ALTER TABLE user ADD firtname VARCHAR(100) NOT NULL, ADD lastname VARCHAR(100) NOT NULL, DROP address_id, DROP avatar_id, DROP other_info_id, DROP personal_info_id, DROP phone, DROP created_at, DROP updated_at, CHANGE username username VARCHAR(80) NOT NULL');
    }
}
