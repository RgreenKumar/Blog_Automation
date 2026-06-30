CREATE DATABASE IF NOT EXISTS blog_system;

USE blog_system;

DROP TABLE IF EXISTS blogs;

CREATE TABLE blogs (
    title VARCHAR(255) PRIMARY KEY,
    meta_description TEXT,
    thumbnail VARCHAR(500),
    content LONGTEXT NOT NULL,
    author VARCHAR(100) DEFAULT 'Admin',
    read_time VARCHAR(20) DEFAULT '5 MIN READ',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
