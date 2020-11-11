<h1 align="center">Tasks API</h1>
<h2>Перед установкой</h2>
<p>Убедитесь что у вас создана БД с наименованием laravel (mysql)</p>
<h2>Установка</h2>
<p>1. git clone https://github.com/d0mhate/kt.git</p>
<p>2. В папке клонированного проекта выполнить:</p>
<p>2.1 composer install || php artisan composer.phar install</p>
<p>2.2 Указать наименование бд и пароль от нее в файле .env</p>
<p>
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=yourpassword
</p>
<p>2.3 php artisan migrate</p>
<p>2.4 php artisan passport:install</p>
<h2>Postman, env, collections</h2>
<p>URL:https://documenter.getpostman.com/view/5514548/TVemB9WM</p>
<h2>Человеко-часы</h2>
<p>Миграции ~ 40m.</p>
<p>Laravel Passport ~ 30m</p>
<p>Interfaces ~ 40m + подумать </p>
<p>Make Models ~ 40m </p>
<p>Паттерн репозиторий ~1ч.( прочтение документации, best practices)</p>
<p>FormRequests ~ 1ч</p>
