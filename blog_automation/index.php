<?php
declare(strict_types=1);

require_once __DIR__ . '/helpers.php';

$connection = getDbConnection();
$result = $connection->query('SELECT title, meta_description, thumbnail, author, read_time, created_at, content FROM blogs ORDER BY created_at DESC');
$blogs = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acme Corporation — Insights & News</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <header class="company-bar">
    <nav class="navbar navbar-expand-lg navbar-dark site-navbar shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="index.php">Acme Corporation</a>
            <div class="d-flex gap-2">
                <a class="btn btn-outline-light btn-sm" href="#footer-company">Contact</a>
                <a class="btn btn-outline-light btn-sm" href="upload.php">Admin</a>
            </div>
        </div>
    </nav>
    </header>

    <header class="hero-strip page-with-fixed-bars">
        <div class="container py-5">
            <div class="row align-items-center gy-4">
                <div class="col-lg-7">
                    <span class="eyebrow">Acme Insights</span>
                    <h1 class="display-4 fw-bold mt-3 mb-3">We design products that people love</h1>
                    <p class="lead text-secondary mb-4">Thought leadership, product updates and engineering stories from the Acme team.</p>
                    <a href="#blogs" class="btn btn-primary btn-lg me-2">Explore Articles</a>
                    <a href="#footer-company" class="btn btn-outline-primary btn-lg">Get In Touch</a>
                </div>
                <div class="col-lg-5 d-none d-lg-block">
                    <div class="hero-visual rounded-4 shadow-sm p-4 h-100">
                        <div class="hero-visual-badge mb-4">Trusted by product teams</div>
                        <div class="hero-visual-stat">
                            <strong>120+</strong>
                            <span>Articles published</span>
                        </div>
                        <div class="hero-visual-stat">
                            <strong>8k</strong>
                            <span>Monthly readers</span>
                        </div>
                        <div class="hero-visual-stat mb-0">
                            <strong>24/7</strong>
                            <span>Publishing workflow</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="py-5 page-footer-safe">
        <div class="container">
            <section id="about" class="mb-5">
                <div class="row gx-4 gy-4 align-items-center">
                    <div class="col-md-6">
                        <h2 class="h3 fw-bold">About Acme</h2>
                        <p class="text-muted">Acme Corporation helps teams ship delightful software faster. We build robust components, share best practices, and publish engineering stories.</p>
                        <ul class="list-unstyled">
                            <li class="mb-2">• Product design & research</li>
                            <li class="mb-2">• Scalable engineering</li>
                            <li class="mb-2">• Developer tools and integrations</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <div class="info-chip p-4">Contact us at <strong>hello@acme.example</strong></div>
                    </div>
                </div>
            </section>

            <section id="blogs">
            <?php if ($blogs === []): ?>
                <div class="empty-state shadow-sm rounded-4 p-5 text-center bg-white">
                    <h2 class="h4 mb-3">No blogs published yet</h2>
                    <p class="text-muted mb-4">Upload your first `.html` file to populate the blog listing page.</p>
                    <a href="upload.php" class="btn btn-primary">Upload Blog</a>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($blogs as $blog): ?>
                        <div class="col-md-6 col-xl-4">
                            <article class="card blog-card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                                <?php if (!empty($blog['thumbnail'])): ?>
                                    <img
                                        src="<?= e($blog['thumbnail']) ?>"
                                        class="card-img-top blog-thumb"
                                        alt="<?= e($blog['title']) ?>"
                                    >
                                <?php else: ?>
                                    <div class="blog-thumb placeholder-thumb d-flex align-items-center justify-content-center">
                                        <span class="fw-semibold text-primary">No Image</span>
                                    </div>
                                <?php endif; ?>

                                <div class="card-body d-flex flex-column p-4">
                                    <div class="card-meta text-muted small mb-3">
                                        <span><?= e($blog['author']) ?></span>
                                        <span class="meta-separator"></span>
                                        <span><?= e($blog['read_time']) ?></span>
                                        <span class="meta-separator"></span>
                                        <span><?= e(formatBlogDate($blog['created_at'])) ?></span>
                                    </div>

                                    <h2 class="h4 card-title mb-3">
                                        <a class="stretched-link text-decoration-none text-dark" href="blog.php?title=<?= urlencode($blog['title']) ?>">
                                            <?= e($blog['title']) ?>
                                        </a>
                                    </h2>

                                    <p class="text-secondary mb-4">
                                        <?= e(excerpt($blog['meta_description'] !== '' ? $blog['meta_description'] : $blog['content'], 150)) ?>
                                    </p>

                                    <div class="mt-auto">
                                        <span class="btn btn-outline-primary rounded-pill px-3">Read More</span>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            </section>

            <section id="contact" class="mt-5">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="info-chip p-4 p-lg-5 d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                            <div>
                                <h2 class="h4 fw-bold mb-2">Let’s talk about your next project</h2>
                                <p class="mb-0 text-muted">Reach the Acme team for product, partnership, or media inquiries.</p>
                            </div>
                            <a class="btn btn-primary btn-lg" href="mailto:hello@acme.example">hello@acme.example</a>
                        </div>
                    </div>
                </div>
            </section>
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
