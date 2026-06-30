<?php
declare(strict_types=1);

require_once __DIR__ . '/helpers.php';

$message = null;
$messageType = 'success';
$publishedTitle = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!isset($_FILES['blog_file'])) {
            throw new RuntimeException('Please choose an HTML file to upload.');
        }

        $file = $_FILES['blog_file'];

        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            throw new RuntimeException('The file upload failed. Please try again.');
        }

        $originalName = (string) ($file['name'] ?? '');
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        if ($extension !== 'html') {
            throw new RuntimeException('Only .html files are allowed.');
        }

        $safeName = preg_replace('/[^A-Za-z0-9._-]/', '-', basename($originalName)) ?? 'blog.html';
        $folderSlug = slugify(pathinfo($safeName, PATHINFO_FILENAME));
        $uploadFolderName = $folderSlug . '-' . date('YmdHis');
        $uploadFolderPath = __DIR__ . '/uploads/blogs/' . $uploadFolderName;
        $uploadDirectoryUrl = '/uploads/blogs/' . $uploadFolderName;

        if (!is_dir($uploadFolderPath) && !mkdir($uploadFolderPath, 0775, true) && !is_dir($uploadFolderPath)) {
            throw new RuntimeException('Unable to create the upload directory.');
        }

        $storedFilePath = $uploadFolderPath . '/' . $safeName;
        if (!move_uploaded_file($file['tmp_name'], $storedFilePath)) {
            throw new RuntimeException('Unable to move the uploaded file.');
        }

        $html = file_get_contents($storedFilePath);
        if ($html === false || trim($html) === '') {
            throw new RuntimeException('The uploaded HTML file is empty or unreadable.');
        }

        $blogData = extractBlogDataFromHtml($html, $uploadDirectoryUrl);

        $connection = getDbConnection();
        $statement = $connection->prepare(
            'INSERT INTO blogs (title, meta_description, thumbnail, content, author, read_time)
             VALUES (?, ?, ?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE
                meta_description = VALUES(meta_description),
                thumbnail = VALUES(thumbnail),
                content = VALUES(content),
                author = VALUES(author),
                read_time = VALUES(read_time)'
        );

        $author = 'Admin';
        $statement->bind_param(
            'ssssss',
            $blogData['title'],
            $blogData['meta_description'],
            $blogData['thumbnail'],
            $blogData['content'],
            $author,
            $blogData['read_time']
        );
        $statement->execute();

        $publishedTitle = $blogData['title'];
        $message = 'Blog uploaded and published successfully.';
        $messageType = 'success';
    } catch (Throwable $exception) {
        $message = $exception->getMessage();
        $messageType = 'danger';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acme — Upload Article</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <header class="company-bar">
    <nav class="navbar navbar-expand-lg navbar-dark site-navbar shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="index.php">Acme Corporation</a>
            <div class="d-flex gap-2">
                <a class="btn btn-outline-light btn-sm" href="index.php">Home</a>
                <a class="btn btn-outline-light btn-sm" href="#footer-company">Contact</a>
            </div>
        </div>
    </nav>
    </header>

    <main class="py-5 page-with-fixed-bars">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="page-intro text-center mb-4">
                        <span class="eyebrow">Admin Panel</span>
                        <h1 class="display-6 fw-bold mt-2">Publish an Article</h1>
                        <p class="text-muted mb-0">Upload an article as an HTML file; images and assets will be rewritten to the uploads folder.</p>
                    </div>

                    <?php if ($message !== null): ?>
                        <div class="alert alert-<?= e($messageType) ?> shadow-sm border-0 rounded-4">
                            <?= e($message) ?>
                            <?php if ($publishedTitle !== null && $messageType === 'success'): ?>
                                <div class="mt-2">
                                    <a class="alert-link" href="blog.php?title=<?= urlencode($publishedTitle) ?>">Open published blog</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="card border-0 shadow-lg rounded-4 upload-card">
                        <div class="card-body p-4 p-lg-5">
                            <form action="upload.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                                <div class="mb-4">
                                    <label for="blog_file" class="form-label fw-semibold">HTML file</label>
                                    <input
                                        type="file"
                                        class="form-control form-control-lg"
                                        id="blog_file"
                                        name="blog_file"
                                        accept=".html,text/html"
                                        required
                                    >
                                    <div class="form-text">Only .html files are accepted.</div>
                                </div>

                                <div class="d-flex flex-wrap gap-3">
                                    <button type="submit" class="btn btn-primary btn-lg px-4">Upload and Publish</button>
                                    <a href="index.php" class="btn btn-light btn-lg px-4 border">Back to Home</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer id="footer-company" class="company-footer">
        <div class="container">
            <div class="footer-copy">
                <strong>Acme Corporation</strong>
                <span>Product, engineering and publishing team</span>
            </div>
            <a class="btn btn-outline-light btn-sm" href="mailto:hello@acme.example">hello@acme.example</a>
        </div>
    </footer>

    <script>
        (() => {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach((form) => {
                form.addEventListener('submit', (event) => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>
</html>
