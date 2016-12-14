<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161207112237 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('ALTER TABLE person ADD COLUMN password varchar DEFAULT \'\' ');
        $this->addSql('UPDATE person SET "password" = \'\'');
        $this->addSql('ALTER TABLE person ADD COLUMN roles json');
        $this->addSql('COMMENT ON COLUMN person.password IS \'User password\'');
        $this->addSql('COMMENT ON COLUMN person.roles IS \'Roles given to the user\'');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('ALTER TABLE person DROP COLUMN IF EXISTS password');
        $this->addSql('ALTER TABLE person DROP COLUMN IF EXISTS roles');
    }
}
