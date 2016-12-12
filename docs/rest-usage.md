Rest GET API usage
================
* [List of Employees](#employees)
  * [List of Employees by name](#employees-by-name)
  * [Employee by ID](#employee-by-id)
  * [Filtering employees list](#query-parameters-for-filtering)
* [List of Research Projects](#research-projects)
* [List of Research Teams](#research-teams)
* [List of Directorates](#directorates)
* [List of Services](#section-/-services)
* [Filtering parameters](#query-parameters-for-filtering)
  * [Active parameter](#active-parameter)
  * [Unique AD identifier parameter](#samaccountname(s)-parameter)
  * [Identifier(s) parameter](#identifier(s)-parameter)
  * [Directorate(s) identifiers parameter](#directorate(s)-identifiers-parameter)

You can easily retrieve the information stored in Galileo Extension ([Employees](#employees), Research Teams, [Research Projects](#research-projects), Departments and the relationships with each other) by using the Rest GET API.
The format retrieved by default (and currently the only one) is JSON.
The following examples demonstrate the different possible uses:

## Employees

To get the list of employees who are still in activity type the following url:
[https://your-site.com/rest/people](https://your-site.com/rest/people)

To get the whole list of employees - active and non active type the following url:
[https://your-site.com/rest/people?active=all](https://your-site.com/rest/people?active=all)

To get the list of employees who are not in activity anymore type the following url:
[https://your-site.com/rest/people?active=false](https://your-site.com/rest/people?active=false)

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

There's a possibility to retrieve a precise employee by its identifier in the database.

For instance, this url: [https://your-site.com/rest/people/119](https://your-site.com/rest/people/119) will retrieve the user with id 119:
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
        }]
}
```

## Research projects
To get the list of projects who are still in activity type the following url:
[https://your-site.com/rest/projects](https://your-site.com/rest/projects)

To get the whole list of projects - active and non active type the following url:
[https://your-site.com/rest/projects?active=all](https://your-site.com/rest/projects?active=all)

To get the list of projects who are not in activity anymore type the following url:
[https://your-site.com/rest/projects?active=false](https://your-site.com/rest/projects?active=false)

Getting research projects follow the same logic as getting employees... So please refer to the [Employees](#employees) section and replace the parameter _**people**_ by _**projects**_.

## Research teams
To get the list of teams who are still in activity type the following url:
[https://your-site.com/rest/teams](https://your-site.com/rest/teams)

To get the whole list of teams - active and non active type the following url:
[https://your-site.com/rest/teams?active=all](https://your-site.com/rest/teams?active=all)

To get the list of teams who are not in activity anymore type the following url:
[https://your-site.com/rest/teams?active=false](https://your-site.com/rest/teams?active=false)

Getting research teams follow the same logic as getting employees... So please refer to the [Employees](#employees) section and replace the parameter _**people**_ by _**teams**_.

## Directorates
To get the list of directorates who are still in activity type the following url:
[https://your-site.com/rest/directorates](https://your-site.com/rest/directorates)

To get the whole list of directorates - active and non active type the following url:
[https://your-site.com/rest/directorates?active=all](https://your-site.com/rest/directorates?active=all)

To get the list of directorates who are not in activity anymore type the following url:
[https://your-site.com/rest/directorates?active=false](https://your-site.com/rest/directorates?active=false)

Getting research directorates follow the same logic as getting employees... So please refer to the [Employees](#employees) section and replace the parameter _**people**_ by _**directorates**_.

## Section / Services
To get the list of services who are still in activity type the following url:
[https://your-site.com/rest/services](https://your-site.com/rest/services)

To get the whole list of services - active and non active type the following url:
[https://your-site.com/rest/services?active=all](https://your-site.com/rest/services?active=all)

To get the list of services who are not in activity anymore type the following url:
[https://your-site.com/rest/services?active=false](https://your-site.com/rest/services?active=false)

Getting research services follow the same logic as getting employees... So please refer to the [Employees](#employees) section and replace the parameter _**people**_ by _**services**_.

## Query parameters for filtering
A series of parameters can help filtering the list of entries ([Employee(s)](#employees), Research Teams, [Research Projects](#research-projects),...) retrieved by one of the previous method/url.
#### Active parameter
As presented at the beginning of the documentation, by default, the list of entries retrieved concern only the ones which are still in activity. 

The parameter _active_ can receive one value amongst multiple options for the same purpose:
*  _false_, _0_, _inactive_ or _no_ can be used to retrieve entries which are no more in activity
*  _all_ or _-1_ can be used to retrieve all the entries, still in activity or not
* All other value for this parameter is considered as a wish to retrieve only the entries still in activity

#### Samaccountname(s) parameter
The samaccountname parameter concerns only the Employees. 
It offers a possibility to filter on the unique identifier of the employee in the Active Directory.
Multiple entries have to be separated by a comma.
For instance, this url: [https://your-site.com/rest/people?samaccountname=Jadams,Sbrakus](https://your-site.com/rest/people?samaccountname=Jadams,Sbrakus) retrieves two Employees having respectively the samaccountname fields set to Jadams and Sbrakus:
```
{
    "people":[
        {
            "id":111,
            "samaccountname":"Jadams",
            "first_name":"Judge",
            "last_name":"Adams",
            "email":"nicholas06@hotmail.com",
            "active":"active"
        },
        {
            "id":156,
            "samaccountname":"Sbrakus",
            "first_name":"Sandrine",
            "last_name":"Brakus",
            "email":"cconsidine@hotmail.com",
            "active":"active"
        }]
}
```
#### Identifier(s) parameter


#### Directorates identifiers parameter
