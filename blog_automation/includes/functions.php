<?php
/**
 * includes/functions.php
 * -----------------------------------------------------------------
 * Reusable helpers for the blog CMS: fetching paginated blogs,
 * safe output escaping, and secure file uploads.
 * -----------------------------------------------------------------
 */

declare(strict_types=1);

/** Shorthand for htmlspecialchars() with sane defaults (XSS protection). */
function h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Fetch one page of blogs (newest first) plus the total page count.
 *
 * @return array{blogs: array<int, array<string, mixed>>, totalPages: int, currentPage: int}
 */
function get_blogs_paginated(PDO $pdo, int $page, int $perPage = BLOGS_PER_PAGE): array
{
    $page = max(1, $page);

    $total = (int) $pdo->query('SELECT COUNT(*) FROM blogs')->fetchColumn();
    $totalPages = max(1, (int) ceil($total / $perPage));
    $page = min($page, $totalPages);

    $offset = ($page - 1) * $perPage;

    $stmt = $pdo->prepare(
        'SELECT id, title, description, thumbnail, html_file, publish_date, created_at
         FROM blogs
         ORDER BY created_at DESC
         LIMIT :limit OFFSET :offset'
    );
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    return [
        'blogs'       => $stmt->fetchAll(),
        'totalPages'  => $totalPages,
        'currentPage' => $page,
    ];
}

/**
 * Validate and move an uploaded image into BLOG_IMAGE_DIR.
 * Returns the public relative path (e.g. "uploads/blog_images/xxxx.jpg").
 *
 * @throws RuntimeException on any validation failure.
 */
function handle_thumbnail_upload(array $file): string
{
    validate_upload_error($file, 'Thumbnail image');

    if ($file['size'] <= 0 || $file['size'] > MAX_IMAGE_SIZE_BYTES) {
        throw new RuntimeException('Thumbnail image must be smaller than ' . (MAX_IMAGE_SIZE_BYTES / 1024 / 1024) . 'MB.');
    }

    // Verify the real MIME type server-side (never trust the client).
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']) ?: '';

    if (!array_key_exists($mime, ALLOWED_IMAGE_MIME_TYPES)) {
        throw new RuntimeException('Thumbnail must be a JPG, PNG, or WEBP image.');
    }

    // Confirm it's really a decodable image (blocks disguised files).
    if (@getimagesize($file['tmp_name']) === false) {
        throw new RuntimeException('The uploaded thumbnail is not a valid image file.');
    }

    $extension = ALLOWED_IMAGE_MIME_TYPES[$mime];
    $filename = bin2hex(random_bytes(16)) . '.' . $extension;
    $destination = BLOG_IMAGE_DIR . $filename;

    if (!is_dir(BLOG_IMAGE_DIR) && !mkdir(BLOG_IMAGE_DIR, 0755, true) && !is_dir(BLOG_IMAGE_DIR)) {
        throw new RuntimeException('Server error: unable to prepare image upload directory.');
    }

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        throw new RuntimeException('Server error: failed to save the thumbnail image.');
    }

    return BLOG_IMAGE_URL_BASE . $filename;
}

/**
 * Validate and move an uploaded .html/.htm article file into BLOG_HTML_DIR.
 * Returns the public relative path.
 *
 * @throws RuntimeException on any validation failure.
 */
function handle_article_html_upload(array $file): string
{
    validate_upload_error($file, 'Blog HTML file');

    if ($file['size'] <= 0 || $file['size'] > MAX_HTML_SIZE_BYTES) {
        throw new RuntimeException('HTML file must be smaller than ' . (MAX_HTML_SIZE_BYTES / 1024 / 1024) . 'MB.');
    }

    $originalName = $file['name'];
    $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    if (!in_array($extension, ['html', 'htm'], true)) {
        throw new RuntimeException('The article file must have a .html or .htm extension.');
    }

    // Basic content sanity check: real HTML files are plain text, not
    // executables/scripts disguised with a .html extension.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']) ?: '';
    $allowedHtmlMimes = ['text/html', 'text/plain', 'application/xhtml+xml'];

    if (!in_array($mime, $allowedHtmlMimes, true)) {
        throw new RuntimeException('The uploaded file does not look like a valid HTML file.');
    }

    $filename = bin2hex(random_bytes(16)) . '.' . $extension;
    $destination = BLOG_HTML_DIR . $filename;

    if (!is_dir(BLOG_HTML_DIR) && !mkdir(BLOG_HTML_DIR, 0755, true) && !is_dir(BLOG_HTML_DIR)) {
        throw new RuntimeException('Server error: unable to prepare HTML upload directory.');
    }

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        throw new RuntimeException('Server error: failed to save the HTML file.');
    }

    return BLOG_HTML_URL_BASE . $filename;
}

/** Translate PHP's raw upload error codes into friendly exceptions. */
function validate_upload_error(array $file, string $label): void
{
    if (!isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        throw new RuntimeException("$label is required.");
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException("$label failed to upload (error code {$file['error']}).");
    }

    if (!is_uploaded_file($file['tmp_name'])) {
        throw new RuntimeException("$label upload could not be verified.");
    }
}

/** Build the "Previous 1 2 3 Next" pagination links, preserving query params. */
function render_pagination(int $currentPage, int $totalPages, string $baseUrl = ''): string
{
    if ($totalPages <= 1) {
        return '';
    }

    $baseUrl = $baseUrl !== '' ? $baseUrl : strtok($_SERVER['REQUEST_URI'] ?? '', '?');

    $link = static fn(int $p): string => h($baseUrl) . '?page=' . $p;

    $html = '<nav class="blog-pagination-nav" aria-label="Blog pagination"><ul class="pagination blog-pagination justify-content-center">';

    // Previous
    if ($currentPage > 1) {
        $html .= '<li class="page-item"><a class="page-link" href="' . $link($currentPage - 1) . '">Previous</a></li>';
    } else {
        $html .= '<li class="page-item disabled"><span class="page-link">Previous</span></li>';
    }

    // Numbered pages
    for ($p = 1; $p <= $totalPages; $p++) {
        $activeClass = $p === $currentPage ? ' active' : '';
        $html .= '<li class="page-item' . $activeClass . '">';
        $html .= $p === $currentPage
            ? '<span class="page-link">' . $p . '</span>'
            : '<a class="page-link" href="' . $link($p) . '">' . $p . '</a>';
        $html .= '</li>';
    }

    // Next
    if ($currentPage < $totalPages) {
        $html .= '<li class="page-item"><a class="page-link" href="' . $link($currentPage + 1) . '">Next</a></li>';
    } else {
        $html .= '<li class="page-item disabled"><span class="page-link">Next</span></li>';
    }

    $html .= '</ul></nav>';

    return $html;
}
