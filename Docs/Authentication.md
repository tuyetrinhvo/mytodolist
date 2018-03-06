Authentication
======================

The security system is configured in app/config/security.yml

    role_hierarchy:
        ROLE_ADMIN: [ROLE_USER, ROLE_ADMIN]
        ROLE_USER: ROLE_USER

The website pages are restricted at ROLE_USER :

    firewalls:
        main:
            pattern: ^/


All the website is under this main firewall
    
    firewalls:
        main:
            anonymous: ~
            pattern: ^/
            form_login:
                login_path: login
                check_path: login_check
                always_use_default_target_path:  true
                default_target_path:  /
            logout_on_user_change: true
            logout: true
            
To access you must be registred as ROLE_USER
 
    access_control:
        - { path: ^/, roles: ROLE_USER }

To be a user, a visitor must have an account.

Only users with ROLE_ADMIN can access to ^/users
   
    access_control:
        - { path: ^/users, roles: ROLE_ADMIN }

Everyone can access to page ^/login
    
    access_control:
        - { path: ^/login, roles: IS_AUTHENTICATED_ANONYMOUSLY }

The users are loaded from the database:

    providers:
        doctrine:
            entity:
                class: AppBundle:User
                property: username