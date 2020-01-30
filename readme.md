## Assignment project 


This project has deployed with laravel framework with:
- **Interface and Dependecy injection** and inversion of control
[service providers files]
- **Services** for bussiness logic 
- **Repository pattern** for getting the information from db. 
with respect to **SOLID**
- has **Feature test** and **Unit test**
- has **Request class**
- has **Exception   handling with json response** 
- has **Jsonapi standard respone**
- has **datbase seed for assignment values**
- has **database migration**


## database
create your database and put name of your db inside of .env 

`php artisan db:seed`

for table of contents that was in the assignment pdf

## serve the project
`composer install`<br>
`cp .env.example .env`<br>
`php artisan key:generate`<br>
`php artisan serve` 

## run unit tests and feature tests
`./vendor/bin/phpunit`

