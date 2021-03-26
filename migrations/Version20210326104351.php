<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210326104351 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, street VARCHAR(255) NOT NULL, suite VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, zipcode INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compagnies (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, catch_phrase VARCHAR(255) NOT NULL, bs VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compagny (id INT AUTO_INCREMENT NOT NULL, adress VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, country VARCHAR(255) DEFAULT NULL, postal_code INT NOT NULL, phone_number INT NOT NULL, website VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE geolocation (id INT AUTO_INCREMENT NOT NULL, latitude VARCHAR(255) NOT NULL, longitude VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, address_id INT DEFAULT NULL, compagnies_id INT DEFAULT NULL, geo_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone INT NOT NULL, website VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F5B7AF75 (address_id), UNIQUE INDEX UNIQ_8D93D6495F9EE3CE (compagnies_id), UNIQUE INDEX UNIQ_8D93D649FA49D0B (geo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495F9EE3CE FOREIGN KEY (compagnies_id) REFERENCES compagnies (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649FA49D0B FOREIGN KEY (geo_id) REFERENCES geolocation (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F5B7AF75');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495F9EE3CE');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649FA49D0B');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE compagnies');
        $this->addSql('DROP TABLE compagny');
        $this->addSql('DROP TABLE geolocation');
        $this->addSql('DROP TABLE user');
    }
}
