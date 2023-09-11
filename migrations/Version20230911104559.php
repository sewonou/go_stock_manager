<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230911104559 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entry_inventory (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', reference VARCHAR(70) DEFAULT NULL, INDEX IDX_C944C474F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entry_inventory_line (id INT AUTO_INCREMENT NOT NULL, inventory_id INT DEFAULT NULL, product_id INT DEFAULT NULL, qte INT DEFAULT NULL, INDEX IDX_14E7B2A89EEA759 (inventory_id), INDEX IDX_14E7B2A84584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, supplier_id INT DEFAULT NULL, author_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(65) DEFAULT NULL, reference VARCHAR(70) DEFAULT NULL, INDEX IDX_F52993982ADD6D8C (supplier_id), INDEX IDX_F5299398F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_line (id INT AUTO_INCREMENT NOT NULL, purchase_id INT DEFAULT NULL, product_id INT DEFAULT NULL, qte INT DEFAULT NULL, purchase_price INT DEFAULT NULL, INDEX IDX_9CE58EE1558FBEB9 (purchase_id), INDEX IDX_9CE58EE14584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE out_inventory (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', reference VARCHAR(70) DEFAULT NULL, INDEX IDX_CBDE1D21F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE out_inventory_line (id INT AUTO_INCREMENT NOT NULL, inventory_id INT DEFAULT NULL, product_id INT DEFAULT NULL, qte INT DEFAULT NULL, INDEX IDX_7DFA5BA49EEA759 (inventory_id), INDEX IDX_7DFA5BA44584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, author_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, brand_name VARCHAR(255) DEFAULT NULL, sale_price INT DEFAULT NULL, unit VARCHAR(255) DEFAULT NULL, min_qte INT DEFAULT NULL, init_qte INT DEFAULT NULL, code_bar VARCHAR(55) DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D34A04AD12469DE2 (category_id), INDEX IDX_D34A04ADF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(45) DEFAULT NULL, display VARCHAR(80) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sale (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, reference VARCHAR(25) DEFAULT NULL, sale_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(50) DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', client_name VARCHAR(255) DEFAULT NULL, INDEX IDX_E54BC005F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sale_line (id INT AUTO_INCREMENT NOT NULL, sale_id INT DEFAULT NULL, product_id INT DEFAULT NULL, qte INT DEFAULT NULL, INDEX IDX_6D5AC0134A7E4868 (sale_id), INDEX IDX_6D5AC0134584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supplier (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, contact VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(25) NOT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, user_role_id INT DEFAULT NULL, username VARCHAR(180) DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, full_name VARCHAR(255) DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, phone VARCHAR(20) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), INDEX IDX_8D93D6498E0E3CA6 (user_role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entry_inventory ADD CONSTRAINT FK_C944C474F675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE entry_inventory_line ADD CONSTRAINT FK_14E7B2A89EEA759 FOREIGN KEY (inventory_id) REFERENCES entry_inventory (id)');
        $this->addSql('ALTER TABLE entry_inventory_line ADD CONSTRAINT FK_14E7B2A84584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993982ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398F675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE1558FBEB9 FOREIGN KEY (purchase_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE14584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE out_inventory ADD CONSTRAINT FK_CBDE1D21F675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE out_inventory_line ADD CONSTRAINT FK_7DFA5BA49EEA759 FOREIGN KEY (inventory_id) REFERENCES out_inventory (id)');
        $this->addSql('ALTER TABLE out_inventory_line ADD CONSTRAINT FK_7DFA5BA44584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADF675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE sale ADD CONSTRAINT FK_E54BC005F675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE sale_line ADD CONSTRAINT FK_6D5AC0134A7E4868 FOREIGN KEY (sale_id) REFERENCES sale (id)');
        $this->addSql('ALTER TABLE sale_line ADD CONSTRAINT FK_6D5AC0134584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6498E0E3CA6 FOREIGN KEY (user_role_id) REFERENCES role (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entry_inventory DROP FOREIGN KEY FK_C944C474F675F31B');
        $this->addSql('ALTER TABLE entry_inventory_line DROP FOREIGN KEY FK_14E7B2A89EEA759');
        $this->addSql('ALTER TABLE entry_inventory_line DROP FOREIGN KEY FK_14E7B2A84584665A');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993982ADD6D8C');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398F675F31B');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE1558FBEB9');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE14584665A');
        $this->addSql('ALTER TABLE out_inventory DROP FOREIGN KEY FK_CBDE1D21F675F31B');
        $this->addSql('ALTER TABLE out_inventory_line DROP FOREIGN KEY FK_7DFA5BA49EEA759');
        $this->addSql('ALTER TABLE out_inventory_line DROP FOREIGN KEY FK_7DFA5BA44584665A');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADF675F31B');
        $this->addSql('ALTER TABLE sale DROP FOREIGN KEY FK_E54BC005F675F31B');
        $this->addSql('ALTER TABLE sale_line DROP FOREIGN KEY FK_6D5AC0134A7E4868');
        $this->addSql('ALTER TABLE sale_line DROP FOREIGN KEY FK_6D5AC0134584665A');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6498E0E3CA6');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE entry_inventory');
        $this->addSql('DROP TABLE entry_inventory_line');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_line');
        $this->addSql('DROP TABLE out_inventory');
        $this->addSql('DROP TABLE out_inventory_line');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE sale');
        $this->addSql('DROP TABLE sale_line');
        $this->addSql('DROP TABLE supplier');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
