##Mac Os, Ubuntu users continue here:

Create a database locally named test utf8_general_ci
Download composer https://getcomposer.org/download/
Pull Laravel/php project from git provider. https://github.com/xudawww/webdev-challenge
Rename .env.example file to .envinside your project root and fill the database information. (windows wont let you do it, so you have to open your console cd your project root directory and run mv .env.example .env )
Open the console and cd your project root directory
Run composer install or php composer.phar install
Run php artisan migrate
Run php artisan serve


