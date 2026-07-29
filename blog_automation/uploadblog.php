<?php

declare(strict_types=1);
require __DIR__ . '/config.php';
require __DIR__ . '/includes/csrf.php';
require __DIR__ . '/includes/functions.php';

$success = isset($_GET['uploaded']);
$error = $_SESSION['upload_error'] ?? '';
unset($_SESSION['upload_error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload Blog | Media Jungle Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <style>
    body { background:#0f1220; font-family:'Poppins',sans-serif; color:#e6e7f0; }
    .topbar { background:#171b30; border-bottom:1px solid #2a2f4a; padding:.9rem 0; }
    .card-panel { background:#171b30; border:1px solid #2a2f4a; border-radius:14px; padding:2rem; }
    .form-label { color:#c7c9dd; font-weight:500; }
    .form-control { background:#0f1220; border:1px solid #33385a; color:#fff; }
    .form-control:focus { background:#0f1220; color:#fff; border-color:#7c5cff; box-shadow:0 0 0 .2rem rgba(124,92,255,.25); }
    .btn-submit { background:#7c5cff; border:none; padding:.65rem 1.6rem; font-weight:600; }
    .btn-submit:hover { background:#6a48ff; color:#fff; }
    .hint { color:#8a8fb0; font-size:.85rem; }
  </style>
</head>
<body>

  <div class="topbar">
    <div class="container">
      <span class="fw-bold text-white"><i class="bi bi-journal-plus"></i> Media Jungle &mdash; Blog Admin</span>
    </div>
  </div>

  <div class="container py-5" style="max-width:720px;">
    <div class="card-panel">
      <h1 class="h4 text-white mb-4">Upload New Blog</h1>

      <?php if ($success): ?>
        <div class="alert alert-success">Blog uploaded successfully.</div>
      <?php endif; ?>

      <?php if ($error !== ''): ?>
        <div class="alert alert-danger"><?= h($error) ?></div>
      <?php endif; ?>

      <form action="upload_blog_process.php" method="post" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="csrf_token" value="<?= h(csrf_token()) ?>">

        <div class="mb-3">
          <label class="form-label" for="thumbnail">Thumbnail Image</label>
          <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" required>
          <div class="hint">JPG, PNG, or WEBP. Max 5MB.</div>
        </div>

        <div class="mb-3">
          <label class="form-label" for="title">Blog Title</label>
          <input type="text" class="form-control" id="title" name="title" maxlength="255" required
                 placeholder="How Media Jungle Ensures Complete Ownership of Your OTT Content">
        </div>

        <div class="mb-3">
          <label class="form-label" for="description">Blog Description</label>
          <textarea class="form-control" id="description" name="description" rows="4" required
                    placeholder="Short description shown on the blog card"></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label" for="html_file">Upload HTML File</label>
          <input type="file" class="form-control" id="html_file" name="html_file" accept=".html,.htm,text/html" required>
          <div class="hint">.html or .htm file that opens when a visitor clicks "5 MIN READ". Max 2MB.</div>
        </div>

        <div class="mb-4">
          <label class="form-label" for="publish_date">Publish Date</label>
          <input type="date" class="form-control" id="publish_date" name="publish_date" required>
        </div>

        <button type="submit" class="btn btn-submit text-white">
          <i class="bi bi-cloud-upload"></i> Upload Blog
        </button>
      </form>
    </div>
  </div>

</body>
</html>
