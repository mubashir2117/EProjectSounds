DROP DATABASE IF EXISTS music;
CREATE DATABASE music;
USE music;

-- ==========================
-- Genre Table
-- ==========================

CREATE TABLE genre (
    id INT AUTO_INCREMENT PRIMARY KEY,
    genre_name VARCHAR(100) NOT NULL
);

INSERT INTO genre VALUES
(1,'Pop Music'),
(3,'Hip Hop'),
(4,'Punjabi'),
(5,'Rap Music'),
(6,'Love'),
(7,'House music');

-- ==========================
-- Artist Table
-- ==========================

CREATE TABLE artist (
    Artist_id INT AUTO_INCREMENT PRIMARY KEY,
    artist_name VARCHAR(100) NOT NULL,
    artist_image VARCHAR(255) NOT NULL,
    genre_id INT,

    CONSTRAINT fk_artist_genre
    FOREIGN KEY (genre_id)
    REFERENCES genre(id)
);

INSERT INTO artist VALUES
(1,'Atif Aslam','images/13a5f8787e819d247abb25cf36651d8f.jpg',6),
(2,'Aima Baig','images/2155225-aima-1581489971.jpeg',1),
(3,'Arijit Singh','images/Arijit Singh.jpg',4),
(4,'Ali Zafar','images/alizafar.jpg',3),
(5,'Asim Azhar','images/asim.jpg',3),
(6,'Talha Anjum','images/talha.jpg',5),
(7,'Bilal Saeed','images/bilal3.jfif',1),
(8,'Qurat-ul-Ain Baloch','images/carousal3.webp',4),
(9,'Rahat Fateh Ali Khan','images/rahat.jpg',7),
(10,'Shae Gill','images/shaegill.jpg',1),
(11,'Momina Mustehsan','images/momina1.jpg',4),
(12,'Neha Kakkar','images/neha.jpg',7);

-- ==========================
-- Song Table
-- ==========================

CREATE TABLE song (
    song_id INT AUTO_INCREMENT PRIMARY KEY,
    song_name VARCHAR(100) NOT NULL,
    song_file VARCHAR(255) NOT NULL,
    song_image VARCHAR(255) NOT NULL,
    genre_id INT,
    Artists_id INT,

    CONSTRAINT fk_song_genre
    FOREIGN KEY (genre_id)
    REFERENCES genre(id),

    CONSTRAINT fk_song_artist
    FOREIGN KEY (Artists_id)
    REFERENCES artist(Artist_id)
);

INSERT INTO song VALUES
(15,'Pehli Dafa',
'audio/Pehli-Dafa---Atif-Aslam(pagalworld.co.uk).mp3',
'images/thumb-pehli-dafa-atif-aslam-mp3-song111-300.jpg',
6,1),

(16,'Dil Lagi',
'audio/Ashleel Tuesdays And Fridays 320 Kbps.mp3',
'images/Yaariyan.jpg',
7,9);

-- ==========================
-- Video Table
-- ==========================

CREATE TABLE video (
    video_id INT AUTO_INCREMENT PRIMARY KEY,
    video_name VARCHAR(100) NOT NULL,
    video_file VARCHAR(255) NOT NULL,
    video_poster VARCHAR(255),
    genre_id INT,
    Artists_id INT,

    CONSTRAINT fk_video_genre
    FOREIGN KEY (genre_id)
    REFERENCES genre(id),

    CONSTRAINT fk_video_artist
    FOREIGN KEY (Artists_id)
    REFERENCES artist(Artist_id)
);

INSERT INTO video VALUES
(2,
'Do Gallan',
'video/DO GALLAN - Neha Kakkar & Rohanpreet Singh _ Garry Sandhu _ Anshul Garg _ Punjabi Song 2021.mp4',
'images/',
6,
12),

(4,
'Rafta Rafta',
'video/Rafta Rafta - Official Music Video _ Raj Ranjodh _ Atif Aslam Ft. Sajal Ali _ Tarish Music.mp4',
'images/',
6,
1),

(6,
'Washmallay',
'video/Washmallay _ Sahir Ali Bagga _ Aima Baig _ Official Music Video _ 4K Video.mp4',
'images/Washmallay.jpg',
4,
2);

-- ==========================
-- Roles Table
-- ==========================

CREATE TABLE roles (
    r_id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL
);

INSERT INTO roles VALUES
(1,'Admin'),
(2,'User');

-- ==========================
-- Users Table
-- ==========================

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(50) NOT NULL,
    user_email VARCHAR(100) NOT NULL,
    user_password VARCHAR(255) NOT NULL,
    user_image VARCHAR(255),
    role_id INT,

    CONSTRAINT fk_user_role
    FOREIGN KEY (role_id)
    REFERENCES roles(r_id)
);

INSERT INTO users VALUES
(1,'admin','admin@gmail.com','admin123','',1),
(2,'ali','ali@gmail.com','123','',1),
(3,'mubashir','mubashir@gmail.com','123456','',1);

-- ==========================
-- Contact Table
-- ==========================

CREATE TABLE contact (
    contact_id INT AUTO_INCREMENT PRIMARY KEY,
    c_name VARCHAR(100) NOT NULL,
    c_email VARCHAR(100) NOT NULL,
    reviews VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO contact (c_name, c_email, reviews, message) VALUES
('Ali Khan', 'ali@gmail.com', 'Excellent', 'Your website is amazing.'),
('Ahmed', 'ahmed@gmail.com', 'Very Good', 'I really enjoyed the music collection.'),
('Sara', 'sara@gmail.com', 'Awesome', 'Keep adding more songs.');