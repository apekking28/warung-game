# Warung Game

Warung Game is a game store management application with an admin panel that enables management of game categories, publishers, and orders. This application is built using Laravel 11 and Filament 3.2 to provide a powerful and intuitive admin experience.

## About the Technology Stack

### PHP v8.2
PHP (Hypertext Preprocessor) is a popular server-side scripting language designed specifically for web development. Version 8.2 brings improved performance, better security, and new features like readonly classes and null-safe operator.

### MySQL
MySQL is an open-source relational database management system. It is widely used for storing and managing structured data, offering robust features for data handling, excellent performance, and reliability.

### Laravel v11
Laravel is a free, open-source PHP web framework that provides an elegant syntax and tools for building web applications. It follows the MVC (Model-View-Controller) pattern and includes features like:
- Eloquent ORM for database interactions
- Blade templating engine
- Built-in security features
- Artisan command-line interface
- Robust dependency management

### Filament v3.2
Filament is a collection of powerful Laravel packages that helps you build beautiful admin panels and dashboard interfaces using the TALL stack (Tailwind CSS, Alpine.js, Laravel, and Livewire). It provides:
- Pre-built UI components
- Form builder
- Table builder
- Dashboard widgets
- Authentication system

## Features

### Admin Panel
1. Authentication
   - Login
   - Register

2. Category Management
   - View categories list
   - Add new category
   - Edit category
   - Delete category

3. Publisher Management
   - View publishers list
   - Add new publisher
   - Edit publisher information
   - Delete publisher

4. Order Management
   - View orders list
   - Update order status
   - Delete order
   - Filter and search orders

### Customer Panel
1. View Game Catalog
2. View Game Details
3. View Categories
4. View Publishers

## System Requirements

- PHP >= 8.2
- Composer
- MySQL/MariaDB
- Node.js & NPM
- Git

## Installation

1. Clone repository
```bash
git clone https://github.com/username/warung-game.git
cd warung-game
```

2. Install PHP dependencies
```bash
composer install
```

3. Install JavaScript dependencies
```bash
npm install
```

4. Copy environment file
```bash
cp .env.example .env
```

5. Generate application key
```bash
php artisan key:generate
```

6. Configure database in .env file
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=warung_game
DB_USERNAME=root
DB_PASSWORD=
```

7. Run migrations and seeders
```bash
php artisan migrate --seed
```

8. Storage link
```bash
php artisan migrate --seed
```

9. Install Filament
```bash
php artisan filament:install --panels
```

10. Create first admin
```bash
php artisan make:filament-user
```

11. Compile assets
```bash
npm run build
```

11. Run server
```bash
php artisan serve
```

The application can now be accessed at `http://localhost:8000`
Admin panel can be accessed at `http://localhost:8000/admin`

## Main Database Structure

<img width="463" alt="erd-warung-game" src="https://github.com/user-attachments/assets/44d8ab68-0cf7-4c87-892a-6c77231e0612">
