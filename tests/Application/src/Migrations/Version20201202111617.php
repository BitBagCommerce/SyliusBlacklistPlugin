<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201202111617 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bitbag_automatic_blacklisting_configuration (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE automatic_blacklisting_configuration_channel (automatic_blacklisting_configuration_id INT NOT NULL, channel_id INT NOT NULL, INDEX IDX_EB48A61142145D53 (automatic_blacklisting_configuration_id), INDEX IDX_EB48A61172F5A1AA (channel_id), PRIMARY KEY(automatic_blacklisting_configuration_id, channel_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_automatic_blacklisting_rule (id INT AUTO_INCREMENT NOT NULL, configuration_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, settings LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_1881023273F32DD8 (configuration_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_blacklisting_rule (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, attributes LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', permitted_strikes INT NOT NULL, enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blacklisting_rule_channel (blacklisting_rule_id INT NOT NULL, channel_id INT NOT NULL, INDEX IDX_13115922968538BF (blacklisting_rule_id), INDEX IDX_1311592272F5A1AA (channel_id), PRIMARY KEY(blacklisting_rule_id, channel_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blacklisting_rule_customer_group (blacklisting_rule_id INT NOT NULL, customer_group_id INT NOT NULL, INDEX IDX_C82ADBCA968538BF (blacklisting_rule_id), INDEX IDX_C82ADBCAD2919A68 (customer_group_id), PRIMARY KEY(blacklisting_rule_id, customer_group_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_fraud_suspicion (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, customer_id INT NOT NULL, company VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone_number VARCHAR(255) DEFAULT NULL, city VARCHAR(255) NOT NULL, province VARCHAR(255) DEFAULT NULL, country VARCHAR(255) NOT NULL, postcode VARCHAR(255) DEFAULT NULL, customer_ip VARCHAR(255) DEFAULT NULL, address_type VARCHAR(255) NOT NULL, comment VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_7B5CF7C08D9F6D38 (order_id), INDEX IDX_7B5CF7C09395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE automatic_blacklisting_configuration_channel ADD CONSTRAINT FK_EB48A61142145D53 FOREIGN KEY (automatic_blacklisting_configuration_id) REFERENCES bitbag_automatic_blacklisting_configuration (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE automatic_blacklisting_configuration_channel ADD CONSTRAINT FK_EB48A61172F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_automatic_blacklisting_rule ADD CONSTRAINT FK_1881023273F32DD8 FOREIGN KEY (configuration_id) REFERENCES bitbag_automatic_blacklisting_configuration (id)');
        $this->addSql('ALTER TABLE blacklisting_rule_channel ADD CONSTRAINT FK_13115922968538BF FOREIGN KEY (blacklisting_rule_id) REFERENCES bitbag_blacklisting_rule (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blacklisting_rule_channel ADD CONSTRAINT FK_1311592272F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blacklisting_rule_customer_group ADD CONSTRAINT FK_C82ADBCA968538BF FOREIGN KEY (blacklisting_rule_id) REFERENCES bitbag_blacklisting_rule (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blacklisting_rule_customer_group ADD CONSTRAINT FK_C82ADBCAD2919A68 FOREIGN KEY (customer_group_id) REFERENCES sylius_customer_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_fraud_suspicion ADD CONSTRAINT FK_7B5CF7C08D9F6D38 FOREIGN KEY (order_id) REFERENCES sylius_order (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE bitbag_fraud_suspicion ADD CONSTRAINT FK_7B5CF7C09395C3F3 FOREIGN KEY (customer_id) REFERENCES sylius_customer (id)');
        $this->addSql('ALTER TABLE sylius_customer ADD COLUMN fraud_status VARCHAR(255) DEFAULT \'neutral\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE automatic_blacklisting_configuration_channel DROP FOREIGN KEY FK_EB48A61142145D53');
        $this->addSql('ALTER TABLE bitbag_automatic_blacklisting_rule DROP FOREIGN KEY FK_1881023273F32DD8');
        $this->addSql('ALTER TABLE blacklisting_rule_channel DROP FOREIGN KEY FK_13115922968538BF');
        $this->addSql('ALTER TABLE blacklisting_rule_customer_group DROP FOREIGN KEY FK_C82ADBCA968538BF');
        $this->addSql('DROP TABLE bitbag_automatic_blacklisting_configuration');
        $this->addSql('DROP TABLE automatic_blacklisting_configuration_channel');
        $this->addSql('DROP TABLE bitbag_automatic_blacklisting_rule');
        $this->addSql('DROP TABLE bitbag_blacklisting_rule');
        $this->addSql('DROP TABLE blacklisting_rule_channel');
        $this->addSql('DROP TABLE blacklisting_rule_customer_group');
        $this->addSql('DROP TABLE bitbag_fraud_suspicion');
    }
}
