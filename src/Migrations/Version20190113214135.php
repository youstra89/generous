<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190113214135 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mosquee DROP begining_at, DROP ending_at, DROP delivered_at, CHANGE hauteur date VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE puit ADD date VARCHAR(255) NOT NULL, DROP begining_at, DROP ending_at, DROP delivered_at');
        $this->addSql('ALTER TABLE user CHANGE donnateur donnateur TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mosquee ADD begining_at DATE DEFAULT NULL, ADD ending_at DATE DEFAULT NULL, ADD delivered_at DATE DEFAULT NULL, CHANGE date hauteur VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE puit ADD begining_at DATE DEFAULT NULL, ADD ending_at DATE DEFAULT NULL, ADD delivered_at DATE DEFAULT NULL, DROP date');
        $this->addSql('ALTER TABLE user CHANGE donnateur donnateur TINYINT(1) DEFAULT NULL');
    }
}
