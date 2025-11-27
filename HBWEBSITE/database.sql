admin-- Hotel Booking Website Database
-- Create database
CREATE DATABASE IF NOT EXISTS hbwebsite;
USE hbwebsite;

-- Admin table
CREATE TABLE admin (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Settings table
CREATE TABLE settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    site_title VARCHAR(100) DEFAULT 'Hotel Booking',
    site_about TEXT,
    site_email VARCHAR(100),
    site_phone VARCHAR(20)
);

-- Rooms table
CREATE TABLE rooms (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    adults INT DEFAULT 2,
    children INT DEFAULT 0,
    area INT DEFAULT 0,
    image VARCHAR(255),
    status TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Features table (room features like AC, TV, etc)
CREATE TABLE features (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL
);

-- Facilities table (hotel facilities like pool, gym, etc)
CREATE TABLE facilities (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    icon VARCHAR(50) DEFAULT 'bi-check-circle'
);

-- Room-Features relationship
CREATE TABLE room_features (
    id INT PRIMARY KEY AUTO_INCREMENT,
    room_id INT,
    feature_id INT,
    FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE,
    FOREIGN KEY (feature_id) REFERENCES features(id) ON DELETE CASCADE
);

-- Room-Facilities relationship
CREATE TABLE room_facilities (
    id INT PRIMARY KEY AUTO_INCREMENT,
    room_id INT,
    facility_id INT,
    FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE,
    FOREIGN KEY (facility_id) REFERENCES facilities(id) ON DELETE CASCADE
);

-- Reservations table
CREATE TABLE reservations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    room_id INT,
    user_name VARCHAR(100) NOT NULL,
    user_email VARCHAR(100) NOT NULL,
    user_phone VARCHAR(20),
    check_in DATE NOT NULL,
    check_out DATE NOT NULL,
    total_amount DECIMAL(10,2),
    status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE SET NULL
);

-- Contact messages table
CREATE TABLE contact_messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200),
    message TEXT NOT NULL,
    is_read TINYINT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Carousel table (for homepage slider)
CREATE TABLE carousel (
    id INT PRIMARY KEY AUTO_INCREMENT,
    image VARCHAR(255),
    title VARCHAR(200),
    description TEXT,
    status TINYINT DEFAULT 1
);

-- Users table (for customer registration - optional)
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =====================
-- INSERT SAMPLE DATA
-- =====================

-- Admin (password: admin123)
INSERT INTO admin (username, password) VALUES 
('admin', '$2y$10$8K1p/a0dL1LXMc0fwP.NQOHHqL.GzK.MhuKz0k5jXKvJB5xhGKKWu');

-- Settings
INSERT INTO settings (site_title, site_about, site_email, site_phone) VALUES 
('Grand Hotel', 'Welcome to Grand Hotel, your perfect destination for luxury and comfort. We offer world-class amenities and exceptional service to make your stay memorable.', 'info@grandhotel.com', '+1 234 567 8900');

-- Sample Rooms
INSERT INTO rooms (name, description, price, adults, children, area, status) VALUES 
('Standard Room', 'Comfortable room with all basic amenities. Perfect for budget travelers.', 99.00, 2, 0, 250, 1),
('Deluxe Room', 'Spacious room with premium amenities and city view.', 149.00, 2, 1, 350, 1),
('Family Suite', 'Large suite ideal for families, with separate living area.', 249.00, 4, 2, 500, 1),
('Presidential Suite', 'Luxurious suite with panoramic views and exclusive services.', 499.00, 2, 2, 800, 1);

-- Features
INSERT INTO features (name) VALUES 
('Air Conditioning'),
('Free WiFi'),
('Flat Screen TV'),
('Mini Bar'),
('Room Service'),
('Safe Box'),
('Hair Dryer'),
('Coffee Maker');

-- Facilities
INSERT INTO facilities (name, description, icon) VALUES 
('Swimming Pool', 'Olympic size outdoor pool', 'bi-water'),
('Fitness Center', '24/7 gym with modern equipment', 'bi-heart-pulse'),
('Restaurant', 'Fine dining restaurant', 'bi-cup-hot'),
('Spa & Wellness', 'Relaxing spa treatments', 'bi-flower1'),
('Free Parking', 'Secure parking for guests', 'bi-car-front'),
('Business Center', 'Meeting rooms and office facilities', 'bi-briefcase');

-- Room Features (linking rooms to features)
INSERT INTO room_features (room_id, feature_id) VALUES 
(1, 1), (1, 2), (1, 3),
(2, 1), (2, 2), (2, 3), (2, 4), (2, 5),
(3, 1), (3, 2), (3, 3), (3, 4), (3, 5), (3, 6),
(4, 1), (4, 2), (4, 3), (4, 4), (4, 5), (4, 6), (4, 7), (4, 8);

-- Room Facilities (linking rooms to facilities)
INSERT INTO room_facilities (room_id, facility_id) VALUES 
(1, 5),
(2, 1), (2, 5),
(3, 1), (3, 2), (3, 3), (3, 5),
(4, 1), (4, 2), (4, 3), (4, 4), (4, 5), (4, 6);
