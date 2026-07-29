<?php
/**
 * config.php
 * -----------------------------------------------------------------
 * Central configuration: database connection (PDO), admin auth
 * settings, and upload constraints. Included by every entry point.
 *
 * IMPORTANT: Edit the values in the "EDIT THESE" section below to
 * match your hosting environment before going live.
 * -----------------------------------------------------------------
 */

declare(strict_types=1);

// Don't leak errors to visitors in production. Flip DISPLAY_ERRORS
// to true only while debugging locally.
const DISPLAY_ERRORS = false;
ini_set('display_errors', DISPLAY_ERRORS ? '1' : '0');
error_reporting(E_ALL);

// -------------------------------------------------------------
// EDIT THESE: database credentials
// -------------------------------------------------------------
const DB_HOST = 'localhost';
const DB_NAME = 'mediajungle_blog';
const DB_USER = 'root';
const DB_PASS = 'root123';
const DB_CHARSET = 'utf8mb4';

// -------------------------------------------------------------
// Upload paths (relative to project root) and constraints
// -------------------------------------------------------------
const BLOG_IMAGE_DIR      = __DIR__ . '/uploads/blog_images/';
const BLOG_HTML_DIR       = __DIR__ . '/uploads/blog_html/';
const BLOG_IMAGE_URL_BASE = 'uploads/blog_images/';
const BLOG_HTML_URL_BASE  = 'uploads/blog_html/';

const MAX_IMAGE_SIZE_BYTES = 5 * 1024 * 1024;   // 5 MB
const MAX_HTML_SIZE_BYTES  = 2 * 1024 * 1024;   // 2 MB

const ALLOWED_IMAGE_MIME_TYPES = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/webp' => 'webp',
];

const BLOGS_PER_PAGE = 3;

// -------------------------------------------------------------
// PDO connection (shared everywhere via get_db())
// -------------------------------------------------------------
function get_db(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', DB_HOST, DB_NAME, DB_CHARSET);

    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    } catch (PDOException $e) {
        // Never expose raw DB errors to visitors.
        error_log('DB connection failed: ' . $e->getMessage());
        http_response_code(500);
        exit('Service temporarily unavailable. Please try again shortly.');
    }

    return $pdo;
}

// Start session once, used for the CSRF token on uploadblog.php.
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
    ]);
}
