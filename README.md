# Inventory App Laravel

<p align="center">
  <a href="https://www.docker.com/" target="_blank">
    <img src="https://www.vectorlogo.zone/logos/docker/docker-icon.svg" width="100" alt="Docker Logo">
  </a>
</p>

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

---

## Docker Setup & Project Initialization

Follow the steps below to set up the project using Docker and initialize the database:

```bash
# 1. Clone repository
git clone https://github.com/h4fizm/inventory-app-laravel.git
cd inventory-app-laravel

# 2. Copy .env template
cp .env.example .env

# 3. Configure .env file
# Open .env in your favorite text editor and adjust the following:
APP_NAME=inventory-app-laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=db_inventory
DB_USERNAME=root
DB_PASSWORD=

make sure to generate key using : php artisan key:generate

# 4. Build and run Docker container
docker-compose up -d --build

# 5. Run database migrations and seeders
docker exec -it laravel_app php artisan migrate --seed

# 6. Demo Accounts
Role	Email	            Password
Admin	admin@example.com	password
User	user@example.com	password

# 7. Access Website
Open your browser and navigate to:
http://localhost:8000
