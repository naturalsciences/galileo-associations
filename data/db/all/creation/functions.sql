create or replace function trigger_international_naming_cascade() returns trigger as
$$
    begin
        if new.international_cascade = 1 then
            case
                when lower(new.international_name_language) = 'fr' then
                    new.name_fr := new.international_name;
                    new.description_fr := new.international_description;
                when lower(new.international_name_language) = 'nl' then
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
language plpgsql;