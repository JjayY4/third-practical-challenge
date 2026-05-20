# Task Organizer

A web application for personal task management built with PHP MVC (native) and Laravel.
Employees can register, log in, and manage their own tasks with full CRUD functionality
and real-time status updates via AJAX.

---

## Application Flow (mvc_nativo)

### MVC Native (`mvc_nativo/`)

The native MVC follows a front-controller pattern where every request goes through
a single entry point (`index.php`) and is dispatched by the `Router` class.

```
Browser Request
│
▼
index.php  ──►  Session::start()
│
▼
Router::route()
│
├── ?controller=auth&action=login     ──►  AuthController::login()
├── ?controller=auth&action=register  ──►  AuthController::register()
├── ?controller=auth&action=logout    ──►  AuthController::logout()
│
├── ?controller=task&action=index     ──►  TaskController::index()
├── ?controller=task&action=create    ──►  TaskController::create()
├── ?controller=task&action=store     ──►  TaskController::store()
├── ?controller=task&action=edit      ──►  TaskController::edit()
├── ?controller=task&action=update    ──►  TaskController::update()
├── ?controller=task&action=delete    ──►  TaskController::delete()
│
└── ?controller=ajax&action=updateStatus ──►  AjaxController::updateStatus()
```

### Authentication Flow

1. User visits /index.php?controller=auth&action=register
2. Fills out name, email, password, confirm password
3. AuthController validates input server-side:
   - All fields required
   - Valid email format
   - Password minimum 6 characters
   - Password confirmation match
   - Email not already registered
4. Password is hashed with password_hash() (bcrypt)
5. UserModel inserts new record into users table
6. Redirects to login page
7. User submits login form
8. AuthController fetches user by email via UserModel
9. password_verify() checks the submitted password against the hash
10. On success: session stores user_id and user_name
11. Redirects to task list


### Task CRUD flow

