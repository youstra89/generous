<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190109180426 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mosquee CHANGE begining_at begining_at DATE DEFAULT NULL, CHANGE ending_at ending_at DATE DEFAULT NULL, CHANGE delivered_at delivered_at DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE puit CHANGE begining_at begining_at DATE DEFAULT NULL, CHANGE ending_at ending_at DATE DEFAULT NULL, CHANGE delivered_at delivered_at DATE DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mosquee CHANGE begining_at begining_at DATETIME DEFAULT NULL, CHANGE ending_at ending_at DATETIME DEFAULT NULL, CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE puit CHANGE begining_at begining_at DATETIME DEFAULT NULL, CHANGE ending_at ending_at DATETIME DEFAULT NULL, CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');
    }
}
