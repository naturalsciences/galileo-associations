create or replace function trigger_department_path_composition() returns trigger as
$$
    begin
        if new.parent_ref is not null then
            select parent.path || parent.id || '/' into new.path from department where id = new.parent_ref;
        end if;
        return new;
    end;
$$
language plpgsql;
