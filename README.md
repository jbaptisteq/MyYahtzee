# MyYahtzee
Score Grid Management System with stats

## Quality Test :


## Languages used :
    html 5, CSS 3, PHP 7.2.10, MySQL

## Frameworks :
    symfony 4.2

## Functionalities :
    V1
    - Create Game with 1 to 5 players
    - Form to list players (players are not user)
    - Form to register result for 1 to 5 players
    - Auto-calculate Bonus on scoring board
    - Register Game Score
    - Display game result with :
        - Players ordered by final Score
        - Average results by combination (1, 2 ... Square, Suits...)
        - Better Player of each combination


    V2
    See you soon with more Cofee :D


## Getting Started :
    These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

## Prerequisites :
    For Windows you need a web development environment, like wampServer.
    Link and installation instructions available here
    ```
    http://www.wampserver.com/en/
    ```

## Installing :
   Clone project or Download and unzip on your folder choice this repository
   ```
   https://github.com/jbaptisteq/MyYahtzee/archive/master.zip
   ```

   Download and execute Composer in project folder for install Requirements
   ```
   https://getcomposer.org/
   php /path/to/composer.phar update
   ```

   Go to Project Root Folder
   Execute First line for checking database creation.
   Execute second line for create database
   ```
   php bin/console doctrine:schema:update  --dump-sql
   php bin/console doctrine:schema:update  --force
   ```

   Adding first data with Fixtures bundle
   ```
   php bin/console doctrine:fixtures:load
   Careful, database will be purged. Do you want to continue Y/N ?y
   ```

   Open file .env and use your own access
   ```
   ###> doctrine/doctrine-bundle ###
   # Format described at http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#connecting-using-a-url
   # For an SQLite database, use: "sqlite:///%kernel.project_dir%/var/data.db"
   # Configure your db driver and server_version in config/packages/doctrine.yaml
   DATABASE_URL=mysql://yourUser:YourPassword@yourIP/YourDataBase
   ###< doctrine/doctrine-bundle ###
   ```

   You can now run application server :
   ```
   php bin/console server:run
   ```



## Built with
 * [ATOM](https://atom.io/) - Code
 * [WAMP](http://www.wampserver.com/en/) - Database management
