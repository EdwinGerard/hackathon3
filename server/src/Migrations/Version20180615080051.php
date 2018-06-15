<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180615080051 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE like_works (like_id INT NOT NULL, works_id INT NOT NULL, INDEX IDX_41812BA4859BFA32 (like_id), INDEX IDX_41812BA4F6CB822A (works_id), PRIMARY KEY(like_id, works_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE like_works ADD CONSTRAINT FK_41812BA4859BFA32 FOREIGN KEY (like_id) REFERENCES `like` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE like_works ADD CONSTRAINT FK_41812BA4F6CB822A FOREIGN KEY (works_id) REFERENCES works (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3F6CB822A');
        $this->addSql('DROP INDEX IDX_AC6340B3F6CB822A ON `like`');
        $this->addSql('ALTER TABLE `like` DROP works_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE like_works');
        $this->addSql('ALTER TABLE `like` ADD works_id INT NOT NULL');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3F6CB822A FOREIGN KEY (works_id) REFERENCES works (id)');
        $this->addSql('CREATE INDEX IDX_AC6340B3F6CB822A ON `like` (works_id)');
    }
}
