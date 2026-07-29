<?php
/**
 * includes/csrf.php
 * -----------------------------------------------------------------
 * Lightweight CSRF token helpers used by the blog upload form.
 * (Login/logout was intentionally removed from this package —
 * uploadblog.php is currently open to anyone who has the URL.
 * If you want it restricted again, add your own auth check at the
 * top of uploadblog.php and upload_blog_process.php.)
 * -----------------------------------------------------------------
 */

declare(strict_types=1);

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token(?string $token): bool
{
    return is_string($token) && !empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
