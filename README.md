# Articles Management System

A professional articles management system built with Laravel 12, Filament Admin Panel, and a REST API with Sanctum authentication.

## Requirements

- PHP >= 8.2
- Composer
- MySQL or SQLite

## Installation

To get started, clone the repository and install the PHP dependencies:

```bash
git clone https://github.com/fatmaelkassaby2003/Jadara-articles-management-system.git
cd Jadara-articles-management-system
composer install
```

Next, set up your environment variables and generate an application key:

```bash
cp .env.example .env
php artisan key:generate
```

Run the database migrations and seeders, then link the storage directory:

```bash
php artisan migrate --seed
php artisan storage:link
```

You'll need an admin account to access the control panel. Create one using:

```bash
php artisan make:filament-user
```

Finally, start the development server:

```bash
php artisan serve
```

### Access Points

- Frontend: `http://localhost:8000`
- Admin Panel: `http://localhost:8000/admin`
- API: `http://localhost:8000/api/v1`