<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20170217235253 extends AbstractMigration
{
    private const ONLY_SAFE_FOR_MYSQL = 'Migration can only be executed safely on \'mysql\'.';

    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', self::ONLY_SAFE_FOR_MYSQL);

        $this->addSql('CREATE TABLE gold_price (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', price BIGINT NOT NULL, date DATE NOT NULL, UNIQUE INDEX UNIQ_5AE48BEEAA9E377A (date), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', self::ONLY_SAFE_FOR_MYSQL);

        $this->addSql('DROP TABLE gold_price');
    }
}
