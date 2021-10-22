Intstruction

<ol>
    <li>composer install</li>
    <li>docker-compose build</li>
    <li>docker-compose up -d</li>
    <li>cp .env.example .env</li>
    <li>docker-compose exec app php artisan key:generate</li>
    <li>docker-compose exec app php artisan config:cache</li>
    <li>docker-compose exec app php artisan migrate</li>
    <li>check http://localhost/ on your machine</li>
</ol>