1. Session::requireLogin() checks session on every TaskController action
└── If not logged in → redirects to login page
2. index()   → TaskModel::getAllByUser($user_id)  → renders task list
3. create()  → renders empty form
4. store()   → validates title → TaskModel::create() → redirect to index
5. edit()    → TaskModel::getById($id, $user_id)  → renders prefilled form
(user_id check prevents accessing other users' tasks)
6. update()  → validates title → TaskModel::update() → redirect to index
7. delete()  → TaskModel::delete($id, $user_id)   → redirect to index


### AJAX Flow (status change without page reload)

1. User clicks "Marcar Completada" button on task list
2. JavaScript fetch() sends POST to: 
index.php?controller=ajax&action=updateStatus
body: id=X&status=completed
3. AjaxController::updateStatus():
   - Verifies session (user must be logged in)
   - Validates id and status values
   - Calls TaskModel::getById() to confirm task belongs to user
   - Calls TaskModel::update() with new status
   - Returns JSON: { "success": true, "new_status": "completed" }
4. JavaScript receives response:
   - Updates badge color and text in the DOM
   - Updates button label
   - Page never reloads

### Files responsabilities

```
config/
database.php       → PDO singleton connection
libs/
Router.php         → Parses ?controller=X&action=Y, loads controller file
Session.php        → Wraps $_SESSION, provides requireLogin() guard
models/
UserModel.php      → findByEmail(), create()
TaskModel.php      → getAllByUser(), getById(), create(), update(), delete()
controllers/
AuthController.php → login(), register(), logout()
TaskController.php → index(), create(), store(), edit(), update(), delete()
AjaxController.php → updateStatus() — returns JSON only
views/
auth/
login.php        → Login form
register.php     → Registration form
task/
index.php        → Task list table + AJAX script
create.php       → New task form
edit.php         → Edit task form
```


---

## Application Flow (Laravel)


### Laravel (`laravel_tareas/`)

The Laravel version uses the built-in MVC framework following RESTful resource
conventions. Requests go through Laravel's router and are handled by a resource
controller

```
Browser Request
│
▼
public/index.php  ──►  Bootstrap Laravel
│
▼
routes/web.php
│
└── Route::resource('tasks', TaskController::class)
│
├── GET    /tasks          ──►  TaskController::index()
├── GET    /tasks/create   ──►  TaskController::create()
├── POST   /tasks          ──►  TaskController::store()
├── GET    /tasks/{id}/edit ──► TaskController::edit()
├── PUT    /tasks/{id}     ──►  TaskController::update()
└── DELETE /tasks/{id}    ──►  TaskController::destroy()
```

### Request Lifecycle

1. Request hits public/index.php
2. Laravel bootstraps: loads service providers, config, .env
3. Router matches the URL to a controller method
4. Controller method runs:
   - Validates input with $request->validate()
   - Interacts with Eloquent model (Task::all(), Task::create(), etc.)
   - Returns a Blade view or redirect
5. Blade compiles the view template and returns HTML


### Task CRUD Flow

```
index()   → Task::all()
→ returns view('tasks.index', compact('tasks'))
create()  → returns view('tasks.create')
store()   → $request->validate([title required, status in enum])
→ Task::create([user_id, title, description, status])
→ redirect()->route('tasks.index')->with('success', '...')
edit()    → Route model binding: Laravel auto-fetches Task by {id}
→ returns view('tasks.edit', compact('task'))
update()  → $request->validate([...])
          → task−>update(task->update(
task−>update(request->only([...]))
          → redirect to index
destroy() → $task->delete()
→ redirect to index
```


### Key Laravel Concepts Used


```
Eloquent ORM
Task::all()              → SELECT * FROM tasks
Task::create([...])      → INSERT INTO tasks
$task->update([...])     → UPDATE tasks WHERE id = ?
$task->delete()          → DELETE FROM tasks WHERE id = ?
Route Model Binding
edit(Task $task)         → Laravel automatically fetches the task
by the {task} parameter in the URL
Blade Directives
@extends('layouts.app')  → Inherits the base layout
@section('content')      → Injects content into the layout
@foreach / @forelse       → Loops over collections
@if / @csrf / @method     → Conditionals and form helpers
Validation
$request->validate()     → Automatically redirects back with
errors if validation fails
$errors->any()           → Displays validation messages in views
Flash Messages
->with('success', '...')  → Stores one-time message in session
session('success')        → Reads and displays the message
```


### Files Responsabilities


```
routes/
web.php                     → Defines all routes via Route::resource()
app/Http/Controllers/
TaskController.php          → index, create, store, edit, update, destroy
app/Models/
Task.php                    → Eloquent model, $fillable, belongsTo(User)
database/migrations/
..._create_tasks_table.php  → Defines tasks table schema
resources/views/
layouts/
app.blade.php             → Base HTML layout with Bootstrap navbar
tasks/
index.blade.php           → Task list with badges and action buttons
create.blade.php          → New task form with validation errors
edit.blade.php            → Edit form prefilled with current values
```

---


### MVC Native vs Laravel Comparison


| Aspect | MVC Native | Laravel |
|--------|-----------|---------|
| Routing | Manual via query string | Automatic via Route::resource() |
| Database | Raw PDO queries | Eloquent ORM |
| Input validation | Manual if/else checks | $request->validate() |
| Templates | Plain PHP files | Blade templating engine |
| Session handling | Manual $_SESSION wrapper | Built-in session manager |
| Security (CSRF) | Not implemented | @csrf token automatic |
| Code volume | More boilerplate | Less, more expressive |
| Learning value | Understand internals | Understand frameworks |



## Stack Technologies

- PHP 8.2
- Laravel 12
- MySQL
- Bootstrap 5.3
- AJAX (Fetch API)
- XAMPP (Apache + MySQL)
- Composer

---

## Project Layout

```
Taskorganizer/
├── mvc_nativo/
│   ├── config/          # Database connection
│   ├── controllers/     # AuthController, TaskController, AjaxController
│   ├── models/          # UserModel, TaskModel
│   ├── views/           # auth/ and task/ views
│   ├── libs/            # Router, Session classes
│   ├── public/
│   ├── .htaccess
│   └── index.php
├── laravel_tareas/
│   ├── app/
│   ├── database/
│   ├── resources/
│   └── routes/
├── database/
│   └── script.sql
├── screenshots/
│   ├── registro.png
│   ├── login.png
│   ├── tareas.png
│   ├── crear.png
│   └── editar.png
├── README.md
└── .gitignore
```

## Requirements

- XAMPP (PHP 8.1+ and MySQL)
- Composer
- Web browser

---

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/your-username/third-practical-challenge.git
cd taskorganizer
```

### 2. Set up the database

1. Start XAMPP (Apache + MySQL)
2. Open **phpMyAdmin** at `http://localhost/phpmyadmin`
3. Create a new database called `taskorganizer`
4. Import the SQL script:
   - Go to **Import** tab
   - Select `database/script.sql`
   - Click **Go**

### 3. Configure the MVC native app

Copy the example config file and set your credentials:

```bash
cp mvc_nativo/config/database.example.php mvc_nativo/config/database.php
```

Edit `mvc_nativo/config/database.php`:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'taskorganizer');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### 4. Configure Laravel

