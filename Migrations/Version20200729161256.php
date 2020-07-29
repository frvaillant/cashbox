<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200729161256 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql("INSERT INTO `cash_fund` (`id`, `amount`, `updated_at`) VALUES (1, 0, '2020-07-29 16:06:31')");
        $this->addSql("INSERT INTO `payment_mode` (`id`, `name`, `identifier`) VALUES (1, 'Espèces', 'CASH')");
        $this->addSql("INSERT INTO `user` (`id`, `username`, `roles`, `password`, `first_name`, `last_name`) VALUES (1, 'user', '[\"ROLE_USER\"]', '\$argon2id\$v=19\$m=65536,t=4,p=1\$kr1fGDuUkTaysouDg4YkXg\$rB+Fko3bXlHufDMCPBmF4WlI+QywQW4j4VueI0ALDIQ', 'user', 'user')");
        $this->addSql("INSERT INTO `user` (`id`, `username`, `roles`, `password`, `first_name`, `last_name`) VALUES (2, 'admin', '[\"ROLE_ADMIN\"]', '\$argon2id\$v=19\$m=65536,t=4,p=1\$trjUXBflRVh5/bD2AY58+Q\$V+DXdKJKPvBdTnyplahTU3SC8sJM1d2xNziAYOdt28k', 'admin', 'admin')");
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("truncate table `cash_fund`");
        $this->addSql("truncate table `user`");
        $this->addSql("truncate table `payment_mode`");
    }
}
