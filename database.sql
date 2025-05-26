CREATE DATABASE lokakos;
USE lokakos;

-- Hapus tabel jika sudah ada
-- DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role ENUM('pencari', 'pemilik') NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    no_hp VARCHAR(15) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert dengan password yang sudah di-hash dengan benar
INSERT INTO users (role, nama_lengkap, no_hp, email, password) VALUES
('pencari', 'Reyqal Syawalano Enka Widodo', '082396178481', 'akureyqal@gmail.com', '$2y$10$jiIvJGhNSxoBLUpehag9DODYylWACm.9CQP0GZxOULQv90HEz6zQS'), -- password: reyqal25
('pemilik', 'Putri Intan', '082312347421', 'putriintan@gmail.com', '$2y$10$PBNNAyG/GrkYeWDh.VwRRuSxTVZwgJiXMv1kXqcXqXkj04ZEcXtoO'); -- password: putri123
('pencari', 'Siti Syakirah', '082312345781', 'syakirah@gmail.com','$2y$10$.K0fiWX4o/2iRtRKwkHQf.9wCkLEmT0EnqcTnt4R0Wtr0r7uJWYdi')