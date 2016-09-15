create or replace function trigger_department_path_composition() returns trigger as
$$
    begin
        if new.parent_ref is not null then
            select parent_dept.path || parent_dept.id || '/' into new.path from department parent_dept where parent_dept.id = new.parent_ref;
        end if;
        return new;
    end;
$$
language plpgsql;
