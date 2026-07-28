<style>
/* HOME PAGE STYLES */
.hero-banner { position:relative; overflow:hidden; border-radius:0; }
.hero-banner .carousel-item img { height:420px; object-fit:cover; width:100%; filter:brightness(0.85); }
.hero-caption { position:absolute; bottom:0; left:0; right:0; background:linear-gradient(transparent,rgba(0,0,0,0.6)); padding:40px 40px 30px; color:#fff; }
.hero-caption h2 { font-weight:800; font-size:28px; margin-bottom:6px; }
.hero-caption p { opacity:.85; margin:0; font-size:14px; }

.section-title { font-weight:800; font-size:20px; color:#111827; margin-bottom:4px; }
.section-subtitle { color:#6b7280; font-size:13.5px; margin-bottom:20px; }

.cat-chip { display:inline-flex; align-items:center; gap:6px; padding:7px 16px; border-radius:50px; font-size:13px; font-weight:600; text-decoration:none; border:1.5px solid #e5e7eb; color:#374151; background:#fff; transition:all .18s; margin:3px; }
.cat-chip:hover, .cat-chip.active { background:#16a34a; border-color:#16a34a; color:#fff; }

.product-card { border:1px solid #e5e7eb; border-radius:14px; overflow:hidden; background:#fff; transition:all .22s; }
.product-card:hover { border-color:#86efac; box-shadow:0 8px 28px rgba(22,163,74,.12); transform:translateY(-3px); }
.product-card .prod-img-wrap { height:200px; overflow:hidden; background:#f9fafb; display:flex; align-items:center; justify-content:center; }
.product-card .prod-img-wrap img { width:100%; height:100%; object-fit:cover; transition:transform .3s; }
.product-card:hover .prod-img-wrap img { transform:scale(1.04); }
.product-card .prod-body { padding:14px 16px 16px; }
.prod-name { font-weight:700; font-size:14px; color:#111827; text-decoration:none; display:block; margin-bottom:4px; overflow:hidden; display:-webkit-box; line-clamp: 2; -webkit-line-clamp:2; -webkit-box-orient:vertical; }
.prod-name:hover { color:#16a34a; }
.prod-price { font-weight:800; font-size:16px; color:#dc2626; }
.prod-views { font-size:11.5px; color:#9ca3af; }
.btn-buy { display:flex; align-items:center; justify-content:center; gap:6px; padding:8px; border-radius:9px; background:#16a34a; color:#fff; font-size:13px; font-weight:700; border:none; cursor:pointer; width:100%; margin-top:10px; transition:all .18s; text-decoration:none; }
.btn-buy:hover { background:#15803d; color:#fff; }

.news-card { border:1px solid #e5e7eb; border-radius:14px; overflow:hidden; transition:all .22s; background:#fff; }
.news-card:hover { box-shadow:0 6px 20px rgba(0,0,0,.08); transform:translateY(-2px); }
.news-card img { height:160px; object-fit:cover; width:100%; }
.news-card-body { padding:14px 16px; }
.news-date { font-size:11.5px; color:#9ca3af; margin-bottom:6px; }
.news-title { font-weight:700; font-size:14px; color:#111827; text-decoration:none; display:block; margin-bottom:6px; }
.news-title:hover { color:#16a34a; }
.news-excerpt { font-size:13px; color:#6b7280; margin:0; }

.promo-banner { background:linear-gradient(135deg,#16a34a,#059669); border-radius:16px; padding:32px; color:#fff; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px; margin:36px 0; }
.promo-banner h3 { font-weight:800; font-size:22px; margin-bottom:6px; }
.promo-banner p { margin:0; opacity:.85; font-size:14px; }
.promo-btn { padding:12px 26px; background:#fff; color:#16a34a; font-weight:700; font-size:14px; border-radius:50px; text-decoration:none; transition:all .18s; white-space:nowrap; }
.promo-btn:hover { background:#f0fdf4; color:#15803d; }
</style>

<!-- HERO CAROUSEL -->
<div class="hero-banner mb-4">
    <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="../assets/uploads/banner5.png" alt="Banner 1">
                <div class="hero-caption">
                    <h2>Thực phẩm sạch, tươi ngon mỗi ngày</h2>
                    <p>Giao hàng nhanh trong 2 giờ đến tận nhà bạn</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="../assets/uploads/banner6.png" alt="Banner 2">
                <div class="hero-caption">
                    <h2>Ưu đãi hấp dẫn mỗi tuần</h2>
                    <p>Tiết kiệm đến 40% cho các sản phẩm chọn lọc</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="../assets/uploads/banner7.png" alt="Banner 3">
                <div class="hero-caption">
                    <h2>Đặc sản vùng miền chính hiệu</h2>
                    <p>Chất lượng kiểm định, nguồn gốc rõ ràng</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>

<div class="container pb-5">

    <!-- CATEGORY FILTER -->
    <div class="mb-5">
        <div class="section-title">Danh mục sản phẩm</div>
        <div class="section-subtitle">Tìm kiếm theo danh mục yêu thích</div>
        <div>
            <a href="<?= BASE_URL ?>" class="cat-chip <?= (!isset($_GET['category_id']))?'active':'' ?>">
                <i class="fas fa-th-large"></i> Tất cả
            </a>
            <?php if(isset($categories) && is_array($categories)): ?>
                <?php foreach($categories as $cat): ?>
                <a href="<?= BASE_URL ?>?category_id=<?= $cat['id'] ?>"
                   class="cat-chip <?= (($_GET['category_id']??null)==$cat['id'])?'active':'' ?>">
                    <?= htmlspecialchars($cat['name']) ?>
                </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <?php if(isset($filteredProducts) && !empty($filteredProducts)): ?>
    <!-- FILTERED PRODUCTS -->
    <div class="mb-2 d-flex align-items-center justify-content-between">
        <div>
            <div class="section-title">Kết quả tìm kiếm</div>
            <div class="section-subtitle"><?= count($filteredProducts) ?> sản phẩm tìm thấy</div>
        </div>
        <a href="<?= BASE_URL ?>" class="btn btn-sm btn-light"><i class="fas fa-times me-1"></i>Xóa bộ lọc</a>
    </div>
    <div class="row g-3 mb-5">
        <?php foreach($filteredProducts as $pro): ?>
        <div class="col-6 col-md-3">
            <div class="product-card">
                <div class="prod-img-wrap">
                    <img src="<?= BASE_ASSETS_UPLOADS . $pro["image"] ?>" alt="<?= htmlspecialchars($pro["name"]) ?>">
                </div>
                <div class="prod-body">
                    <a href="<?= BASE_URL . '?action=detail-product&id=' . $pro["id"] ?>" class="prod-name"><?= htmlspecialchars($pro["name"]) ?></a>
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <span class="prod-price"><?= number_format($pro["price"]) ?>đ</span>
                        <span class="prod-views"><i class="fas fa-eye me-1"></i><?= $pro["view_count"] ?? 0 ?></span>
                    </div>
                    <a href="<?= BASE_URL . '?action=detail-product&id=' . $pro["id"] ?>" class="btn-buy">
                        <i class="fas fa-cart-plus"></i> Mua ngay
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php else: ?>

    <!-- NEW PRODUCTS -->
    <div class="mb-2 d-flex align-items-center justify-content-between">
        <div>
            <div class="section-title">Sản phẩm mới nhất</div>
            <div class="section-subtitle">Cập nhật hàng tuần, luôn mới lạ và hấp dẫn</div>
        </div>
        <a href="<?= BASE_URL ?>?action=list-product" class="btn btn-sm btn-light">Xem tất cả <i class="fas fa-arrow-right ms-1"></i></a>
    </div>
    <div class="row g-3 mb-2" id="product-list">
        <?php foreach($top4Lastest as $key => $pro): ?>
        <div class="col-6 col-md-3 product-item <?= ($key>=4)?'d-none':'' ?>">
            <div class="product-card">
                <div class="prod-img-wrap">
                    <img src="<?= BASE_ASSETS_UPLOADS . $pro["image"] ?>" alt="<?= htmlspecialchars($pro["name"]) ?>">
                </div>
                <div class="prod-body">
                    <a href="<?= BASE_URL . '?action=detail-product&id=' . $pro["id"] ?>" class="prod-name"><?= htmlspecialchars($pro["name"]) ?></a>
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <span class="prod-price"><?= number_format($pro["price"]) ?>đ</span>
                        <span class="prod-views"><i class="fas fa-eye me-1"></i><?= $pro["view_count"] ?? 0 ?></span>
                    </div>
                    <a href="<?= BASE_URL . '?action=detail-product&id=' . $pro["id"] ?>" class="btn-buy">
                        <i class="fas fa-cart-plus"></i> Mua ngay
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if(count($top4Lastest) > 4): ?>
    <div class="text-center mb-5">
        <button id="btn-load-more" class="btn btn-outline-success px-5 py-2 rounded-pill fw-600">
            <i class="fas fa-angle-down me-2"></i>Xem thêm sản phẩm
        </button>
    </div>
    <?php endif; ?>

    <!-- PROMO BANNER -->
    <div class="promo-banner">
        <div>
            <h3>🎁 Giảm ngay 20% đơn đầu tiên</h3>
            <p>Nhập mã <strong>WELCOME20</strong> khi thanh toán. Áp dụng đến hết tháng này.</p>
        </div>
        <a href="<?= BASE_URL ?>?action=list-product" class="promo-btn">Mua ngay</a>
    </div>

    <?php endif; ?>
