<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240429051628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `product` (id INT AUTO_INCREMENT NOT NULL, sku VARCHAR(30) NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, status TINYINT(1) NOT NULL, stock INT NOT NULL, price DOUBLE PRECISION NOT NULL, special_price DOUBLE PRECISION DEFAULT NULL, special_from DATETIME DEFAULT NULL, special_to DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_D34A04ADF9038C4 (sku), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE `product`');
    }
}
