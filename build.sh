#!/bin/bash
start=`date +%s`


# START Assign permissions to the database volumes --------------------------------------------------------------
sudo chmod 777 -R store_app_db_mysql
sudo chmod 777 -R web_store/storage/
sudo chmod 777 -R .

# START Building Docker containers -------------------------------------------------------------------------
docker-compose up -d
# END Building Docker containers --------------------------------------------------------------

# START Authentication Microservice commands --------------------------------------------------------------
( while ! docker exec store_app_db_mysql mysqladmin --user=root --password=secret --host "0.0.0.0" ping --silent &> /dev/null ; do
    echo " ... Waiting for database to be deployed ..." ; sleep 10; done; echo " ... Database has been deployed successfully ..." )

docker exec -it --workdir /var/www/web_store store_app_php chmod -R 777 .
docker exec -it --workdir /var/www/web_store store_app_php cp .env.example .env
docker exec -it --workdir /var/www/web_store store_app_php composer dump-autoload
docker exec -it --workdir /var/www/web_store store_app_php composer install
docker exec -it --workdir /var/www/web_store store_app_php php artisan key:generate
docker exec -it --workdir /var/www/web_store store_app_php php artisan migrate:fresh  --seed
composer require jason-guru/laravel-make-repository --dev
#END
end=`date +%s`
runtime=$((end-start))
echo "Project is successfully deployed in" $runtime "seconds"
