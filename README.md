# one
after git clone, go to the folder and fire :
> composer install

# two
then
> npm install

# three
modifiy the entry DATBASE_URL from .env file and adapt it to your msl connection

# four
create database and fire migrations
> php bin/console doctrine:database:create
> php bin/console doctrine:migrations:migrate

# five
populize tables
> php bin/console doctrine:fixtures:load


run your apache/mysql server
you can run symfony one by
> php bin/console server:run

run the npm server
> npm run watch

