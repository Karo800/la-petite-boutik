<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250520083821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, subject LONGTEXT NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, order_number VARCHAR(255) NOT NULL, rising VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', sent_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', deliverd_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', state VARCHAR(255) NOT NULL, INDEX IDX_E52FFDEEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE orders_details (id INT AUTO_INCREMENT NOT NULL, orders_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, price NUMERIC(10, 2) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_835379F1CFFE9AD6 (orders_id), INDEX IDX_835379F14584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, reference VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, color VARCHAR(255) NOT NULL, size VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, stock INT NOT NULL, price DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_D34A04AD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT '(DC2Type:json)', password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, zipcode VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE orders_details ADD CONSTRAINT FK_835379F1CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES orders (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE orders_details ADD CONSTRAINT FK_835379F14584665A FOREIGN KEY (product_id) REFERENCES product (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE orders_details DROP FOREIGN KEY FK_835379F1CFFE9AD6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE orders_details DROP FOREIGN KEY FK_835379F14584665A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE category
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE contact
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE orders
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE orders_details
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE product
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
    }
}
