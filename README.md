# Laravel eCommerce API

A RESTful eCommerce backend built with Laravel. This project supports user and admin authentication, role-based authorization, product listing, order placement, and order management.

## Features

- User & Admin Registration/Login (via Sanctum)
- Role-based access control (`user`, `admin`)
- Product listing
- Place and view orders
- Admin-only access to all orders
- JSON API responses
- Laravel Resource formatting

---

## Tech Stack

- Laravel
- MySQL
- Sanctum for API authentication

---

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/ecommerce-api.git
   cd ecommerce-api
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Update `.env` with your DB details**
   ```env
   DB_DATABASE=ecommerce
   DB_USERNAME=root
   DB_PASSWORD=yourpassword
   ```

5. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

6. **Serve the application**
   ```bash
   php artisan serve
   ```

---

## API Endpoints

### Authentication

- `POST /api/register` – Register user
- `POST /api/login` – Login and get token
- `POST /api/logout` – Logout user
- `GET /api/profile` – Get logged-in user's details

### Products

- `GET /api/products` – List all products

### Orders

- `POST /api/orders` – Place a new order
- `GET /api/orders` – Get user's orders
- `GET /api/admin/orders` – Get all orders (admin only)

---

## Authentication

Use the token returned from `/api/login` in the Authorization header for protected routes:

```
Authorization: Bearer {token}
```

---

## API Documentation

Generated using Scribe.

To regenerate docs:

```bash
php artisan scribe:generate
```

Open `public/docs/index.html` in your browser to view the API docs.

---

## License

MIT
