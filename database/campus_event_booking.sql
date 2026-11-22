-- Campus Event Booking System database
CREATE DATABASE IF NOT EXISTS campus_event_booking
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE campus_event_booking;

-- Table 1: users (students සහ admins)
CREATE TABLE IF NOT EXISTS users (
    user_id     INT AUTO_INCREMENT PRIMARY KEY,
    full_name   VARCHAR(100) NOT NULL,
    student_id  VARCHAR(20) UNIQUE NULL,
    email       VARCHAR(100) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    role        ENUM('student','admin') NOT NULL DEFAULT 'student',
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table 2: events
CREATE TABLE IF NOT EXISTS events (
    event_id      INT AUTO_INCREMENT PRIMARY KEY,
    title         VARCHAR(150) NOT NULL,
    description   TEXT,
    category      VARCHAR(50) NOT NULL,
    venue         VARCHAR(100) NOT NULL,
    event_date    DATE NOT NULL,
    event_time    TIME NOT NULL,
    total_seats   INT NOT NULL,
    ticket_price  DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table 3: bookings
CREATE TABLE IF NOT EXISTS bookings (
    booking_id        INT AUTO_INCREMENT PRIMARY KEY,
    user_id           INT NOT NULL,
    event_id          INT NOT NULL,
    seats             INT NOT NULL,
    unit_price        DECIMAL(10,2) NOT NULL,
    discount_percent  INT NOT NULL DEFAULT 0,
    total_amount      DECIMAL(10,2) NOT NULL,
    status            ENUM('confirmed','cancelled') NOT NULL DEFAULT 'confirmed',
    booked_at         TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id)  REFERENCES users(user_id),
    FOREIGN KEY (event_id) REFERENCES events(event_id)
);

-- Sample events (පරීක්ෂා කිරීමට)
INSERT INTO events (title, description, category, venue, event_date, event_time, total_seats, ticket_price) VALUES
('Web Development Workshop', 'Hands-on workshop on HTML, CSS and JavaScript.', 'Workshop', 'Lab 01', '2027-01-15', '09:00:00', 40, 500.00),
('AI & Future Careers Seminar', 'Guest speakers talk about careers in AI.', 'Seminar', 'Main Auditorium', '2027-01-22', '14:00:00', 100, 0.00),
('Inter-Faculty Music Night', 'An evening of music by NIIBS students.', 'Music', 'Open Air Theatre', '2027-02-05', '18:30:00', 150, 1000.00);