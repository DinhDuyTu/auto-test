# Overview

This repo is not about install codeception along with your project, but to write and run acceptance test separately.

We use laravel for easily setup ORM, factory.

# Required

1. Docker
1. Docker
1. Docker

# Setup

1. Clone repo.
1. Duplicate ```.env.example``` file and rename to ```.env```, change DB connection info to connect to your website's mysql server.
1. Open ```tests\acceptance.suite.yml``` and replate ```https://www.google.co.jp/``` with your website url.
1. Run docker by ```docker-compose up -d```, find utils_container_name in console logs.
1. Install composer ```docker exec -it utils_container_name composer install```
1. Generate models ```docker exec -it utils_container_name php artisan code:models```
> If your get any error, try to download generator package from "master" branch at https://github.com/reliese/laravel and replace package content in vendor folder. They fixed errors but do not released yet.
1. Create factory, docs here https://laravel.com/docs/5.6/database-testing#writing-factories.
> Note that our models not in ```App\``` but in ```App\Models\```

# Run with docker

Run acceptance test
```
docker exec -it utils_container_name codecept run acceptance
```

# Run without docker

Start server
```
java -Dwebdriver.chrome.driver=./chromedriver.exe -jar selenium-server-standalone-3.141.59.jar
```

Run test
```
php codecept.phar clean;php codecept.phar run acceptance --debug
```