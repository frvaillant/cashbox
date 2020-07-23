<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200722090723 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cash_count (id INT AUTO_INCREMENT NOT NULL, payment_mode_id INT NOT NULL, created_at DATETIME NOT NULL, amount DOUBLE PRECISION NOT NULL, INDEX IDX_B6E7DF4E6EAC8BA0 (payment_mode_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cash_fund (id INT AUTO_INCREMENT NOT NULL, amount DOUBLE PRECISION NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_mode (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, identifier VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_D34A04AD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase (id INT AUTO_INCREMENT NOT NULL, payment_mode_id INT NOT NULL, created_at DATETIME NOT NULL, total_amount DOUBLE PRECISION NOT NULL, INDEX IDX_6117D13B6EAC8BA0 (payment_mode_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase_unity (id INT AUTO_INCREMENT NOT NULL, purchase_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, product_price DOUBLE PRECISION NOT NULL, INDEX IDX_DDAE1E7D558FBEB9 (purchase_id), INDEX IDX_DDAE1E7D4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cash_count ADD CONSTRAINT FK_B6E7DF4E6EAC8BA0 FOREIGN KEY (payment_mode_id) REFERENCES payment_mode (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B6EAC8BA0 FOREIGN KEY (payment_mode_id) REFERENCES payment_mode (id)');
        $this->addSql('ALTER TABLE purchase_unity ADD CONSTRAINT FK_DDAE1E7D558FBEB9 FOREIGN KEY (purchase_id) REFERENCES purchase (id)');
        $this->addSql('ALTER TABLE purchase_unity ADD CONSTRAINT FK_DDAE1E7D4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE cash_count DROP FOREIGN KEY FK_B6E7DF4E6EAC8BA0');
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13B6EAC8BA0');
        $this->addSql('ALTER TABLE purchase_unity DROP FOREIGN KEY FK_DDAE1E7D4584665A');
        $this->addSql('ALTER TABLE purchase_unity DROP FOREIGN KEY FK_DDAE1E7D558FBEB9');
        $this->addSql('DROP TABLE cash_count');
        $this->addSql('DROP TABLE cash_fund');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE payment_mode');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE purchase');
        $this->addSql('DROP TABLE purchase_unity');
    }
}
