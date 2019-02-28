<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190228134128 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE reseaux_sociaux (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, apname VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE reseauxsociaux');
        $this->addSql('ALTER TABLE user ADD surname VARCHAR(255) NOT NULL, DROP lastname, DROP firstname, DROP phone, CHANGE email email VARCHAR(255) NOT NULL, CHANGE token username VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE reseauxsociaux (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, apname VARCHAR(30) NOT NULL COLLATE utf8_general_ci, password VARCHAR(255) NOT NULL COLLATE utf8_general_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE reseaux_sociaux');
        $this->addSql('ALTER TABLE user ADD lastname VARCHAR(40) NOT NULL COLLATE utf8_general_ci, ADD firstname VARCHAR(40) NOT NULL COLLATE utf8_general_ci, ADD phone VARCHAR(100) NOT NULL COLLATE utf8_general_ci, ADD token VARCHAR(255) NOT NULL COLLATE utf8_general_ci, DROP username, DROP surname, CHANGE email email VARCHAR(120) NOT NULL COLLATE utf8_general_ci');
    }
}
