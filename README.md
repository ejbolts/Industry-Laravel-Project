# Industry Management Project

This is a university project and is a Laravel-based web application designed to connect students with industry partners for real-world project collaborations within a university setting.

## Description 

This project, developed as part of a web development course at the university, represents a practical exploration into the Laravel framework. Initially hosted on the university's cloud servers for development, the application was subsequently migrated to an Amazon EC2 micro instance for production hosting to feature on my portfolio.

The primary objective of this project was to gain hands-on experience with key Laravel features, including the Eloquent ORM, Blade templating, and advanced routing capabilities. The application facilitates a dynamic interaction between two primary user groups: students and industry partners.

For students, the application offers a platform to create and customise their profiles, showcasing their skills and academic achievements. They can actively browse and apply to various projects posted by industry partners, enabling them to engage with real-world scenarios and opportunities.

On the other side, industry partners, who are registered and verified by a teacher (credentials pre-stored in the database), can use the platform to post new projects. These projects are tailored to specific academic semesters and years, allowing for a structured and timely collaboration with the student community.

### Prerequisites

Just like any other PHP framework, you'll need a server to run it. I recommend XAMPP and using the Apache server it comes with and set up a virtual host on port 80 for HTTP access. 
```
<VirtualHost 127.0.0.1:80>
    ServerName [YourServerName]
    DocumentRoot /var/www/industryproject/public
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined

    <Directory “D:\laravel-gkb\public”>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride all
        Order Deny,Allow
        Allow from all
        Require all granted
    </Directory>
</VirtualHost>
```

The Laravel framework has a few system requirements. You should ensure that your web server has the following minimum PHP version and extensions see: https://laravel.com/docs/8.x/deployment#server-requirements

    PHP >= 8.1
    Ctype PHP Extension
    cURL PHP Extension
    DOM PHP Extension
    Fileinfo PHP Extension
    Filter PHP Extension
    Hash PHP Extension
    Mbstring PHP Extension
    OpenSSL PHP Extension
    PCRE PHP Extension
    PDO PHP Extension
    Session PHP Extension
    Tokenizer PHP Extension
    XML PHP Extension


### Installing

Create .env file following the .env.example don't need all variables

Configure the app key
```
php artisan key:generate
```
Change DB_CONNECTION to SQLite
```
DB_CONNECTION=sqlite
```
Keep APP_URL as localhost and APP_ENV=local
```
APP_ENV=local
APP_URL=http://localhost
```

Install all dependencies
```
composer install
npm install
```
If needed rollback and re-run all migrations
```
php artisan migrate:refresh --seed
```
