# Gestion des Ventes - SPA

A single-page application for managing product sales, built with Vue 3 on the frontend and PHP (PDO/MySQL) on the backend. The application includes authentication, full CRUD operations on a sales table, and a dashboard with statistics and charts.

## Features

- User authentication (login) with session handling and route guards
- Add new products to the sales table (design, price, quantity)
- Display all products in a table with automatically calculated amount (price x quantity)
- Edit and delete existing records directly from the table
- Dynamic, inline form validation (no native browser alerts)
- Dashboard summary with minimum, maximum, and total sales amounts
- Pie chart visualization of sales distribution using Chart.js

## Tech Stack

**Frontend**
- Vue 3 (Composition API and Options API)
- Vue Router
- Chart.js / vue-chartjs
- Vite

**Backend**
- PHP 8 with PDO
- MySQL / MariaDB

## Project Structure

```
APPGESTION/
├── db.sql                  # Database schema and seed data
├── backend/
│   ├── config/
│   │   └── db.php          # Database connection (PDO)
│   ├── login.php           # Authentication endpoint
│   ├── ajouter.php          # Add a new product (POST)
│   ├── crud.php             # List, update, delete products (GET / PUT / DELETE)
│   └── bilan.php            # Aggregated statistics for the dashboard (GET)
└── src/
    ├── components/
    │   ├── Ajouter.vue       # Add product form
    │   ├── Crud.vue          # Product table with edit/delete
    │   ├── Bilan.vue         # Statistics and pie chart
    │   └── Navbar.vue
    ├── views/
    │   ├── Login.vue
    │   └── Dashboard.vue
    ├── router/
    │   └── index.js
    ├── App.vue
    └── main.js
```

## Prerequisites

- Node.js and npm
- PHP 8 with the PDO MySQL extension
- Apache (or another web server capable of running PHP)
- MySQL or MariaDB

## Setup

### 1. Clone the repository

```bash
git clone https://github.com/tefi-rz/APPGESTION.git
cd APPGESTION
```

### 2. Database setup

Import the provided SQL file into your database server:

```bash
sudo mysql -u root
```

```sql
CREATE DATABASE IF NOT EXISTS vente_db;
USE vente_db;
source db.sql;
```

Create a dedicated database user (adjust credentials as needed):

```sql
CREATE USER 'dev'@'localhost' IDENTIFIED BY '1234';
GRANT ALL PRIVILEGES ON vente_db.* TO 'dev'@'localhost';
FLUSH PRIVILEGES;
```

Update the credentials in `backend/config/db.php` if they differ from the defaults.

### 3. Backend setup

Copy the `backend/` folder into your web server document root:

```bash
sudo cp -r backend /var/www/html/
sudo systemctl start apache2
sudo systemctl start mysql
```

The backend endpoints will then be available at `http://localhost/backend/`.

### 4. Frontend setup

```bash
npm install
npm run dev
```

The application will be available at `http://localhost:5173`.

## API Endpoints

| Method | Endpoint                | Description                          |
|--------|--------------------------|---------------------------------------|
| POST   | `/backend/login.php`     | Authenticate a user                   |
| POST   | `/backend/ajouter.php`   | Add a new product                     |
| GET    | `/backend/crud.php`      | List all products                     |
| PUT    | `/backend/crud.php`      | Update an existing product            |
| DELETE | `/backend/crud.php`      | Delete a product                      |
| GET    | `/backend/bilan.php`     | Get aggregated statistics for charts  |

All endpoints return JSON responses in the form:

```json
{ "success": true, "message": "..." }
```

or, where applicable, with additional `data`, `stats`, or `produits` fields.

## Team

- Authentication and login backend
- CRUD listing, update, and delete
- Product creation
- Statistics dashboard and chart visualization

## License

This project was developed for academic purposes.
