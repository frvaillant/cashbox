<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200723135720 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cash_count DROP FOREIGN KEY FK_B6E7DF4E6EAC8BA0');
        $this->addSql('DROP INDEX IDX_B6E7DF4E6EAC8BA0 ON cash_count');
        $this->addSql('ALTER TABLE cash_count DROP payment_mode_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cash_count ADD payment_mode_id INT NOT NULL');
        $this->addSql('ALTER TABLE cash_count ADD CONSTRAINT FK_B6E7DF4E6EAC8BA0 FOREIGN KEY (payment_mode_id) REFERENCES payment_mode (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B6E7DF4E6EAC8BA0 ON cash_count (payment_mode_id)');
    }
}
