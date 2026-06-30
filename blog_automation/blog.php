<?php
declare(strict_types=1);

require_once __DIR__ . '/helpers.php';

$blogTitle = trim((string) ($_GET['title'] ?? ''));

if ($blogTitle === '') {
    http_response_code(400);
    exit('Invalid blog title.');
}

$connection = getDbConnection();
$statement = $connection->prepare('SELECT * FROM blogs WHERE title = ? LIMIT 1');
$statement->bind_param('s', $blogTitle);
$statement->execute();
$result = $statement->get_result();
$blog = $result->fetch_assoc();

if (!$blog) {
    http_response_code(404);
    exit('Blog not found.');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($blog['title']) ?></title>
    <meta name="description" content="<?= e($blog['meta_description']) ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <header class="company-bar">
    <nav class="navbar navbar-expand-lg navbar-dark site-navbar shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="index.php">Acme Corporation</a>
            <div class="d-flex gap-2">
                <a class="btn btn-outline-light btn-sm" href="index.php">All Articles</a>
                <a class="btn btn-outline-light btn-sm" href="#footer-company">Contact</a>
            </div>
        </div>
    </nav>
    </header>

    <header class="blog-hero py-5 page-with-fixed-bars">
        <div class="container py-lg-4">
            <a href="index.php" class="back-link">&larr; Back to all articles</a>
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="hero-panel shadow-lg rounded-4 overflow-hidden bg-white">
                        <?php if (!empty($blog['thumbnail'])): ?>
                            <img src="<?= e($blog['thumbnail']) ?>" alt="<?= e($blog['title']) ?>" class="hero-image">
                        <?php endif; ?>

                        <div class="p-4 p-lg-5">
                            <span class="eyebrow">Acme Insights</span>
                            <h1 class="display-5 fw-bold mt-3 mb-4"><?= e($blog['title']) ?></h1>
                            <div class="card-meta text-muted mb-3">
                                <span><strong><?= e($blog['author']) ?></strong></span>
                                <span class="meta-separator"></span>
                                <span><?= e(formatBlogDate($blog['created_at'])) ?></span>
                                <span class="meta-separator"></span>
                                <span><?= e($blog['read_time']) ?></span>
                            </div>
                            <?php if (!empty($blog['meta_description'])): ?>
                                <p class="lead text-secondary mt-3 mb-0"><?= e($blog['meta_description']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="pb-5 page-footer-safe">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <article class="blog-content-wrap bg-white shadow-sm rounded-4 p-4 p-lg-5">
                        <?= $blog['content'] ?>
                    </article>
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
</body>
</html>
