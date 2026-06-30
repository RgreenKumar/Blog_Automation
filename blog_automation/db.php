<?php
declare(strict_types=1);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = '';
const DB_NAME = 'blog_system';

function getDbConnection(): mysqli
{
    static $connection = null;

    if ($connection instanceof mysqli) {
        return $connection;
    }

    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $connection->set_charset('utf8mb4');
    ensureSchema($connection);

    return $connection;
}

function ensureSchema(mysqli $connection): void
{
    static $initialized = false;

    if ($initialized) {
        return;
    }

    $connection->query(
        "CREATE TABLE IF NOT EXISTS blogs (
            title VARCHAR(255) PRIMARY KEY,
            meta_description TEXT,
            thumbnail VARCHAR(500),
            content LONGTEXT NOT NULL,
            author VARCHAR(100) DEFAULT 'Admin',
            read_time VARCHAR(20) DEFAULT '5 MIN READ',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )"
    );

    $columns = [];
    $result = $connection->query('SHOW COLUMNS FROM blogs');

    while ($row = $result->fetch_assoc()) {
        $columns[] = $row['Field'];
    }

    if (!in_array('title', $columns, true) || in_array('slug', $columns, true)) {
        $connection->query('DROP TABLE blogs');
        $connection->query(
            "CREATE TABLE blogs (
                title VARCHAR(255) PRIMARY KEY,
                meta_description TEXT,
                thumbnail VARCHAR(500),
                content LONGTEXT NOT NULL,
                author VARCHAR(100) DEFAULT 'Admin',
                read_time VARCHAR(20) DEFAULT '5 MIN READ',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )"
        );
    }

    $initialized = true;
}
