<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240126141811 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE doctors (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, speciality_id INT NOT NULL, registration_number VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B67687BEA76ED395 (user_id), INDEX IDX_B67687BE3B5A08D7 (speciality_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE drugs (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medications (id INT AUTO_INCREMENT NOT NULL, drug_id INT NOT NULL, prescription_id INT NOT NULL, dosage VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_4B51506CAABCA765 (drug_id, prescription_id), INDEX IDX_4B51506C93DB413D (prescription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE opinions (id INT AUTO_INCREMENT NOT NULL, prescription_id INT NOT NULL, title VARCHAR(255) NOT NULL, date DATE NOT NULL, description VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_BEAF78D093DB413D (prescription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patients (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, adress VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2CCC2E2CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prescription (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, doctor_id INT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, INDEX IDX_1FBFB8D9A76ED395 (user_id), INDEX IDX_1FBFB8D987F4FB17 (doctor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specialities (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visits (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, doctor_id INT NOT NULL, speciality_id INT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, reason VARCHAR(255) NOT NULL, INDEX IDX_444839EA6B899279 (patient_id), INDEX IDX_444839EA87F4FB17 (doctor_id), INDEX IDX_444839EA3B5A08D7 (speciality_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE doctors ADD CONSTRAINT FK_B67687BEA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE doctors ADD CONSTRAINT FK_B67687BE3B5A08D7 FOREIGN KEY (speciality_id) REFERENCES specialities (id)');
        $this->addSql('ALTER TABLE medications ADD CONSTRAINT FK_4B51506CAABCA765 FOREIGN KEY (drug_id) REFERENCES drugs (id)');
        $this->addSql('ALTER TABLE medications ADD CONSTRAINT FK_4B51506C93DB413D FOREIGN KEY (prescription_id) REFERENCES prescription (id)');
        $this->addSql('ALTER TABLE opinions ADD CONSTRAINT FK_BEAF78D093DB413D FOREIGN KEY (prescription_id) REFERENCES prescription (id)');
        $this->addSql('ALTER TABLE patients ADD CONSTRAINT FK_2CCC2E2CA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE prescription ADD CONSTRAINT FK_1FBFB8D9A76ED395 FOREIGN KEY (user_id) REFERENCES patients (id)');
        $this->addSql('ALTER TABLE prescription ADD CONSTRAINT FK_1FBFB8D987F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctors (id)');
        $this->addSql('ALTER TABLE visits ADD CONSTRAINT FK_444839EA6B899279 FOREIGN KEY (patient_id) REFERENCES patients (id)');
        $this->addSql('ALTER TABLE visits ADD CONSTRAINT FK_444839EA87F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctors (id)');
        $this->addSql('ALTER TABLE visits ADD CONSTRAINT FK_444839EA3B5A08D7 FOREIGN KEY (speciality_id) REFERENCES specialities (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doctors DROP FOREIGN KEY FK_B67687BEA76ED395');
        $this->addSql('ALTER TABLE doctors DROP FOREIGN KEY FK_B67687BE3B5A08D7');
        $this->addSql('ALTER TABLE medications DROP FOREIGN KEY FK_4B51506CAABCA765');
        $this->addSql('ALTER TABLE medications DROP FOREIGN KEY FK_4B51506C93DB413D');
        $this->addSql('ALTER TABLE opinions DROP FOREIGN KEY FK_BEAF78D093DB413D');
        $this->addSql('ALTER TABLE patients DROP FOREIGN KEY FK_2CCC2E2CA76ED395');
        $this->addSql('ALTER TABLE prescription DROP FOREIGN KEY FK_1FBFB8D9A76ED395');
        $this->addSql('ALTER TABLE prescription DROP FOREIGN KEY FK_1FBFB8D987F4FB17');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9D60322AC');
        $this->addSql('ALTER TABLE visits DROP FOREIGN KEY FK_444839EA6B899279');
        $this->addSql('ALTER TABLE visits DROP FOREIGN KEY FK_444839EA87F4FB17');
        $this->addSql('ALTER TABLE visits DROP FOREIGN KEY FK_444839EA3B5A08D7');
        $this->addSql('DROP TABLE doctors');
        $this->addSql('DROP TABLE drugs');
        $this->addSql('DROP TABLE medications');
        $this->addSql('DROP TABLE opinions');
        $this->addSql('DROP TABLE patients');
        $this->addSql('DROP TABLE prescription');
        $this->addSql('DROP TABLE specialities');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE visits');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
