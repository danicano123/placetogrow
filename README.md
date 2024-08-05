# PlateToGrow Backend v1.0.0

PlateToGrow Backend is a Laravel application that serves as the backend for managing microsites and their configurations. This application provides APIs for creating, editing, and managing microsites effectively.

## Installation

To get started with PlateToGrow Backend, follow these steps:

### 1. Install XAMPP (for MySQL Database)

If you don't have MySQL installed, you can use XAMPP, a popular package that includes MySQL, Apache, and PHP. Follow these steps to install XAMPP:

-   Download XAMPP from [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html).
-   Install XAMPP by following the installation wizard instructions.
-   Start the Apache and MySQL services from the XAMPP Control Panel.

### 2. Clone the repository

```bash
git clone https://github.com/danicano123/placetogrow.git
cd placetogrow
```

### 3. Install dependencies

```bash
composer install
```

### 4. Set up environment variables

-   Create a .env file in the root directory of the project.

-   Configure the database connection in the .env file according to your MySQL setup in XAMPP:

dotenv
Copiar código
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

### 5. Run migrations and seeders

```bash
php artisan migrate:refresh --seed
```

This command will reset the database and seed it with sample data for testing purposes.

### 6. Create an admin user (Optional)

To create an admin user, you can use the following Artisan command:

```bash
php artisan create:admin-user
```

This command will prompt you to enter the name, email, and password for the new admin user, then create the user and assign the admin role.

- Tip: By default, the database is seeded with an admin user with email admin@example.com and password password.

### 7. Start the Laravel development server

```bash
php artisan serve
```
The development server will start running at http://localhost:8000. You can access the backend APIs from this endpoint.

Frontend Repository
The frontend for PlateToGrow can be found at https://github.com/danicano123/placetogrow-frontend.git.

### 8. Access API Documentation

Swagger API documentation is available at `http://localhost:8000/api/documentation`.
