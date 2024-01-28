<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231219101755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE emoji (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emoji_property (emoji_id INT NOT NULL, property_id INT NOT NULL, INDEX IDX_166E7DCCE2462A5B (emoji_id), INDEX IDX_166E7DCC549213EC (property_id), PRIMARY KEY(emoji_id, property_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE emoji_property ADD CONSTRAINT FK_166E7DCCE2462A5B FOREIGN KEY (emoji_id) REFERENCES emoji (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE emoji_property ADD CONSTRAINT FK_166E7DCC549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE emoji_property DROP FOREIGN KEY FK_166E7DCCE2462A5B');
        $this->addSql('ALTER TABLE emoji_property DROP FOREIGN KEY FK_166E7DCC549213EC');
        $this->addSql('DROP TABLE emoji');
        $this->addSql('DROP TABLE emoji_property');
    }
}
