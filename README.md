# THEOS-MIS (School Management System)

## About THEOS-MIS

THEOS-MIS is a **School Management System** designed to handle student, teacher, and classroom management. It streamlines administrative tasks such as enrollment, class scheduling, and task assignments, ensuring an efficient and structured educational environment. Built using **Laravel**, THEOS-MIS provides a robust and scalable solution for school operations.

### Features

- **Student Management** – Enroll, update, and manage student records.
- **Teacher Management** – Assign teachers to courses and monitor schedules.
- **Classroom Management** – Organize class schedules and room assignments.
- **Enrollment System** – Streamlined enrollment process for students.
- **Task Tracking** – Monitor assignments and deadlines.
- **User Management** – Role-based access control (RBAC) for admins, teachers, and students.
- **Automated Reports** – Generate reports for analytics and insights.
- **Secure Authentication** – Login, registration, and password reset functionality.

## System Requirements

Before installing, ensure your system meets the following requirements:

- **PHP** (>= 8.1)
- **Composer** (latest version)
- **Node.js & NPM** (latest LTS version)
- **MySQL** (or any compatible database)
- **Laravel** (version matching the project setup)

## Installation Guide

Follow these steps to set up the project after cloning the repository.

### 1. Clone the Repository



### 2. Install Composer Dependencies

```sh
composer install
```

*If you face any dependency issues, try:*

```sh
composer update
```

### 3. Install Node Packages

```sh
npm install
```

### 4. Setup Environment File

```sh
cp .env.example .env
```

Then, open the `.env` file and configure the following:

- **Database Configuration**
  ```env
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=your_database_name
  DB_USERNAME=your_database_user
  DB_PASSWORD=your_database_password
  ```

### 5. Generate Application Key

```sh
php artisan key:generate
```

### 6. Run Database Migrations & Seeders

```sh
php artisan migrate --seed
```

This will create the necessary database tables and populate them with initial data.

### 7. Serve the Application

```sh
php artisan serve
```

Your application will now be accessible at `http://127.0.0.1:8000`.

### 8. Compile Frontend Assets

```sh
npm run dev
```

*For production build:*

```sh
npm run build
```

## Additional Commands

- **Clear Cache:** `php artisan cache:clear`
- **Config Cache:** `php artisan config:clear`
- **Queue Worker:** `php artisan queue:work`

## Learning Laravel

Laravel has extensive [documentation](https://laravel.com/docs) and a rich tutorial library. You can also check out the [Laravel Bootcamp](https://bootcamp.laravel.com) for hands-on learning.

## Contribution

If you wish to contribute to this project, feel free to submit a pull request or open an issue.

## Security Vulnerabilities

If you discover a security vulnerability within THEOS-MIS, please report it privately. All security issues will be promptly addressed.

## License

This project is open-source and available under the MIT License.

---

For any issues, feel free to contact the repository owner or check the Laravel documentation at [laravel.com/docs](https://laravel.com/docs).

