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
   git clone https://github.com/jinuvarghese-cmd/laravel-ecommerce-api.git
   cd laravel-ecommerce-api
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

   > **Note:** To enable email features (like order confirmation or password reset), configure your `.env` with [Mailtrap](https://mailtrap.io/) or any SMTP service:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=example@example.com
MAIL_FROM_NAME="${APP_NAME}"
 ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```
   
6. **Run queue worker (for invoice generation & email jobs)**
   ```bash
   php artisan queue:listen
   ```

   > Generated invoices will be stored in `storage/app/public/invoices/`.


7. **Serve the application**
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
- `POST /api/products` – Create a Product
- `PUT /api/products/{id}` – update product details
- `DELETE /api/products/{id}` – delete product

### Orders

- `POST /api/orders` – Place a new order
- `GET /api/orders` – Get user's orders
- `GET /api/admin/orders` – Get all orders (admin only)

### Webhooks

- `POST /api/webhooks/payment` – Handle payment gateway callbacks

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

Open `/docs/` in your browser to view the API docs.

---

## License

MIT
