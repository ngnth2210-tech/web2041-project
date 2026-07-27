<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'WEB2041 Project') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <?php if (isset($extraStyles)) echo $extraStyles; ?>
</head>
<body>

<header class="site-header">
    <div class="header-inner">
        <a href="<?= BASE_URL ?>" class="site-logo">
            <i class="fas fa-cube"></i> WEB2041
        </a>

        <nav class="nav-links">
            <a href="<?= BASE_URL ?>" class="<?= !isset($_GET['action']) ? 'active' : '' ?>">Trang chủ</a>
            <a href="<?= BASE_URL_ADMIN ?>">Quản trị</a>
        </nav>
    </div>
</header>

<main class="page-body">
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="container mt-3">
            <div class="alert alert-success"><?= e($_SESSION['success_message']) ?></div>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="container mt-3">
            <div class="alert alert-danger"><?= e($_SESSION['error_message']) ?></div>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <?php if (isset($view)) require_once PATH_VIEW_CLIENT . $view . '.php'; ?>
</main>

<footer class="site-footer">
    <div class="container text-center">
        &copy; <?= date('Y') ?> WEB2041 Project
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php if (isset($extraScripts)) echo $extraScripts; ?>
</body>
</html>
