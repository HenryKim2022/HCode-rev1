# Laravel 11.0 Installation and Configuration Guide
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Project Dependencies

1. PHP >= 8.2
2. Extensions: curl and all basic extensions
3. Composer
4. NPM
5. Vite

## Install Laravel 11.0

1. Install Composer and set its PHP path.
2. Go to the project root, open VSCode or Git Bash, and run:
   ```bash
   composer create-project --prefer-dist laravel/laravel:^11.0 ./
   ```
3. Set up the environment file:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Edit the `.env` file in the project root:
   ```env
   APP_NAME=Laravel
   APP_ALIAS="HCode"
   APP_DEV="Henry .K"
   APP_OWNER="${APP_DEV}"
   APP_YEAR="2025"
   APP_ENV=local
   APP_DEBUG=true
   APP_TIMEZONE=ASIA/JAKARTA
   APP_URL=http://localhost
   
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=xxx@gmail.com
   MAIL_PASSWORD="xxxx xxxx xxxx xxxx"
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS="xxx@gmail.com"
   MAIL_FROM_NAME="${APP_OWNER}"
   ```

## Configure Web Root for Laravel (Web Hosting Support)

1. Go to `root/public`.
2. Copy and paste `.htaccess` into the `root` directory and modify `.htaccess`:
   ```apache
   <IfModule mod_rewrite.c>
       <IfModule mod_negotiation.c>
           Options -MultiViews -Indexes
       </IfModule>

       RewriteEngine On
       
       # Redirect all requests to the public folder
       RewriteCond %{REQUEST_URI} !^/public/
       RewriteRule ^(.*)$ /public/$1 [L]
       
       # Serve assets from the public/build directory
       RewriteRule ^build/(.*)$ public/build/$1 [L]

       # Handle Authorization Header
       RewriteCond %{HTTP:Authorization} .
       RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

       # Redirect Trailing Slashes If Not A Folder...
       RewriteCond %{REQUEST_FILENAME} !-d
       RewriteCond %{REQUEST_URI} (.+)/$
       RewriteRule ^ %1 [L,R=301]

       # Send Requests To Front Controller...
       RewriteCond %{REQUEST_FILENAME} !-d
       RewriteCond %{REQUEST_FILENAME} !-f
       RewriteRule ^ index.php [L]
   </IfModule>
   ```
3. Set the assets (CSS/JS) path without "public/template":
   ```html
   <img src="{{ asset('template/assets/images/small/small-2.jpg') }}?v={{ time() }}" class="card-img-top" loading="lazy" alt="...">
   <script src="{{ asset('template/assets/js/config.js') }}?v={{ time() }}"></script>
   <link href="{{ asset('template/assets/css/icons.min.css') }}?v={{ time() }}" rel="stylesheet" type="text/css" />
   ```

## Compile Assets (app.css & app.js) Using Laravel Vite

1. Install Vite:
   ```bash
   composer require laravel/vite-plugin
   npm install --save-dev vite laravel-vite-plugin
   ```
2. Create a Vite configuration file named `vite.config.js` in the root of your project:
   ```javascript
   import { defineConfig } from 'vite';
   import laravel from 'laravel-vite-plugin';

   export default defineConfig({
       plugins: [
           laravel({
               input: ['resources/css/app.css', 'resources/js/app.js'],
               refresh: true,
               build: {
                   outDir: 'build',
               },
           }),
       ],
   });
   ```
3. Add scripts to your `package.json` for building and running Vite:
   ```json
   "scripts": {
       "dev": "vite",
       "build": "vite build"
   }
   ```
4. Update your Blade template to use the `@vite` directive:
   ```html
   <head>
       @vite(['resources/css/app.css', 'resources/js/app.js'])
   </head>
   ```
5. Run Vite watcher while developing:
   ```bash
   npm run dev
   ```
6. Compile the `app.css` & `app.js` for web hosting support:
   ```bash
   npm run build
   ```

## Fix CSS/JS Not Loading (Optional, Web Hosting Support)

1. Go to `app/Providers/AppServiceProvider.php` and modify:
   ```php
   <?php
   namespace App\Providers;

   use Illuminate\Support\ServiceProvider;
   use Illuminate\Support\Facades\URL;

   class AppServiceProvider extends ServiceProvider
   {
       public function register(): void
       {
           // ADDED: FIX CSS NOT LOADING IN HTTPS
           if (env('APP_ENV') === 'local' && request()->server('HTTP_X_FORWARDED_PROTO') === 'https') {
               URL::forceScheme('https');
           }
       }

       public function boot(): void
       {
           // ADDED: FIX CSS NOT LOADING IN HTTPS
           if (env('APP_ENV') !== 'local') {
               URL::forceScheme('https');
           }
       }
   }
   ?>
   ```
