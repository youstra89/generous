<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190109132007 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE mosquee (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, localisation VARCHAR(255) NOT NULL, cost DOUBLE PRECISION DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, longueur VARCHAR(255) DEFAULT NULL, largeur VARCHAR(255) DEFAULT NULL, hauteur VARCHAR(255) DEFAULT NULL, recipient VARCHAR(255) NOT NULL, begining_at DATETIME DEFAULT NULL, ending_at DATETIME DEFAULT NULL, delivered_at DATETIME DEFAULT NULL, imam_name VARCHAR(255) DEFAULT NULL, imam_phone_number VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_9436B2BCA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE puit (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, localisation VARCHAR(255) NOT NULL, cost DOUBLE PRECISION DEFAULT NULL, depth VARCHAR(255) DEFAULT NULL, recipient VARCHAR(255) NOT NULL, begining_at DATETIME DEFAULT NULL, ending_at DATETIME DEFAULT NULL, delivered_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_FB16B0F0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mosquee ADD CONSTRAINT FK_9436B2BCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE puit ADD CONSTRAINT FK_FB16B0F0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE mosquee');
        $this->addSql('DROP TABLE puit');
    }
}
