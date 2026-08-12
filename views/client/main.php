<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'FoodShop' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #16a34a;
            --primary-dark: #15803d;
            --primary-light: #dcfce7;
            --accent: #f59e0b;
            --text: #1a2e05;
            --muted: #6b7280;
            --border: #e5e7eb;
            --surface: #fafafa;
        }
        * { box-sizing: border-box; }
        body { font-family: 'Be Vietnam Pro', sans-serif; color: var(--text); margin: 0; background: #fff; }

        /* ── TOPBAR ── */
        .topbar-strip {
            background: var(--primary);
            color: #fff;
            font-size: 12.5px;
            padding: 6px 0;
            text-align: center;
        }

        /* ── HEADER ── */
        .site-header {
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: 14px 0;
            position: sticky;
            top: 0;
            z-index: 800;
            box-shadow: 0 1px 8px rgba(0,0,0,0.06);
        }

        .header-inner {
            display: flex;
            align-items: center;
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .site-logo {
            font-size: 22px;
            font-weight: 800;
            color: var(--primary);
            text-decoration: none;
            letter-spacing: -0.5px;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .site-logo i { font-size: 20px; }

        /* SEARCH */
        .header-search {
            flex: 1;
            max-width: 420px;
        }

        .search-wrap {
            display: flex;
            align-items: center;
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 50px;
            padding: 0 16px;
            transition: border-color 0.2s;
        }

        .search-wrap:focus-within { border-color: var(--primary); }

        .search-wrap input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 13.5px;
            font-family: inherit;
            padding: 9px 8px;
            flex: 1;
            color: var(--text);
        }

        .search-wrap button {
            border: none;
            background: transparent;
            color: var(--muted);
            cursor: pointer;
            font-size: 14px;
            padding: 0;
            transition: color 0.2s;
        }

        .search-wrap:focus-within button { color: var(--primary); }

        /* HEADER ACTIONS */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-left: auto;
        }

        .hdr-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.18s;
            border: 1.5px solid transparent;
            font-family: inherit;
            cursor: pointer;
            background: transparent;
        }

        .hdr-btn-outline {
            border-color: var(--border);
            color: var(--text);
        }

        .hdr-btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-light);
        }

        .hdr-btn-primary {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        .hdr-btn-primary:hover {
            background: var(--primary-dark);
            color: #fff;
        }

        .cart-btn {
            position: relative;
        }

        .cart-count {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #ef4444;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 5px 12px 5px 5px;
            border: 1.5px solid var(--border);
            border-radius: 50px;
            text-decoration: none;
            color: var(--text);
            font-size: 13px;
            font-weight: 600;
            transition: all 0.18s;
        }

        .user-pill:hover { border-color: var(--primary); color: var(--primary); }

        .user-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 12px;
        }

        /* NAV BAR */
        .main-nav {
            background: #fff;
            border-bottom: 1px solid var(--border);
        }

        .main-nav .container { display: flex; align-items: center; }

        .nav-links {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 2px;
        }

        .nav-links a {
            display: block;
            padding: 13px 18px;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--muted);
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            transition: color 0.18s;
            position: relative;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0; left: 18px; right: 18px;
            height: 2px;
            background: var(--primary);
            transform: scaleX(0);
            transition: transform 0.2s;
            border-radius: 2px;
        }

        .nav-links a:hover { color: var(--primary); }
        .nav-links a:hover::after { transform: scaleX(1); }
        .nav-links a.active { color: var(--primary); }
        .nav-links a.active::after { transform: scaleX(1); }

        /* PAGE CONTENT */
        .page-body { min-height: 60vh; }

        /* FOOTER */
        .site-footer {
            background: #111827;
            color: #9ca3af;
            padding: 48px 0 24px;
            margin-top: 64px;
        }

        .footer-brand { font-size: 20px; font-weight: 800; color: #fff; margin-bottom: 8px; }
        .footer-tagline { font-size: 13px; color: #6b7280; margin-bottom: 20px; }
        .footer-h { font-size: 13px; font-weight: 700; color: #e5e7eb; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 14px; }
        .footer-links { list-style: none; padding: 0; margin: 0; }
        .footer-links li { margin-bottom: 8px; }
        .footer-links a { color: #6b7280; text-decoration: none; font-size: 13.5px; transition: color 0.18s; }
        .footer-links a:hover { color: #fff; }
        .footer-bottom { border-top: 1px solid #1f2937; padding-top: 20px; margin-top: 36px; font-size: 12.5px; }

        /* SOCIAL */
        .social-links { display: flex; gap: 10px; margin-top: 16px; }
        .social-link {
            width: 36px; height: 36px;
            border-radius: 8px;
            background: #1f2937;
            display: flex; align-items: center; justify-content: center;
            color: #9ca3af;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.18s;
        }
        .social-link:hover { background: var(--primary); color: #fff; }

        /* ALERTS */
        .alert { border-radius: 10px; font-size: 13.5px; border: none; }
        .alert-success { background: #f0fdf4; color: #15803d; }
        .alert-danger { background: #fef2f2; color: #b91c1c; }

        /* CARDS */
        .product-card {
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
            transition: all 0.22s;
            background: #fff;
        }

        .product-card:hover {
            border-color: #bbf7d0;
            box-shadow: 0 6px 24px rgba(22,163,74,0.1);
            transform: translateY(-2px);
        }
    </style>

    <?php if(isset($extraStyles)) echo $extraStyles; ?>
</head>
<body>

<!-- TOP STRIP -->
<div class="topbar-strip">
    <i class="fas fa-truck me-1"></i> Miễn phí giao hàng cho đơn từ 199.000đ &nbsp;|&nbsp;
    Hotline: <strong>1800 xxxx</strong>
</div>

<!-- HEADER -->
<header class="site-header">
    <div class="header-inner">
        <a href="<?= BASE_URL ?>" class="site-logo">
            <i class="fas fa-leaf"></i> Ximishop
        </a>

        <div class="header-search">
            <form action="<?= BASE_URL ?>" method="GET">
                <input type="hidden" name="action" value="list-product">
                <div class="search-wrap">
                    <button type="submit"><i class="fas fa-search"></i></button>
                    <input type="text" name="keyword" placeholder="Tìm sản phẩm bạn muốn..."
                           value="<?= htmlspecialchars($_GET['keyword']??'') ?>">
                </div>
            </form>
        </div>

        <div class="header-actions">
            <?php if(isset($_SESSION['user_id'])): ?>
                <div class="user-pill">
                    <div class="user-avatar"><?= strtoupper(substr($_SESSION['user_name']??'U',0,1)) ?></div>
                    <?= htmlspecialchars($_SESSION['user_name']) ?>
                </div>
                <a href="<?= BASE_URL ?>?action=order-history" class="hdr-btn hdr-btn-outline" title="Lịch sử đơn hàng">
                    <i class="fas fa-clock-rotate-left"></i> Đơn hàng
                </a>
                <a href="<?= BASE_URL ?>?action=cart" class="hdr-btn hdr-btn-outline cart-btn" style="position:relative;">
                    <i class="fas fa-shopping-basket"></i> Giỏ hàng
                    <?php if(!empty($_SESSION['cart'])): ?>
                    <span class="cart-count"><?= count($_SESSION['cart']) ?></span>
                    <?php endif; ?>
                </a>
                <a href="<?= BASE_URL ?>?action=logout" class="hdr-btn hdr-btn-outline" style="color:#ef4444;border-color:#fecaca;">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>?action=login" class="hdr-btn hdr-btn-outline">Đăng nhập</a>
                <a href="<?= BASE_URL ?>?action=register" class="hdr-btn hdr-btn-primary">Đăng ký</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- NAV -->
<nav class="main-nav">
    <div class="container">
        <ul class="nav-links">
            <li><a href="<?= BASE_URL ?>" class="<?= (!isset($_GET['action']))?'active':'' ?>">Trang chủ</a></li>
            <li><a href="<?= BASE_URL ?>?action=list-product" class="<?= (($_GET['action'] ?? '') === 'list-product') ? 'active' : '' ?>">Sản phẩm</a></li>
            <li><a href="<?= BASE_URL ?>?action=about" class="<?= (($_GET['action'] ?? '') === 'about') ? 'active' : '' ?>">Về chúng tôi</a></li>
            <li><a href="<?= BASE_URL ?>?action=promotion" class="<?= (($_GET['action'] ?? '') === 'promotion') ? 'active' : '' ?>">Khuyến mãi</a></li>
            <li><a href="<?= BASE_URL ?>?action=contact" class="<?= (($_GET['action'] ?? '') === 'contact') ? 'active' : '' ?>">Liên hệ</a></li>
        </ul>
    </div>
</nav>

<!-- MAIN CONTENT -->
<div class="page-body">
    <?php if(isset($_SESSION['success_message'])): ?>
    <div class="container mt-3">
        <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i><?= $_SESSION['success_message'] ?></div>
    </div>
    <?php unset($_SESSION['success_message']); endif; ?>

    <?php if(isset($view)) { require_once PATH_VIEW_CLIENT . $view . '.php'; } ?>
</div>

<!-- FOOTER -->
<footer class="site-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="footer-brand"><i class="fas fa-leaf me-2"></i>FoodShop</div>
                <p class="footer-tagline">Thực phẩm sạch, giao nhanh tận nhà. Chất lượng là ưu tiên hàng đầu của chúng tôi.</p>
                <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-tiktok"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="col-md-2">
                <div class="footer-h">Danh mục</div>
                <ul class="footer-links">
                    <li><a href="#">Thực phẩm khô</a></li>
                    <li><a href="#">Đồ uống</a></li>
                    <li><a href="#">Snack & Bánh</a></li>
                    <li><a href="#">Gia vị</a></li>
                </ul>
            </div>
            <div class="col-md-2">
                <div class="footer-h">Hỗ trợ</div>
                <ul class="footer-links">
                    <li><a href="#">Hướng dẫn mua hàng</a></li>
                    <li><a href="#">Chính sách đổi trả</a></li>
                    <li><a href="#">Chính sách vận chuyển</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <div class="footer-h">Liên hệ</div>
                <ul class="footer-links">
                    <li><i class="fas fa-map-marker-alt me-2 text-green-400"></i>123 Đường ABC, Hà Nội</li>
                    <li class="mt-1"><i class="fas fa-phone me-2"></i>1800 xxxx</li>
                    <li class="mt-1"><i class="fas fa-envelope me-2"></i>hello@foodshop.vn</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom text-center">
            © <?= date('Y') ?> FoodShop. Bảo lưu mọi quyền.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php if(isset($extraScripts)) echo $extraScripts; ?>
</body>
</html>
