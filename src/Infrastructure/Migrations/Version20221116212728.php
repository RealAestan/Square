<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221116212728 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'This migrations adds the table api_key';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE api_key_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE api_key (id INT NOT NULL, key VARCHAR(255) NOT NULL, quota INT NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE api_key_id_seq CASCADE');
        $this->addSql('DROP TABLE api_key');
    }
}
