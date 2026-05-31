# Laravel Maintenance System - Setup Instructions

## Project Overview
This is a complete Laravel-based web application for managing equipment and maintenance records. It connects to a MySQL database and provides a comprehensive frontend with 5+ blade views/pages.

## System Requirements
- PHP 8.1 or higher
- Composer
- MySQL 5.7 or higher
- Node.js (optional, for frontend assets)

## Installation Steps

### 1. Extract and Setup
```bash
# Navigate to the project directory
cd path/to/final_project

# Install PHP dependencies
composer install
```

### 2. Environment Configuration
```bash
# Copy the example environment file
cp .env.example .env

# Generate application key (if not already set)
php artisan key:generate
```

### 3. Configure Database
Edit the `.env` file and update these lines with your MySQL credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=maintenance_system
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Import Database
Import the `maintenance_system.sql` file into your MySQL database:
```bash
mysql -u root -p maintenance_system < maintenance_system.sql
```

Or use phpMyAdmin:
1. Create a new database named `maintenance_system`
2. Import the `maintenance_system.sql` file

### 5. Create Models and Migrations (Optional)
To integrate fully with the database, you may want to create models:
```bash
php artisan make:model Equipment -m
php artisan make:model Maintenance -m
php artisan make:model User -m
```

### 6. Run the Application
```bash
# Start the development server
php artisan serve
```

The application will be available at: `http://localhost:8000`

## Available Pages

### 1. **Dashboard** (`/`)
- Overview of system statistics
- Quick action buttons
- Equipment count, maintenance records, etc.

### 2. **Equipment Management** (`/equipment`)
- View all equipment
- Create new equipment
- Edit equipment details
- Delete equipment
- Equipment list with status

### 3. **Maintenance Records** (`/maintenance`)
- View all maintenance activities
- Create new maintenance records
- Edit maintenance details
- Delete records
- Track maintenance history

### 4. **User Management** (`/users`)
- View all users
- Create new users with roles
- Edit user details
- Delete users
- Manage user roles (Admin, Technician, Manager, Viewer)

### 5. **Reports** (`/reports`)
- Equipment Report - View equipment statistics and details
- Maintenance Report - View maintenance statistics and history

## Project Structure

```
final_project/
├── app/
│   └── Http/
│       └── Controllers/
│           ├── DashboardController.php
│           ├── EquipmentController.php
│           ├── MaintenanceController.php
│           ├── UserController.php
│           └── ReportController.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── dashboard/
│       │   └── index.blade.php
│       ├── equipment/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── show.blade.php
│       │   └── edit.blade.php
│       ├── maintenance/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── show.blade.php
│       │   └── edit.blade.php
│       ├── users/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── show.blade.php
│       │   └── edit.blade.php
│       └── reports/
│           ├── index.blade.php
│           ├── equipment.blade.php
│           └── maintenance.blade.php
├── routes/
│   └── web.php
├── .env.example
├── composer.json
└── SETUP_INSTRUCTIONS.md
```

## Features

✅ Responsive Bootstrap 5 Design
✅ 5+ Different Views/Blades
✅ MySQL Database Integration
✅ CRUD Operations (Create, Read, Update, Delete)
✅ Navigation Sidebar
✅ Dashboard with Statistics
✅ User Management with Roles
✅ Reports Generation
✅ Professional UI with Icons (Font Awesome)
✅ Form Validation Ready

## Next Steps

1. **Create Models**: Add Eloquent models to interact with database tables
2. **Add Validation**: Implement form validation in controllers
3. **Database Queries**: Update controllers to fetch real data from database
4. **Authentication**: Add Laravel authentication if needed
5. **Testing**: Create tests for controllers and models

## Troubleshooting

### Port Already in Use
If port 8000 is already in use, run:
```bash
php artisan serve --port=8001
```

### Database Connection Error
- Verify MySQL is running
- Check `.env` database credentials
- Ensure database exists

### Missing Composer
Install Composer from: https://getcomposer.org/download/

## Support
For Laravel documentation, visit: https://laravel.com/docs

## License
MIT License
