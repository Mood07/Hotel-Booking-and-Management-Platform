# 🏨 Hotel Booking and Management Platform

A production-ready **Hotel Booking System** built with **PHP**, **MySQL**, **Bootstrap 5**, and a clean **MVC-style architecture**.  
Implements full CRUD operations for rooms, reservations, and messages with admin panel, dynamic content, and responsive design.

Perfect for showcasing **Full Stack Web Development** skills in your GitHub portfolio or CV.

---

## 🚀 Features

- Browse available rooms with images, pricing, capacity
- View detailed room information (features, facilities)
- Room reservation system with date selection & availability check
- Contact form for guest inquiries
- Responsive design with Bootstrap 5
- Admin panel for complete management:
  - 📊 Dashboard with statistics
  - 🛏️ Room management (CRUD + image upload)
  - 📅 Reservation management (status updates)
  - 📧 Message inbox (read/unread)
  - ⚙️ Site settings & password change

---

## 🧱 Project Structure

```
HBWEBSITE/
│
├── admin/
│     ├── index.php          # Admin login
│     ├── dashboard.php      # Statistics overview
│     ├── rooms.php          # Room CRUD
│     ├── reservations.php   # Manage bookings
│     ├── messages.php       # Contact messages
│     ├── settings.php       # Site settings
│     └── logout.php
│
├── inc/
│     ├── config.php         # DB connection & helpers
│     ├── header.php         # Site header & navbar
│     └── footer.php         # Site footer
│
├── css/
│     └── style.css          # Custom styles
│
├── uploads/
│     ├── rooms/             # Room images
│     └── carousel/          # Homepage carousel
│
├── index.php                # Homepage
├── rooms.php                # Room listing
├── room_details.php         # Room details & booking
├── facilities.php           # Hotel facilities
├── contact.php              # Contact form
├── about.php                # About page
│
└── database.sql             # MySQL database schema
```

---

## 🗄 MySQL Configuration

### 1️⃣ Database Setup

```sql
-- Run in MySQL Workbench or phpMyAdmin
SOURCE database.sql;
```

### 2️⃣ Create Config File

```bash
# Copy the example config
cp HBWEBSITE/inc/config.example.php HBWEBSITE/inc/config.php
```

Then edit `config.php` with your MySQL credentials:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'YOUR_DB_PASSWORD');
define('DB_NAME', 'hbwebsite');
```

⚠️ Your real DB password should **NOT** be pushed to GitHub. Update before deployment.

---

## ▶ How to Run

### 1. Clone the repository

```bash
git clone https://github.com/Mood07/Hotel-Booking-and-Management-Platform.git
```

### 2. Setup Database

- Open MySQL Workbench or phpMyAdmin
- Run `HBWEBSITE/database.sql`

### 3. Configure Database

- Edit `HBWEBSITE/inc/config.php` with your MySQL password

### 4. Start Server

- Start Apache & MySQL via XAMPP/WAMP
- Open: `http://localhost/HBWEBSITE/`

---

## 🔐 Admin Panel

| Field    | Value                               |
| -------- | ----------------------------------- |
| URL      | `http://localhost/HBWEBSITE/admin/` |
| Username | `admin`                             |
| Password | `password`                          |

---

## 📡 Key Pages

| Page            | URL                      | Description                      |
| --------------- | ------------------------ | -------------------------------- |
| 🏠 Home         | `/`                      | Hero, featured rooms, facilities |
| 🛏️ Rooms        | `/rooms.php`             | Browse all available rooms       |
| 📋 Room Details | `/room_details.php?id=1` | View & book a room               |
| 🏊 Facilities   | `/facilities.php`        | Hotel amenities                  |
| 📞 Contact      | `/contact.php`           | Contact form                     |
| ℹ️ About        | `/about.php`             | About the hotel                  |

---

## 🧰 Technologies Used

| Category | Technology                               |
| -------- | ---------------------------------------- |
| Language | PHP 8.x                                  |
| Database | MySQL 8.0                                |
| ORM      | MySQLi                                   |
| Frontend | Bootstrap 5.3                            |
| Icons    | Bootstrap Icons                          |
| Fonts    | Google Fonts (Playfair Display, Poppins) |
| Server   | Apache (XAMPP)                           |
| IDE      | VS Code                                  |

---

## 📸 Screenshots

### Homepage

![Homepage](https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800)

### Admin Dashboard

![Admin](https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=800)

---

## 👨‍💻 Author

**Berke Arda Türk**  
Data Science & AI Enthusiast | Computer Science (B.ASc)  
[🌐 Portfolio Website](https://berke-turk.web.app/) • [💼 LinkedIn](https://www.linkedin.com/in/berke-arda-turk/) • [🐙 GitHub](https://github.com/Mood07)

---

## 📄 License

This project is open source and available under the MIT License.
