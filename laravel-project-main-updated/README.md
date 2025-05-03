# laravel-project
This repository contains a complete Laravel project built as part of a hands-on learning journey. It demonstrates the implementation of core Laravel features, including routing, controllers, models, database migrations, authentication, and more.

---

## Features  
- Multi-guard authentication for multiple user roles.  
- Role-based access control (RBAC) for different functionalities.  
- RESTful routing and controllers.  
- Database migrations and seeding.  
- Eloquent ORM for database interactions.  
- Blade templating for reusable and dynamic front-end views.  
- Middleware for request handling and access control.  
- Scalable and modular code structure.  

---

## Installation  

Follow these steps to set up the project on your local machine:  

1. **Clone the Repository**  
   ```bash
   https://github.com/orchid06/laravel-project.git

2. **Navigate to project directory**  
   ```bash
   cd laravel-project
3. **Install using composer**  
   ```bash
   composer install
4. **Copy env**  
   ```bash
   cp .env.example .env
5. **Genereate key**  
   ```bash
   php artisan key:generate
6. **Migrate database**  
   ```bash
   php artisan migrate --seed
1. **Run on local server**  
   ```bash
   php artisan serve
