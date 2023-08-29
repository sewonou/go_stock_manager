<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230819150021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sale (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, reference VARCHAR(25) DEFAULT NULL, sale_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(50) DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', client_name VARCHAR(255) DEFAULT NULL, INDEX IDX_E54BC005F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sale_line (id INT AUTO_INCREMENT NOT NULL, sale_id INT DEFAULT NULL, product_id INT DEFAULT NULL, INDEX IDX_6D5AC0134A7E4868 (sale_id), INDEX IDX_6D5AC0134584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sale ADD CONSTRAINT FK_E54BC005F675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE sale_line ADD CONSTRAINT FK_6D5AC0134A7E4868 FOREIGN KEY (sale_id) REFERENCES sale (id)');
        $this->addSql('ALTER TABLE sale_line ADD CONSTRAINT FK_6D5AC0134584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sale DROP FOREIGN KEY FK_E54BC005F675F31B');
        $this->addSql('ALTER TABLE sale_line DROP FOREIGN KEY FK_6D5AC0134A7E4868');
        $this->addSql('ALTER TABLE sale_line DROP FOREIGN KEY FK_6D5AC0134584665A');
        $this->addSql('DROP TABLE sale');
        $this->addSql('DROP TABLE sale_line');
    }
}
