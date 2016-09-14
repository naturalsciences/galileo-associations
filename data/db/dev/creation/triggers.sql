create trigger department_path_composition
before insert or
        update of parent_ref
on department
for each row
execute procedure trigger_department_path_composition();
