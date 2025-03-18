
## How to run app
Install docker & docker-compose

cp .env.example .env

docker-compose up -d

docker exec -it laravel_app php artisan migrate

chmod -R 777 storage

## RUN TESTING WITH test2, test3, test4

folder code app/Services <--> tests/Unit/Services
folder api  app/Http/Controller/Api

## IMPORT POSTMAN_COLLECTION FOR API 
[API test.postman_collection.json](API%20test.postman_collection.json)

