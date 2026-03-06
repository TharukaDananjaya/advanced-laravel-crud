# Advanced Laravel CRUD System

## 🚀 Overview
This is a fully functional Laravel-based CRUD API that includes:
✅ Authentication with Sanctum  
✅ Role-Based Access Control (RBAC)  
✅ CRUD Operations for Products  
✅ Middleware & Exception Handling  
✅ API Documentation with Swagger  
✅ Automated Testing (PHPUnit/PestPHP)  
✅ Continuous Integration & Deployment (CI/CD)  
✅ Deployment on a Live Server  

---

## 🔧 Technologies Used
- **Laravel 11.x**
- **PHP 8.2**
- **MySQL**
- **Sanctum for API Authentication**
- **Swagger (L5 Swagger) for API Docs**
- **PestPHP & PHPUnit for Testing**
- **GitHub Actions for CI/CD**
- **Ubuntu (DigitalOcean/AWS) for Hosting**
- **Nginx & Supervisor for Queue Jobs**
- **SSL (Let's Encrypt) for Security**

---

## 🔧 Installation Guide

### **1️⃣ Clone the Repository**
```bash
git clone https://github.com/TharukaDananjaya/advanced-laravel-crud.git
cd advanced-laravel-crud
```

### **2️⃣ Install Dependencies**
```bash
composer install
```

### **3️⃣ Configure Environment**
```bash
cp .env.example .env
php artisan key:generate
```

Update `.env`:
```
DB_DATABASE=laravel_db
DB_USERNAME=root
DB_PASSWORD=yourpassword
```

### **4️⃣ Run Migrations**
```bash
php artisan migrate --seed
```

### **5️⃣ Start the Development Server**
```bash
php artisan serve
```
Your API is now available at `http://127.0.0.1:8000/api`.

---

## 🔑 API Authentication
This system uses **Laravel Sanctum** for API authentication.

### **Register a User**
```http
POST /api/auth/register
```
**Request Body (JSON):**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password",
    "password_confirmation": "password",
    "role": "User"
}
```

### **Login**
```http
POST /api/auth/login
```
**Response (Token Example):**
```json
{
    "message": "Login successful.",
    "token": "3|mFx..."
}
```
Use this token for **Authorization** in headers:
```
Authorization: Bearer <TOKEN>
```

---

## 📝 API Documentation (Swagger)
The API is documented using **Swagger**.

🔗 Open `http://127.0.0.1:8000/api/documentation` in your browser to access API docs.

To regenerate docs:
```bash
php artisan l5-swagger:generate
```

---

## 🛠 Running Tests
To ensure the system is working correctly, run:
```bash
php artisan test
```
or, if using PestPHP:
```bash
vendor/bin/pest
```

---

## ✨ Credits
Developed by [Tharuka Dananjaya](https://github.com/TharukaDananjaya)  
📧 Contact: 

---

