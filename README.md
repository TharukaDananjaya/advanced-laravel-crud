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

## 🚀 Deployment Instructions
### **1️⃣ Deploy on Production Server**
```bash
ssh username@your-server-ip
```

Clone the repository:
```bash
cd /var/www
git clone https://github.com/your-username/your-repo.git laravel-app
cd laravel-app
composer install --no-dev --optimize-autoloader
```

### **2️⃣ Set Up Environment Variables**
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` with **production database credentials**.

Run migrations:
```bash
php artisan migrate --force
```

Set permissions:
```bash
sudo chown -R www-data:www-data /var/www/laravel-app
sudo chmod -R 775 /var/www/laravel-app/storage /var/www/laravel-app/bootstrap/cache
```

### **3️⃣ Restart Server & Enable Queues**
```bash
php artisan queue:restart
sudo systemctl restart nginx
sudo systemctl restart php8.2-fpm
```

---

## 🔄 CI/CD Pipeline (GitHub Actions)
This project is integrated with **GitHub Actions** for **automated testing and deployment**.

Every push to the `main` branch triggers:
✅ Automated testing  
✅ SSH deployment to the server  
✅ Cache clearing & migrations  

To deploy automatically, push changes to `main`:
```bash
git add .
git commit -m "New feature added"
git push origin main
```

---

## 🎯 Next Improvements
- ✅ **Add Caching for Faster Performance**
- ✅ **Implement WebSockets for Real-Time Notifications**
- ✅ **Enable API Rate Limiting for Security**
- ✅ **Add a Frontend (Next.js/Vue.js)**

---

## ✨ Credits
Developed by [Your Name](https://github.com/your-username)  
📧 Contact: your-email@example.com

---

