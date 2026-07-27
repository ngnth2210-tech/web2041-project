<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Quản trị') ?> — WEB2041</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <?php if (isset($extraStyles)) echo $extraStyles; ?>
</head>
<body class="admin-body">

<div class="admin-layout">
    <aside class="admin-sidebar">
        <a href="<?= BASE_URL_ADMIN ?>" class="admin-brand">
            <i class="fas fa-gauge-high"></i> Quản trị
        </a>
        <nav class="admin-nav">
            <a href="<?= BASE_URL_ADMIN ?>" class="active"><i class="fas fa-house"></i> Tổng quan</a>
            <a href="<?= BASE_URL ?>"><i class="fas fa-arrow-left"></i> Về trang người dùng</a>
        </nav>
    </aside>

    <main class="admin-content">
        <?php if (isset($view)) require_once PATH_VIEW_ADMIN . $view . '.php'; ?>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php if (isset($extraScripts)) echo $extraScripts; ?>
</body>
</html>
