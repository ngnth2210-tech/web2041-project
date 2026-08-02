<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Dashboard' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #0f172a;
            --sidebar-width: 260px;
            --accent: #6366f1;
            --accent-glow: rgba(99, 102, 241, 0.15);
            --topbar-h: 60px;
            --border: #e2e8f0;
            --surface: #f8fafc;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Be Vietnam Pro', sans-serif;
            background: var(--surface);
            color: #1e293b;
            margin: 0;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            z-index: 1000;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            text-decoration: none;
        }

        .sidebar-logo-icon {
            width: 36px;
            height: 36px;
            background: var(--accent);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 16px;
            flex-shrink: 0;
        }

        .sidebar-logo-text {
            font-weight: 700;
            font-size: 15px;
            color: #f1f5f9;
        }

        .sidebar-logo-sub {
            font-size: 10px;
            color: #475569;
        }

        .sidebar-nav {
            flex: 1;
            padding: 12px;
            overflow-y: auto;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 3px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        .nav-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #334155;
            padding: 12px 8px 4px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 9px 12px;
            border-radius: 8px;
            text-decoration: none;
            color: #94a3b8;
            font-size: 13.5px;
            font-weight: 500;
            transition: all .18s;
            margin-bottom: 1px;
        }

        .sidebar-nav a:hover {
            background: rgba(255, 255, 255, 0.06);
            color: #e2e8f0;
        }

        .sidebar-nav a.active {
            background: var(--accent-glow);
            color: #a5b4fc;
            border: 1px solid rgba(99, 102, 241, 0.3);
        }

        .sidebar-nav a i {
            width: 16px;
            text-align: center;
            font-size: 13px;
        }

        .sidebar-footer {
            padding: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 10px;
            border-radius: 9px;
            background: rgba(255, 255, 255, 0.04);
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 13px;
            flex-shrink: 0;
        }

        .user-name {
            font-size: 13px;
            font-weight: 600;
            color: #e2e8f0;
        }

        .user-role {
            font-size: 10px;
            color: #475569;
        }

        /* TOPBAR */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-h);
            background: #fff;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 12px;
            z-index: 900;
        }

        .topbar-title {
            font-size: 17px;
            font-weight: 700;
            color: #0f172a;
            flex: 1;
        }

        .topbar-title span {
            font-size: 12px;
            font-weight: 400;
            color: #94a3b8;
            display: block;
        }

        .topbar-btn {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            border: 1px solid var(--border);
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #64748b;
            transition: all .18s;
            text-decoration: none;
            font-size: 14px;
        }

        .topbar-btn:hover {
            background: var(--surface);
            color: var(--accent);
            border-color: #c7d2fe;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 9px;
            background: #fef2f2;
            color: #ef4444;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid #fee2e2;
            transition: all .18s;
        }

        .logout-btn:hover {
            background: #ef4444;
            color: #fff;
        }

        /* CONTENT */
        .main-content {
            margin-left: var(--sidebar-width);
            padding-top: var(--topbar-h);
            min-height: 100vh;
        }

        .page-content {
            padding: 24px;
        }

        /* CARDS */
        .card {
            border: 1px solid var(--border);
            border-radius: 13px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #f1f5f9;
            padding: 15px 20px;
            border-radius: 13px 13px 0 0 !important;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* TABLE */
        .table {
            font-size: 13.5px;
        }

        .table thead th {
            background: #f8fafc;
            font-weight: 600;
            font-size: 11.5px;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #64748b;
            padding: 11px 16px;
            border-bottom: 2px solid var(--border);
        }

        .table tbody td {
            padding: 11px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .table tbody tr:hover {
            background: #fafbff;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* BUTTONS */
        .btn {
            font-weight: 500;
            font-size: 13px;
            border-radius: 8px;
            transition: all .18s;
        }

        .btn-primary {
            background: var(--accent);
            border-color: var(--accent);
        }

        .btn-primary:hover {
            background: #4f46e5;
            border-color: #4f46e5;
            box-shadow: 0 4px 10px rgba(99, 102, 241, .28);
        }

        .btn-success {
            background: #10b981;
            border-color: #10b981;
        }

        .btn-success:hover {
            background: #059669;
            border-color: #059669;
        }

        .btn-danger {
            background: #ef4444;
            border-color: #ef4444;
        }

        .btn-danger:hover {
            background: #dc2626;
            border-color: #dc2626;
        }

        .btn-warning {
            background: #f59e0b;
            border-color: #f59e0b;
            color: #fff;
        }

        .btn-warning:hover {
            background: #d97706;
            border-color: #d97706;
            color: #fff;
        }

        .btn-sm {
            padding: 5px 12px;
            font-size: 12px;
        }

        /* BADGE */
        .badge {
            font-weight: 500;
            font-size: 11px;
            padding: 4px 8px;
            border-radius: 20px;
        }

        /* FORMS */
        .form-control,
        .form-select {
            border-radius: 9px;
            border: 1px solid var(--border);
            font-size: 13.5px;
            padding: 9px 13px;
            transition: all .18s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, .12);
        }

        .form-label {
            font-weight: 600;
            font-size: 13px;
            color: #374151;
            margin-bottom: 5px;
        }

        /* ALERT */
        .alert {
            border-radius: 10px;
            font-size: 13.5px;
        }
    </style>
</head>

<body>

    <aside class="sidebar">
        <a href="<?= BASE_URL_ADMIN ?>" class="sidebar-logo">
            <div class="sidebar-logo-icon"><i class="fas fa-leaf"></i></div>
            <div>
                <div class="sidebar-logo-text">FoodShop</div>
                <div class="sidebar-logo-sub">Admin Panel</div>
            </div>
        </a>
        <nav class="sidebar-nav">
            <div class="nav-label">Tổng quan</div>
            <a href="<?= BASE_URL_ADMIN ?>" class="<?= (!isset($_GET['action'])) ? 'active' : '' ?>">
                <i class="fas fa-gauge-high"></i> Dashboard
            </a>
            <a href="<?= BASE_URL_ADMIN ?>&action=statistic" class="<?= (($_GET['action'] ?? '') === 'statistic') ? 'active' : '' ?>">
                <i class="fas fa-chart-pie"></i> Thống kê
            </a>
            <div class="nav-label">Quản lý</div>
            <a href="<?= BASE_URL_ADMIN ?>&action=list-category" class="<?= (($_GET['action'] ?? '') === 'list-category') ? 'active' : '' ?>">
                <i class="fas fa-layer-group"></i> Danh mục
            </a>
            <a href="<?= BASE_URL_ADMIN ?>&action=list-product" class="<?= (($_GET['action'] ?? '') === 'list-product') ? 'active' : '' ?>">
                <i class="fas fa-box-open"></i> Sản phẩm
            </a>
            <a href="<?= BASE_URL_ADMIN ?>&action=list-order" class="<?= (($_GET['action'] ?? '') === 'list-order') ? 'active' : '' ?>">
                <i class="fas fa-receipt"></i> Đơn hàng
            </a>
            <a href="<?= BASE_URL_ADMIN ?>&action=list-user" class="<?= (($_GET['action'] ?? '') === 'list-user') ? 'active' : '' ?>">
                <i class="fas fa-users"></i> Người dùng
            </a>
            <a href="<?= BASE_URL_ADMIN ?>&action=list-comment" class="<?= (($_GET['action'] ?? '') === 'list-comment') ? 'active' : '' ?>">
                <i class="fas fa-comments"></i> Bình luận
            </a>
            <div class="nav-label">Liên kết</div>
            <a href="<?= BASE_URL ?>">
                <i class="fas fa-arrow-up-right-from-square"></i> Xem trang chủ
            </a>
        </nav>
        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="user-avatar"><?= strtoupper(substr($_SESSION['user_name'] ?? 'A', 0, 1)) ?></div>
                <div>
                    <div class="user-name"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?></div>
                    <div class="user-role">Administrator</div>
                </div>
            </div>
        </div>
    </aside>

    <header class="topbar">
        <div class="topbar-title">
            <?= $title ?? 'Dashboard' ?>
            <span>Hệ thống quản lý cửa hàng thực phẩm</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="<?= BASE_URL ?>" class="topbar-btn" title="Xem website"><i class="fas fa-globe"></i></a>
            <a href="<?= BASE_URL ?>?action=logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
        </div>
    </header>

    <main class="main-content">
        <div class="page-content">
            <?php
            if (isset($view)) {
                require_once PATH_VIEW_ADMIN . $view . '.php';
            } else {
                echo '
            <div class="p-4 rounded-3 text-white mb-4" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="fw-bold mb-1">Chào mừng trở lại! 👋</h4>
                        <p class="mb-0 opacity-75">Hôm nay là ' . date('d/m/Y') . ' — Chúc bạn làm việc hiệu quả.</p>
                    </div>
                    <div class="col-auto"><i class="fas fa-chart-line fa-3x opacity-25"></i></div>
                </div>
            </div>
            <div class="alert alert-info">Chào mừng đến trang Quản trị!</div>';
            }
            ?>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>