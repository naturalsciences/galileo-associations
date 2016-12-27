<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160912160605 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE teams_members (id SERIAL NOT NULL, person_ref INT NOT NULL, team_ref INT NOT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_ED6F9E4B9722F9B8 ON teams_members (person_ref)');
        $this->addSql('CREATE INDEX IDX_ED6F9E4B4EFCB407 ON teams_members (team_ref)');
        $this->addSql('COMMENT ON COLUMN teams_members.start_date IS \'Entry date of the person in the team\'');
        $this->addSql('COMMENT ON COLUMN teams_members.end_date IS \'Exit date of the person in the team\'');
        $this->addSql('COMMENT ON COLUMN teams_members.comment IS \'Comment\'');
        $this->addSql('CREATE TABLE working_duty (id SERIAL NOT NULL, person_ref INT NOT NULL, department_ref INT NOT NULL, percentage INT DEFAULT 100 NOT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FBCAD2639722F9B8 ON working_duty (person_ref)');
        $this->addSql('CREATE INDEX IDX_FBCAD26369791980 ON working_duty (department_ref)');
        $this->addSql('COMMENT ON COLUMN working_duty.percentage IS \'Duty percentage of the person in this department\'');
        $this->addSql('COMMENT ON COLUMN working_duty.start_date IS \'Start date of person in this department\'');
        $this->addSql('COMMENT ON COLUMN working_duty.end_date IS \'End date of person in this department\'');
        $this->addSql('COMMENT ON COLUMN working_duty.comment IS \'Associated description of this duty\'');
        $this->addSql('CREATE TABLE teams (id SERIAL NOT NULL, international_name VARCHAR(255) NOT NULL, international_description TEXT DEFAULT NULL, international_name_language VARCHAR(255) DEFAULT \'en\' NOT NULL, international_cascade SMALLINT DEFAULT 0 NOT NULL, name_en VARCHAR(255) DEFAULT NULL, description_en TEXT DEFAULT NULL, name_fr VARCHAR(255) DEFAULT NULL, description_fr TEXT DEFAULT NULL, name_nl VARCHAR(255) DEFAULT NULL, description_nl TEXT DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX unq_team_international_name ON teams (international_name)');
        $this->addSql('COMMENT ON COLUMN teams.international_name IS \'The name to be used internationaly\'');
        $this->addSql('COMMENT ON COLUMN teams.international_description IS \'Description of the team associated to the international language selected\'');
        $this->addSql('COMMENT ON COLUMN teams.international_name_language IS \'The language associated to the international name\'');
        $this->addSql('COMMENT ON COLUMN teams.international_cascade IS \'Tells if the international name and description have to be used for: None of the translated versions (0), the corresponding language translated version (1) or the translated versions (2)\'');
        $this->addSql('COMMENT ON COLUMN teams.name_en IS \'Translated name in English\'');
        $this->addSql('COMMENT ON COLUMN teams.description_en IS \'Description of the team in English\'');
        $this->addSql('COMMENT ON COLUMN teams.name_fr IS \'Translated name in French\'');
        $this->addSql('COMMENT ON COLUMN teams.description_fr IS \'Description of the team in French\'');
        $this->addSql('COMMENT ON COLUMN teams.name_nl IS \'Translated name in Dutch\'');
        $this->addSql('COMMENT ON COLUMN teams.description_nl IS \'Description of the team in Dutch\'');
        $this->addSql('COMMENT ON COLUMN teams.start_date IS \'team start date\'');
        $this->addSql('COMMENT ON COLUMN teams.end_date IS \'team end date\'');
        $this->addSql('CREATE TABLE departments_teams (id SERIAL NOT NULL, department_ref INT NOT NULL, team_ref INT NOT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FD62DC69791980 ON departments_teams (department_ref)');
        $this->addSql('CREATE INDEX IDX_FD62DC4EFCB407 ON departments_teams (team_ref)');
        $this->addSql('COMMENT ON COLUMN departments_teams.start_date IS \'Team creation date in the given department\'');
        $this->addSql('COMMENT ON COLUMN departments_teams.end_date IS \'Team end date in the given department\'');
        $this->addSql('COMMENT ON COLUMN departments_teams.comment IS \'Comment\'');
        $this->addSql('CREATE TABLE teams_projects (id SERIAL NOT NULL, team_ref INT NOT NULL, project_ref INT NOT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_90370B7D4EFCB407 ON teams_projects (team_ref)');
        $this->addSql('CREATE INDEX IDX_90370B7D8614E440 ON teams_projects (project_ref)');
        $this->addSql('COMMENT ON COLUMN teams_projects.start_date IS \'Entry date of the team on the project\'');
        $this->addSql('COMMENT ON COLUMN teams_projects.end_date IS \'Exit date of the team on the project\'');
        $this->addSql('COMMENT ON COLUMN teams_projects.comment IS \'Comment\'');
        $this->addSql('CREATE TABLE projects_members (id SERIAL NOT NULL, person_ref INT NOT NULL, project_ref INT NOT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6863C9EE9722F9B8 ON projects_members (person_ref)');
        $this->addSql('CREATE INDEX IDX_6863C9EE8614E440 ON projects_members (project_ref)');
        $this->addSql('COMMENT ON COLUMN projects_members.start_date IS \'Entry date of the person on the project\'');
        $this->addSql('COMMENT ON COLUMN projects_members.end_date IS \'Exit date of the person on the project\'');
        $this->addSql('COMMENT ON COLUMN projects_members.comment IS \'Comment\'');
        $this->addSql('CREATE TABLE person (id SERIAL NOT NULL, first_name TEXT NOT NULL, last_name TEXT NOT NULL, matricule TEXT DEFAULT \'\', uid TEXT DEFAULT NULL, email TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX unq_person_uid ON person (uid)');
        $this->addSql('COMMENT ON COLUMN person.first_name IS \'First name\'');
        $this->addSql('COMMENT ON COLUMN person.last_name IS \'Last name\'');
        $this->addSql('COMMENT ON COLUMN person.matricule IS \'Institution internal identifier (matricule)\'');
        $this->addSql('COMMENT ON COLUMN person.uid IS \'Unique identifier associated from AD (Active Directory)\'');
        $this->addSql('COMMENT ON COLUMN person.email IS \'Person main email\'');
        $this->addSql('CREATE TABLE person_entry (id SERIAL NOT NULL, person_ref INT NOT NULL, entry_date DATE DEFAULT now() NOT NULL , exit_date DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_871782B49722F9B8 ON person_entry (person_ref)');
        $this->addSql('COMMENT ON COLUMN person_entry.entry_date IS \'Entry date of the person\'');
        $this->addSql('COMMENT ON COLUMN person_entry.exit_date IS \'Exit date of the person\'');
        $this->addSql('CREATE TABLE projects (id SERIAL NOT NULL, international_name VARCHAR(255) NOT NULL, international_description TEXT DEFAULT NULL, international_name_language VARCHAR(255) DEFAULT \'en\' NOT NULL, international_cascade SMALLINT DEFAULT 0 NOT NULL, name_en VARCHAR(255) DEFAULT NULL, description_en TEXT DEFAULT NULL, name_fr VARCHAR(255) DEFAULT NULL, description_fr TEXT DEFAULT NULL, name_nl VARCHAR(255) DEFAULT NULL, description_nl TEXT DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX unq_project_international_name ON projects (international_name)');
        $this->addSql('COMMENT ON COLUMN projects.international_name IS \'The name to be used internationaly\'');
        $this->addSql('COMMENT ON COLUMN projects.international_description IS \'Description of the project associated to the international language selected\'');
        $this->addSql('COMMENT ON COLUMN projects.international_name_language IS \'The language associated to the international name\'');
        $this->addSql('COMMENT ON COLUMN projects.international_cascade IS \'Tells if the international name and description have to be used for: None of the translated versions (0), the corresponding language translated version (1) or the translated versions (2)\'');
        $this->addSql('COMMENT ON COLUMN projects.name_en IS \'Translated name in English\'');
        $this->addSql('COMMENT ON COLUMN projects.description_en IS \'Description of the project in English\'');
        $this->addSql('COMMENT ON COLUMN projects.name_fr IS \'Translated name in French\'');
        $this->addSql('COMMENT ON COLUMN projects.description_fr IS \'Description of the project in French\'');
        $this->addSql('COMMENT ON COLUMN projects.name_nl IS \'Translated name in Dutch\'');
        $this->addSql('COMMENT ON COLUMN projects.description_nl IS \'Description of the project in Dutch\'');
        $this->addSql('COMMENT ON COLUMN projects.start_date IS \'Project start date\'');
        $this->addSql('COMMENT ON COLUMN projects.end_date IS \'Project end date\'');
        $this->addSql('CREATE TABLE department (id SERIAL NOT NULL, parent_ref INT DEFAULT NULL, level TEXT NOT NULL, path TEXT DEFAULT \'/\' NOT NULL, code VARCHAR, name_fr TEXT NOT NULL, name_en TEXT NOT NULL, name_nl TEXT NOT NULL, is_active BOOLEAN DEFAULT \'true\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CD1DE18A2FCC5DC6 ON department (parent_ref)');
        $this->addSql('CREATE UNIQUE INDEX unq_department_code ON department (code)');
        $this->addSql('COMMENT ON COLUMN department.level IS \'Level in the hierarchy of organization\'');
        $this->addSql('COMMENT ON COLUMN department.path IS \'Hierarchic path of id in the organization\'');
        $this->addSql('COMMENT ON COLUMN department.code IS \'Unique code given to department/service\'');
        $this->addSql('COMMENT ON COLUMN department.name_fr IS \'Name of department/service in french\'');
        $this->addSql('COMMENT ON COLUMN department.name_en IS \'Name of department/service in english\'');
        $this->addSql('COMMENT ON COLUMN department.name_nl IS \'Name of department/service in dutch\'');
        $this->addSql('COMMENT ON COLUMN department.is_active IS \'Flag telling if the entry is active or not\'');
        $this->addSql('CREATE TABLE ad_sync (id SERIAL NOT NULL, samaccountname TEXT NOT NULL, givenname TEXT NOT NULL, sn TEXT DEFAULT NULL, mail TEXT NOT NULL, othermail TEXT DEFAULT NULL, userprincipalname TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX unq_ad_sync_uid ON ad_sync (samaccountname)');
        $this->addSql('COMMENT ON COLUMN ad_sync.samaccountname IS \'AD samaccountname\'');
        $this->addSql('COMMENT ON COLUMN ad_sync.givenname IS \'User given name in AD\'');
        $this->addSql('COMMENT ON COLUMN ad_sync.mail IS \'Main user mail in AD\'');
        $this->addSql('COMMENT ON COLUMN ad_sync.othermail IS \'Other email address in AD\'');
        $this->addSql('CREATE TABLE departments_projects (id SERIAL NOT NULL, department_ref INT NOT NULL, project_ref INT NOT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FCB0625669791980 ON departments_projects (department_ref)');
        $this->addSql('CREATE INDEX IDX_FCB062568614E440 ON departments_projects (project_ref)');
        $this->addSql('COMMENT ON COLUMN departments_projects.start_date IS \'Project start date in the given department\'');
        $this->addSql('COMMENT ON COLUMN departments_projects.end_date IS \'Project end date in the given department\'');
        $this->addSql('COMMENT ON COLUMN departments_projects.comment IS \'Comment\'');
        $this->addSql('ALTER TABLE teams_members ADD CONSTRAINT FK_ED6F9E4B9722F9B8 FOREIGN KEY (person_ref) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teams_members ADD CONSTRAINT FK_ED6F9E4B4EFCB407 FOREIGN KEY (team_ref) REFERENCES teams (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE working_duty ADD CONSTRAINT FK_FBCAD2639722F9B8 FOREIGN KEY (person_ref) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE working_duty ADD CONSTRAINT FK_FBCAD26369791980 FOREIGN KEY (department_ref) REFERENCES department (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE departments_teams ADD CONSTRAINT FK_FD62DC69791980 FOREIGN KEY (department_ref) REFERENCES department (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE departments_teams ADD CONSTRAINT FK_FD62DC4EFCB407 FOREIGN KEY (team_ref) REFERENCES teams (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teams_projects ADD CONSTRAINT FK_90370B7D4EFCB407 FOREIGN KEY (team_ref) REFERENCES teams (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teams_projects ADD CONSTRAINT FK_90370B7D8614E440 FOREIGN KEY (project_ref) REFERENCES projects (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person_entry ADD CONSTRAINT FK_871782B49722F9B8 FOREIGN KEY (person_ref) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE projects_members ADD CONSTRAINT FK_6863C9EE9722F9B8 FOREIGN KEY (person_ref) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE projects_members ADD CONSTRAINT FK_6863C9EE8614E440 FOREIGN KEY (project_ref) REFERENCES projects (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE department ADD CONSTRAINT FK_CD1DE18A2FCC5DC6 FOREIGN KEY (parent_ref) REFERENCES department (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE departments_projects ADD CONSTRAINT FK_FCB0625669791980 FOREIGN KEY (department_ref) REFERENCES department (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE departments_projects ADD CONSTRAINT FK_FCB062568614E440 FOREIGN KEY (project_ref) REFERENCES projects (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('
            create or replace function trigger_international_naming_cascade() returns trigger as
            $$
                begin
                    if new.international_cascade = 1 then
                        case
                            when lower(new.international_name_language) = \'fr\' then
                                new.name_fr := new.international_name;
                                new.description_fr := new.international_description;
                            when lower(new.international_name_language) = \'nl\' then
                                new.name_nl := new.international_name;
                                new.description_nl := new.international_description;
                            else
                                new.name_en := new.international_name;
                                new.description_en := new.international_description;
                        end case;
                    elsif new.international_cascade = 2 then
                        new.name_en := new.international_name;
                        new.description_en := new.international_description;
                        new.name_fr := new.international_name;
                        new.description_fr := new.international_description;
                        new.name_nl := new.international_name;
                        new.description_nl := new.international_description;
                    end if;
                    return new;
                end;
            $$
            language plpgsql
        ');
        $this->addSql('
            create or replace function trigger_department_path_composition() returns trigger as
            $$
                begin
                    if new.parent_ref is not null then
                        select parent_dept.path || parent_dept.id || \'/\' into new.path from department parent_dept where parent_dept.id = new.parent_ref;
                    end if;
                    return new;
                end;
            $$
            language plpgsql
        ');
        $this->addSql('
            create trigger teams_international_naming_cascade
            before insert or
                    update of international_name, international_description, international_name_language, international_cascade
            on teams
            for each row
            execute procedure trigger_international_naming_cascade()
        ');
        $this->addSql('
            create trigger projects_international_naming_cascade
            before insert or
                    update of international_name, international_description, international_name_language, international_cascade
            on projects
            for each row
            execute procedure trigger_international_naming_cascade()
        ');
        $this->addSql('
            create trigger department_path_composition
            before insert or
                    update of parent_ref
            on department
            for each row
            execute procedure trigger_department_path_composition()
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE teams_members DROP CONSTRAINT FK_ED6F9E4B4EFCB407');
        $this->addSql('ALTER TABLE departments_teams DROP CONSTRAINT FK_FD62DC4EFCB407');
        $this->addSql('ALTER TABLE teams_projects DROP CONSTRAINT FK_90370B7D4EFCB407');
        $this->addSql('ALTER TABLE teams_members DROP CONSTRAINT FK_ED6F9E4B9722F9B8');
        $this->addSql('ALTER TABLE working_duty DROP CONSTRAINT FK_FBCAD2639722F9B8');
        $this->addSql('ALTER TABLE projects_members DROP CONSTRAINT FK_6863C9EE9722F9B8');
        $this->addSql('ALTER TABLE teams_projects DROP CONSTRAINT FK_90370B7D8614E440');
        $this->addSql('ALTER TABLE projects_members DROP CONSTRAINT FK_6863C9EE8614E440');
        $this->addSql('ALTER TABLE departments_projects DROP CONSTRAINT FK_FCB062568614E440');
        $this->addSql('ALTER TABLE working_duty DROP CONSTRAINT FK_FBCAD26369791980');
        $this->addSql('ALTER TABLE departments_teams DROP CONSTRAINT FK_FD62DC69791980');
        $this->addSql('ALTER TABLE department DROP CONSTRAINT FK_CD1DE18A2FCC5DC6');
        $this->addSql('ALTER TABLE departments_projects DROP CONSTRAINT FK_FCB0625669791980');
        $this->addSql('ALTER TABLE person_entry DROP CONSTRAINT FK_871782B49722F9B8');
        $this->addSql('DROP TRIGGER IF EXISTS department_path_composition ON department');
        $this->addSql('DROP TRIGGER IF EXISTS projects_international_naming_cascade ON projects');
        $this->addSql('DROP TRIGGER IF EXISTS teams_international_naming_cascade ON teams');
        $this->addSql('DROP FUNCTION IF EXISTS trigger_international_naming_cascade() CASCADE');
        $this->addSql('DROP FUNCTION IF EXISTS trigger_department_path_composition() CASCADE');
        $this->addSql('DROP TABLE person_entry');
        $this->addSql('DROP TABLE teams_members');
        $this->addSql('DROP TABLE working_duty');
        $this->addSql('DROP TABLE teams');
        $this->addSql('DROP TABLE departments_teams');
        $this->addSql('DROP TABLE teams_projects');
        $this->addSql('DROP TABLE projects_members');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE ad_sync');
        $this->addSql('DROP TABLE departments_projects');
    }
}
