<?php

declare(strict_types=1);
require __DIR__ . '/config.php';
require __DIR__ . '/includes/csrf.php';
require __DIR__ . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: uploadblog.php');
    exit;
}

function fail(string $message): void
{
    $_SESSION['upload_error'] = $message;
    header('Location: uploadblog.php');
    exit;
}

if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
    fail('Your session expired. Please refresh the page and try again.');
}

// ---- Validate text fields -------------------------------------------------
$title = trim((string) ($_POST['title'] ?? ''));
$description = trim((string) ($_POST['description'] ?? ''));
$publishDate = trim((string) ($_POST['publish_date'] ?? ''));

$titleLength = function_exists('mb_strlen') ? mb_strlen($title) : strlen($title);
if ($title === '' || $titleLength > 255) {
    fail('Please provide a valid blog title (max 255 characters).');
}

if ($description === '') {
    fail('Please provide a blog description.');
}

$dateObj = DateTime::createFromFormat('Y-m-d', $publishDate);
if (!$dateObj || $dateObj->format('Y-m-d') !== $publishDate) {
    fail('Please provide a valid publish date.');
}

// ---- Validate + move uploaded files ---------------------------------------
try {
    $thumbnailPath = handle_thumbnail_upload($_FILES['thumbnail'] ?? []);
    $htmlPath = handle_article_html_upload($_FILES['html_file'] ?? []);
} catch (RuntimeException $e) {
    fail($e->getMessage());
}

// ---- Save to database (prepared statement -> SQL injection safe) ----------
try {
    $pdo = get_db();
    $stmt = $pdo->prepare(
        'INSERT INTO blogs (title, description, thumbnail, html_file, publish_date)
         VALUES (:title, :description, :thumbnail, :html_file, :publish_date)'
    );
    $stmt->execute([
        ':title'        => $title,
        ':description'  => $description,
        ':thumbnail'    => $thumbnailPath,
        ':html_file'    => $htmlPath,
        ':publish_date' => $publishDate,
    ]);
} catch (PDOException $e) {
    error_log('Blog insert failed: ' . $e->getMessage());
    // Clean up the files we just uploaded since the DB write failed.
    @unlink(__DIR__ . '/' . $thumbnailPath);
    @unlink(__DIR__ . '/' . $htmlPath);
    fail('Could not save the blog. Please try again.');
}

header('Location: uploadblog.php?uploaded=1');
exit;
