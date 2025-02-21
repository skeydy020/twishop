# 🎠 TwiShop - Kids' Toy Store

https://twishop.work.gd/

TwiShop is an online toy store built with Laravel, designed to provide a seamless shopping experience for parents and kids. The platform offers a wide range of toys, detailed product filtering, and a secure checkout process. 🏆

## ✨ Features

- **🎨 User-friendly Interface**: Responsive and intuitive design.
- **🧩 Product Filtering**: Advanced filters by age, brand, price, and more.
- **🛒 Shopping Cart & Checkout**: Secure payment methods and easy checkout process.
- **📦 Order Management**: Admin dashboard for tracking and managing orders.
- **📊 Reports & Analytics**: Monthly revenue and sales breakdown by product categories.
- **🔧 Warranty Management**: Dedicated warranty section for customer service.

## ⚡ Installation

### 🛠️ Prerequisites
- PHP 8+
- Composer
- Laravel 10
- MySQL or PostgreSQL
- Node.js & NPM (for frontend dependencies)

### 📥 Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/twishop.git
   cd twishop
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Setup Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Configure your `.env` file with database credentials and other settings.

4. **Run Migrations & Seed Database**
   ```bash
   php artisan migrate --seed
   ```

5. **Run the Application**
   ```bash
   php artisan serve
   ```
   Visit `http://127.0.0.1:8000` to access TwiShop. 🎉

## 🔑 Admin Panel

- Access the admin dashboard at: `http://127.0.0.1:8000/admin`

## 🚀 Deployment

For production, use:
```bash
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan migrate --force
```

## 📜 License

TwiShop is licensed under the MIT License.

---

### 📬 Support
For support, contact us at [📧 manh86573.st@vimaru.edu.vn](mailto:manh86573.st@vimaru.edu.vn) or create an issue in the repository. 💡

