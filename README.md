---

# 📝 Task Management System (Laravel + Livewire + Mary UI)

A simple task management module built with Laravel, Livewire Volt, and Mary UI. Admins can manage employees and assign tasks. Employees can view and update task statuses.

---

## 🚀 Features

* User Authentication (Login only)
* Admin Panel

  * Add / Edit Employees
  * Assign tasks to employees
  * View tasks with filters and statuses
* Employee Panel

  * View assigned tasks
  * Update task status (Pending → In Progress → Completed)
* Task Prioritization (High, Medium, Low)
* Toast Notifications
* Clean and user-friendly UI using Mary UI and Livewire Volt

---

## 📂 Tech Stack

* Laravel 11
* Livewire Volt
* Mary UI
* Tailwind CSS
* MySQL

---

## ⚙️ Setup Instructions

Follow these steps to set up the project on your local machine.

### 1. Clone the Repository

### 2. Install Dependencies

composer install
npm install && npm run dev


### 3. Environment Configuration

cp .env.example .env
php artisan key:generate


Update `.env` with your database credentials:

```
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Run Migrations and Seeders

```bash
php artisan migrate --seed
```

This will create the tables and seed the default admin and employee accounts.

### 5. Serve the Application

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

---

## 👥 Demo Credentials

### 🔑 Admin Login

```
Email: admin@mail.com
Password: password
```

### 👤 Employee Login

```
Email: employee@mail.com
Password: password
```

---

## 📌 Notes

* You can update default users or add more via the database or UI.
* Employees **cannot assign tasks**; only admins can.
* Project uses enums for task priority and status management.

---
