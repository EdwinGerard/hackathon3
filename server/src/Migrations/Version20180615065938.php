<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180615065938 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE author ADD citizen VARCHAR(80) DEFAULT NULL, ADD api_id INT DEFAULT NULL, CHANGE bio description LONGTEXT DEFAULT NULL, CHANGE bio_url description_url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE works ADD author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE works ADD CONSTRAINT FK_F6E50243F675F31B FOREIGN KEY (author_id) REFERENCES author (id)');
        $this->addSql('CREATE INDEX IDX_F6E50243F675F31B ON works (author_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE author DROP citizen, DROP api_id, CHANGE description bio LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE description_url bio_url VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE works DROP FOREIGN KEY FK_F6E50243F675F31B');
        $this->addSql('DROP INDEX IDX_F6E50243F675F31B ON works');
        $this->addSql('ALTER TABLE works DROP author_id');
    }
}
