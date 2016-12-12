Rest GET API usage
================
* [List of Employees](#employees)
  * [List of Employees by name](#employees-by-name)
  * [Employee by ID](#employee-by-id)
  * [Filtering employees list](#query-parameters-for-filtering)
* [List of Research Projects](#research-projects)
* [List of Research Teams](#research-teams)
* [List of Directorates](#directorates)
* [List of Services](#sections--services)
* [Filtering parameters](#query-parameters-for-filtering)
  * [Active parameter](#active-parameter)
  * [Unique AD identifier parameter](#samaccountnames-parameter)
  * [Identifier(s) parameter](#identifiers-parameter)
  * [Directorate(s) identifiers parameter](#directorates-identifiers-parameter)
  * [Service(s) identifiers parameter](#services-identifiers-parameter)
  * [Research projects identifiers parameter](#research-projects-identifiers-parameter)
  * [Research teams identifiers parameter](#research-teams-identifiers-parameter)
  * [Combination of parameters](#combination-of-parameters)
* [No results](#case-of-no-results)

You can easily retrieve the information stored in Galileo Extension ([Employees](#employees), [Research Teams](#research-teams), [Research Projects](#research-projects), [Directorates](#directorates), [Services](#sections--services) and the relationships with each other) by using the Rest GET API.
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

## Sections / Services
To get the list of services who are still in activity type the following url:
[https://your-site.com/rest/services](https://your-site.com/rest/services)

To get the whole list of services - active and non active type the following url:
[https://your-site.com/rest/services?active=all](https://your-site.com/rest/services?active=all)

To get the list of services who are not in activity anymore type the following url:
[https://your-site.com/rest/services?active=false](https://your-site.com/rest/services?active=false)

Getting research services follow the same logic as getting employees... So please refer to the [Employees](#employees) section and replace the parameter _**people**_ by _**services**_.

## Query parameters for filtering
A series of parameters can help filtering the list of entries ([Employee(s)](#employees), [Research Teams](#research-teams), [Research Projects](#research-projects),...) retrieved by one of the previous method/url.

Multiple values can be used for a parameter, each one separated by a **comma**. The combination of values represent an **OR**.

Multiple parameters can be used, each one separated by an **ampersand** (&). The combination of parameters represents an **AND**.
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

With this parameter, you can select a precise list by identifiers - for instance, this url:
[https://your-site.com/rest/services?ids=73,78](https://your-site.com/rest/services?ids=73,78) will retrieve exactly two services with their identifiers: 73 and 78:
```
{
    "services":[
    {
        "id":78,
        "name_en":"ATECO - Aquatic & Terrestrial Ecology",
        "name_nl":"ATECO - Aquatische en Terrestrische Ecologie",
        "name_fr":"ATECO - Ecologie Aquatique et Terrestre",
        "active":"active"
    },
    {
        "id":73,
        "name_en":"Library",
        "name_nl":"Bibliotheek",
        "name_fr":"Bibliothèque",
        "active":"active"
    }]
}
```

#### Name(s) parameter

With this parameter, you can select a precise list by part of the (full) name - for instance, this url:
[https://your-site.com/rest/services?names=Acq,ent](https://your-site.com/rest/services?names=Acq,ent) will retrieve exactly two services with part of their names: Acq and ent:
```
{
    "services":[
    {
        "id":81,
        "name_en":"BEDIC - Biodiversity & Ecosystems Data & Information centre",
        "name_nl":"BEDIC - Data en informatiecentrum voor biodiversiteit en ecosystemen",
        "name_fr":"BEDIC - Centre de données et d’informations pour la biodiversité et les écosystèmes",
        "active":"active"
    },
    {
        "id":72,
        "name_en":"Entomology",
        "name_nl":"Entomologie",
        "name_fr":"Entomologie",
        "active":"active"
    },
    {
        "id":82,
        "name_en":"Scientific collections & archives",
        "name_nl":"Wetenschappelijke collecties en archieven",
        "name_fr":"Collections scientifiques et archives",
        "active":"active"
    }]
}
```

#### Directorates identifiers parameter

With this parameter, you can filter a list by the relationship the element you retrieve has with directorates.

For instance, if you want to retrieve all the employees who are working for the Earth and History of Life Directorate (id 69) service, the url will be:
[https://your-site.com/rest/people?directorates=69](https://your-site.com/rest/people?directorates=69)
The result would be something like this:
```
{
    "people":[
        {
            "id":194,
            "samaccountname":"Canderson",
            "first_name":"Cassandra",
            "last_name":"Anderson",
            "email":"conroy.daisy@strosin.com",
            "active":"inactive"
        }]
}
```
#### Services identifiers parameter

With this parameter, you can filter a list by the relationship the element you retrieve has with services.

For instance, if you want to retrieve all the employees who are working for the BEDIC (id 81) service, the url will be:
[https://your-site.com/rest/people?services=81](https://your-site.com/rest/people?services=81)
The result would be something like this:
```
{
    "people":[
        {
            "id":199,
            "samaccountname":"Glind",
            "first_name":"Grace",
            "last_name":"Lind",
            "email":"audrey51@champlin.net",
            "active":"active"
        },
        {
            "id":165,
            "samaccountname":"Dmarvin",
            "first_name":"Duncan",
            "last_name":"Marvin",
            "email":"jacky84@bahringer.com",
            "active":"active"
        }]
}
```

#### Research Projects identifiers parameter

With this parameter, you can filter a list by the relationship the element you retrieve has with research projects.

For instance to retrieve all teams working on a project named Antabif (id 70), you would wait for the result of this url:
[https://your-site.com/rest/teams?projects=70](https://your-site.com/rest/teams?projects=70)

#### Research Teams identifiers parameter

With this parameter, you can filter a list by the relationship the element you retrieve has with research projects.

For instance to retrieve all projects a given team (Diggers - id 74) is working on, you would wait for the result of this url:
[https://your-site.com/rest/projects?teams=74](https://your-site.com/rest/projects?teams=74)

#### Combination of parameters

With the following url, you would get all people (active and non active) who worked for Monitoring (id 61) **OR** Taxonomists (id 73) teams **AND** also on Ibisca (id 72) **OR** Monilog (id 69) projects:
[https://your-site.com/rest/people?active=all&teams=61,73&projects=69,72](https://your-site.com/rest/people?active=all&teams=61,73&projects=69,72)

## Case of No Results
When no results are found, a 404 JSON object is returned:
```
{
    "error":{
        "code":404,
        "message":"Not Found"
    }
}
```
