create trigger teams_international_naming_cascade
before insert or
        update of international_name, international_description, international_name_language, international_cascade
on teams
for each row
execute procedure trigger_international_naming_cascade();

create trigger projects_international_naming_cascade
before insert or
        update of international_name, international_description, international_name_language, international_cascade
on projects
for each row
execute procedure trigger_international_naming_cascade();
