Rest GET API usage
================
* [List of Employees](#employees)
> * [List of Employees by name](#employees-by-name)
> * [Employee by id](#employees-by-id)

You can easily retrieve the information stored in Galileo Extension (Employees, Research Teams, Research Projects, Departments and the relationships with each other) by using the Rest GET API.
The following examples demonstrate the different possible uses:

## Employees

To get the list of employees who are still in activity type the following url:
[https://your-site.com/rest/people](https://your-site.com/rest/people)

To get the whole list of employees - active and non active type the following url
[https://your-site.com/rest/people?active=all](https://your-site.com/rest/people?active=all)

To get the list of employees who are not in activity anymore type the following url:
[https://your-site.com/rest/people?active=false](https://your-site.com/rest/people?active=false)

The parameter _active_ can receive multiple options for the same purpose:
*  _false_, _0_, _inactive_ and _no_ can be used to retrieve employees who are no more in activity
*  _all_ and _-1_ can be used to retrieve all the employees, still in activity or not
* All other value for this parameter is considered as a wish to retrieve only the employees still in activity

### Employees by Name

There's a possibility to retrieve the list of employees by a sub string present in the combination _first name_ and _last name_.
For instance we have a Arianna (_first name_) Acrona (_last name_) in the database. Typing this url will retrieve it...:
[https://your-site.com/rest/people/ari](https://your-site.com/rest/people/ari)
... but will also retrieve any entries where the _first name_ or the _last name_ contains _**ari**_:
```
{
    "people":[
        {
            "id":119,
            "samaccountname":"Acrona",
            "first_name":"Arianna",
            "last_name":"Crona",
            "email":"moen.kamryn@yahoo.com",
            "active":"active"
        },
        {
            "id":198,
            "samaccountname":"Amcclure",
            "first_name":"Ariane",
            "last_name":"McClure",
            "email":"rhiannon70@murphy.biz",
            "active":"active"
        }]
}
```
### Employee by ID


