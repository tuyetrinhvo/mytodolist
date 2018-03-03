ToDoList
========

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/7f1334b4-d38b-4d92-b7a1-ef67e5df8245/big.png)](https://insight.sensiolabs.com/projects/7f1334b4-d38b-4d92-b7a1-ef67e5df8245)

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/cea2c4823f5849a0bb6699b59bd8bb8e)](https://www.codacy.com/app/tuyetrinhvo/mytodolist?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=tuyetrinhvo/mytodolist&amp;utm_campaign=Badge_Grade)

##Project 8 : Improve an existing Symfony Application
            
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

## Use the command :

    php bin/console doctrine:database:create

    php bin/console doctrine:schema:update --force

    php bin/console doctrine:fixtures:load
    
#### Install the test database :  
  
    php bin/console doctrine:database:create --env=test
    
    php bin/console doctrine:schema:update --force --env=test
    
    php bin/console doctrine:fixtures:load --env=test
 
 ##### Run the automated tests
 
    php ./vendor/phpunit/phpunit/phpunit
    
 --------------
 
 ### TuyetrinhVO