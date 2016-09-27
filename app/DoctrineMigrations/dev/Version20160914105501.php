<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160914105501 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE teams 
                        ADD CONSTRAINT teams_international_name_language_list 
                        CHECK (international_name_language IN (\'en\',\'fr\',\'nl\'))'
        );
        $this->addSql('ALTER TABLE teams 
                        ADD CONSTRAINT teams_start_date 
                        CHECK (CASE WHEN end_date IS NOT NULL THEN start_date IS NOT NULL OR start_date <= end_date END)'
        );
        $this->addSql('ALTER TABLE teams 
                        ADD CONSTRAINT teams_end_date 
                        CHECK (CASE WHEN start_date IS NULL THEN end_date IS NULL ELSE end_date IS NULL OR end_date >= start_date END)'
        );

        $this->addSql('ALTER TABLE person_entry 
                        ADD CONSTRAINT person_entry_entry_date 
                        CHECK (CASE WHEN exit_date IS NOT NULL THEN entry_date IS NOT NULL OR entry_date <= exit_date END)'
        );

        $this->addSql('ALTER TABLE person_entry
                        ADD CONSTRAINT person_entry_exit_date 
                        CHECK (CASE WHEN entry_date IS NULL THEN exit_date IS NULL ELSE exit_date IS NULL OR exit_date >= entry_date END)'
        );

        $this->addSql('ALTER TABLE projects 
                        ADD CONSTRAINT projects_international_name_language_list 
                        CHECK (international_name_language IN (\'en\',\'fr\',\'nl\'))'
        );
        $this->addSql('ALTER TABLE projects 
                        ADD CONSTRAINT projects_start_date 
                        CHECK (CASE WHEN end_date IS NOT NULL THEN start_date IS NOT NULL OR start_date <= end_date END)'
        );
        $this->addSql('ALTER TABLE projects 
                        ADD CONSTRAINT projects_end_date 
                        CHECK (CASE WHEN start_date IS NULL THEN end_date IS NULL ELSE end_date IS NULL OR end_date >= start_date END)'
        );
        $this->addSql('ALTER TABLE departments_projects 
                        ADD CONSTRAINT departments_projects_start_date 
                        CHECK (CASE WHEN end_date IS NOT NULL THEN start_date IS NOT NULL OR start_date <= end_date END)'
        );
        $this->addSql('ALTER TABLE departments_projects 
                        ADD CONSTRAINT departments_projects_end_date 
                        CHECK (CASE WHEN start_date IS NULL THEN end_date IS NULL ELSE end_date IS NULL OR end_date >= start_date END)'
        );
        $this->addSql('ALTER TABLE departments_teams 
                        ADD CONSTRAINT departments_teams_start_date 
                        CHECK (CASE WHEN end_date IS NOT NULL THEN start_date IS NOT NULL OR start_date <= end_date END)'
        );
        $this->addSql('ALTER TABLE departments_teams 
                        ADD CONSTRAINT departments_teams_end_date 
                        CHECK (CASE WHEN start_date IS NULL THEN end_date IS NULL ELSE end_date IS NULL OR end_date >= start_date END)'
        );
        $this->addSql('ALTER TABLE projects_members 
                        ADD CONSTRAINT projects_members_start_date 
                        CHECK (CASE WHEN end_date IS NOT NULL THEN start_date IS NOT NULL OR start_date <= end_date END)'
        );
        $this->addSql('ALTER TABLE projects_members 
                        ADD CONSTRAINT projects_members_end_date 
                        CHECK (CASE WHEN start_date IS NULL THEN end_date IS NULL ELSE end_date IS NULL OR end_date >= start_date END)'
        );
        $this->addSql('ALTER TABLE teams_members 
                        ADD CONSTRAINT teams_members_start_date 
                        CHECK (CASE WHEN end_date IS NOT NULL THEN start_date IS NOT NULL OR start_date <= end_date END)'
        );
        $this->addSql('ALTER TABLE teams_members 
                        ADD CONSTRAINT teams_members_end_date 
                        CHECK (CASE WHEN start_date IS NULL THEN end_date IS NULL ELSE end_date IS NULL OR end_date >= start_date END)'
        );
        $this->addSql('ALTER TABLE teams_projects 
                        ADD CONSTRAINT teams_projects_start_date 
                        CHECK (CASE WHEN end_date IS NOT NULL THEN start_date IS NOT NULL OR start_date <= end_date END)'
        );
        $this->addSql('ALTER TABLE teams_projects 
                        ADD CONSTRAINT teams_projects_end_date 
                        CHECK (CASE WHEN start_date IS NULL THEN end_date IS NULL ELSE end_date IS NULL OR end_date >= start_date END)'
        );
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('ALTER TABLE teams 
                        DROP CONSTRAINT IF EXISTS teams_international_name_language_list'
        );
        $this->addSql('ALTER TABLE teams 
                        DROP CONSTRAINT IF EXISTS teams_start_date'
        );
        $this->addSql('ALTER TABLE teams 
                        DROP CONSTRAINT IF EXISTS teams_end_date'
        );
        $this->addSql('ALTER TABLE projects 
                        DROP CONSTRAINT IF EXISTS projects_international_name_language_list'
        );
        $this->addSql('ALTER TABLE projects 
                        DROP CONSTRAINT IF EXISTS projects_start_date'
        );
        $this->addSql('ALTER TABLE projects 
                        DROP CONSTRAINT IF EXISTS projects_end_date'
        );
        $this->addSql('ALTER TABLE departments_projects 
                        DROP CONSTRAINT IF EXISTS departments_projects_start_date'
        );
        $this->addSql('ALTER TABLE departments_projects 
                        DROP CONSTRAINT IF EXISTS departments_projects_end_date'
        );
        $this->addSql('ALTER TABLE departments_teams 
                        DROP CONSTRAINT IF EXISTS departments_teams_start_date'
        );
        $this->addSql('ALTER TABLE departments_teams 
                        DROP CONSTRAINT IF EXISTS departments_teams_end_date'
        );
        $this->addSql('ALTER TABLE projects_members 
                        DROP CONSTRAINT IF EXISTS projects_members_start_date'
        );
        $this->addSql('ALTER TABLE projects_members 
                        DROP CONSTRAINT IF EXISTS projects_members_end_date'
        );
        $this->addSql('ALTER TABLE teams_members 
                        DROP CONSTRAINT IF EXISTS teams_members_start_date'
        );
        $this->addSql('ALTER TABLE teams_members 
                        DROP CONSTRAINT IF EXISTS teams_members_end_date'
        );
        $this->addSql('ALTER TABLE teams_projects 
                        DROP CONSTRAINT IF EXISTS teams_projects_start_date'
        );
        $this->addSql('ALTER TABLE teams_projects 
                        DROP CONSTRAINT IF EXISTS teams_projects_end_date'
        );
    }
}