```bash
cd laravel_tareas
cp .env.example .env
composer install
php artisan key:generate
```

Edit `laravel_tareas/.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=taskorganizer
DB_USERNAME=root
DB_PASSWORD=
```

Then register the existing migrations:

```bash
php artisan tinker
DB::table('migrations')->insert(['migration' => '0001_01_01_000000_create_users_table', 'batch' => 1]);
DB::table('migrations')->insert(['migration' => '2026_05_20_050450_create_tasks_table', 'batch' => 1]);
exit
php artisan migrate
```

---

## Running the Application

### MVC Native (via XAMPP)

Make sure Apache is running, then open:

```bash
http://localhost/taskorganizer/mvc_nativo/index.php?controller=auth&action=login
```

### Laravel (via Artisan)

```bash
cd laravel_tareas
php artisan serve
```

Then open:

```bash
http://127.0.0.1:8000/tasks
```

---

## Features

| Feature | MVC Native | Laravel |
|---------|-----------|---------|
| User registration | ✅ | — |
| User login / logout | ✅ | — |
| Create task | ✅ | ✅ |
| List tasks | ✅ | ✅ |
| Edit task | ✅ | ✅ |
| Delete task | ✅ | ✅ |
| Change status without reload (AJAX) | ✅ | — |
| Bootstrap UI | ✅ | ✅ |
| Access control (own tasks only) | ✅ | — |

---

## Test Credentials

After registering through the native MVC application, use those credentials to log in. 
Below are 5 users for "test" purposes; all users have the same password: **`task123`**.

#### Users (5)

| Name | Email |
|---|---|
| usuario1 | `usuario1@test.com` |
| usuario2 | `usuario2@test.com` |
| usuario3 | `usuario3@test.com` |
| usuario4 | `usuario4@test.com` |
| usuario5 | `usuario5@test.com` |

---

## Screenshots

| Screen | File |
|--------|------|
| Register | `screenshots/registro.png` |
| Login | `screenshots/login.png` |
| Task list | `screenshots/tareas.png` |
| Create task | `screenshots/crear.png` |
| Edit task | `screenshots/editar.png` |

---

## AI Usage Declaration


This project was developed with the assistance of **Claude (Anthropic)** as a learning
and productivity tool. The AI helped with:

- MVC pattern guidance
- Debugging migration and session issues
- Bootstrap layout suggestions

All code was reviewed, understood, and adapted by students. The use of AI tools
was authorized by the course instructor as part of the learning process.

