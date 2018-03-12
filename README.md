# ToDoList
======================

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/c2953a88-8f51-49a4-9915-d02305bb2da6/big.png)](https://insight.sensiolabs.com/projects/c2953a88-8f51-49a4-9915-d02305bb2da6)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/cea2c4823f5849a0bb6699b59bd8bb8e)](https://www.codacy.com/app/tuyetrinhvo/mytodolist?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=tuyetrinhvo/mytodolist&amp;utm_campaign=Badge_Grade)
[![Build Status](https://travis-ci.org/tuyetrinhvo/mytodolist.svg?branch=master)](https://travis-ci.org/tuyetrinhvo/mytodolist)

## Project 8 : Improve an existing Symfony Application
            
   * Anomaly corrections : 
   
        * Link tasks created to an "anonymous" user.
        * A task must be attached to a user
        * Choose a role for a user
        
   * New features :
   
        * Only users who haves admin role able to access the user management pages.
        * Tasks can be deleted only by the users who created these tasks
        * Tasks attached to the "anonymous" user can be deleted onle by users with the administrator role
       
   * Implementation of automated tests
   * Create the technical documentation



You can find the initial project here :

https://openclassrooms.com/projects/ameliorer-un-projet-existant-1

-------------------

# Installation

Clone or download the repository

Update Composer.json

### Create database :

    php bin/console doctrine:database:create

    php bin/console doctrine:schema:create

    php bin/console doctrine:fixtures:load
    
### Link old tasks to an "anonymous" user :

    php bin/console update:old:tasks
    
### Install the test database :  
  
    php bin/console doctrine:database:create --env=test
    
    php bin/console doctrine:schema:create --env=test
    
    php bin/console doctrine:fixtures:load --env=test
 
 ### Run the automated tests
 
    php vendor/bin/phpunit
 or
 
    ./vendor/phpunit/phpunit/phpunit
    
### Create the code coverage with phpunit

    vendor/bin/phpunit --coverage-html docs/code-coverage
    
 --------------
 
 ### TuyetrinhVO