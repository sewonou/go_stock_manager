<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230829131935 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE entry_inventory (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', reference VARCHAR(70) DEFAULT NULL, INDEX IDX_C944C474F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entry_inventory_line (id INT AUTO_INCREMENT NOT NULL, inventory_id INT DEFAULT NULL, product_id INT DEFAULT NULL, qte INT DEFAULT NULL, INDEX IDX_14E7B2A89EEA759 (inventory_id), INDEX IDX_14E7B2A84584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, supplier_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(65) DEFAULT NULL, reference VARCHAR(70) DEFAULT NULL, INDEX IDX_F52993982ADD6D8C (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_line (id INT AUTO_INCREMENT NOT NULL, purchase_id INT DEFAULT NULL, product_id INT DEFAULT NULL, qte INT DEFAULT NULL, purchase_price INT DEFAULT NULL, INDEX IDX_9CE58EE1558FBEB9 (purchase_id), INDEX IDX_9CE58EE14584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE out_inventory (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', reference VARCHAR(70) DEFAULT NULL, INDEX IDX_CBDE1D21F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE out_inventory_line (id INT AUTO_INCREMENT NOT NULL, inventory_id INT DEFAULT NULL, product_id INT DEFAULT NULL, qte INT DEFAULT NULL, INDEX IDX_7DFA5BA49EEA759 (inventory_id), INDEX IDX_7DFA5BA44584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entry_inventory ADD CONSTRAINT FK_C944C474F675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE entry_inventory_line ADD CONSTRAINT FK_14E7B2A89EEA759 FOREIGN KEY (inventory_id) REFERENCES entry_inventory (id)');
        $this->addSql('ALTER TABLE entry_inventory_line ADD CONSTRAINT FK_14E7B2A84584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993982ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE1558FBEB9 FOREIGN KEY (purchase_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE14584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE out_inventory ADD CONSTRAINT FK_CBDE1D21F675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE out_inventory_line ADD CONSTRAINT FK_7DFA5BA49EEA759 FOREIGN KEY (inventory_id) REFERENCES out_inventory (id)');
        $this->addSql('ALTER TABLE out_inventory_line ADD CONSTRAINT FK_7DFA5BA44584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entry_inventory DROP FOREIGN KEY FK_C944C474F675F31B');
        $this->addSql('ALTER TABLE entry_inventory_line DROP FOREIGN KEY FK_14E7B2A89EEA759');
        $this->addSql('ALTER TABLE entry_inventory_line DROP FOREIGN KEY FK_14E7B2A84584665A');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993982ADD6D8C');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE1558FBEB9');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE14584665A');
        $this->addSql('ALTER TABLE out_inventory DROP FOREIGN KEY FK_CBDE1D21F675F31B');
        $this->addSql('ALTER TABLE out_inventory_line DROP FOREIGN KEY FK_7DFA5BA49EEA759');
        $this->addSql('ALTER TABLE out_inventory_line DROP FOREIGN KEY FK_7DFA5BA44584665A');
        $this->addSql('DROP TABLE entry_inventory');
        $this->addSql('DROP TABLE entry_inventory_line');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_line');
        $this->addSql('DROP TABLE out_inventory');
        $this->addSql('DROP TABLE out_inventory_line');
    }
}
