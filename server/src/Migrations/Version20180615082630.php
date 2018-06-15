<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180615082630 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE liked (id INT AUTO_INCREMENT NOT NULL, works_id INT NOT NULL, like_it TINYINT(1) NOT NULL, client_id VARCHAR(255) NOT NULL, INDEX IDX_CA19CBBAF6CB822A (works_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE liked ADD CONSTRAINT FK_CA19CBBAF6CB822A FOREIGN KEY (works_id) REFERENCES works (id)');
        $this->addSql('DROP TABLE `like`');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `like` (id INT AUTO_INCREMENT NOT NULL, works_id INT NOT NULL, like_it TINYINT(1) NOT NULL, client_id VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_AC6340B3F6CB822A (works_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3F6CB822A FOREIGN KEY (works_id) REFERENCES works (id)');
        $this->addSql('DROP TABLE liked');
    }
}
