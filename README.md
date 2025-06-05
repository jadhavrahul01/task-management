# ✅ Final Project Submission – Task Management System

---

## 📌 Project Overview

This is a simple **Task Management System** built using **Laravel**, **Livewire Volt**, and **Mary UI**. It allows **admins** to manage employees and assign tasks, while **employees** can track and update their task progress.

---

## 🚀 Features

### 🔐 Login System

* Admin and Employee login (no registration)

### 🛠️ Admin Functionalities

* Add / Edit employees
* Assign tasks to employees
* Update and delete tasks
* Filter tasks by employee, priority, date, or status

### 👤 Employee Functionalities

* View assigned tasks
* Update task status (Pending → In Progress → Completed)
* Filter tasks by priority, date, or status

### ✉️ Email Notifications

* Email is sent automatically when an employee updates a task status to:

  * In Progress
  * Completed

### 📊 Additional Features

* Task priority options: **High, Medium, Low**
* Clean and interactive UI using **Livewire Volt & Mary UI**
* Toast notifications for actions

---

## ⚙️ Setup Instructions

### 📦 Step-by-step Guide

```bash
# Clone the repository

# Install dependencies
composer install
yarn install && yarn dev

# Configure environment
cp .env.example .env
php artisan key:generate
```

### ⚙️ Update `.env` File

```env
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_pass
```

### 🧬 Run Migrations & Seeders

```bash
php artisan migrate
php artisan migrate:fresh --seed

```

### 🚀 Start the Server

```bash
php artisan serve
```

Visit: 👉 [http://localhost:8000](http://localhost:8000)

---

## 📧 Email Configuration (Optional)

If you want to **test email notifications**, you need to configure **SMTP settings** in your `.env` file. Example setup:

```env

> You can use services like **Mailtrap** for testing in development.

---

## 🔐 Demo Credentials

### 🧑‍💼 Admin Login

* Email: [admin@mail.com](mailto:admin@mail.com)
* Password: password

### 👨‍🔧 Employee Login

* Email: [employee@mail.com](mailto:employee@mail.com)
* Password: password

---

## 📌 Notes

* Only admins can assign, edit, view, or delete tasks.
* Employees can only view and update their assigned tasks.
* Email notifications are triggered on In Progress and Completed status updates.
* Project uses Enums for task priorities and statuses to keep the logic clean and structured.
