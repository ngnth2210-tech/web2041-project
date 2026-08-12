<style>
.page-head { background:linear-gradient(135deg,#f0fdf4,#ecfdf5); border-bottom:1px solid #e5e7eb; padding:28px 0; margin-bottom:28px; }
.page-head h1 { font-size:26px; font-weight:800; color:#111827; margin:0 0 4px; }
.page-head .crumb { font-size:13px; color:#6b7280; }
.page-head .crumb a { color:#16a34a; text-decoration:none; }
.page-head .crumb a:hover { text-decoration:underline; }

.filter-box { border:1px solid #e5e7eb; border-radius:14px; padding:18px; background:#fff; position:sticky; top:92px; }
.filter-title { font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:.6px; color:#111827; margin-bottom:12px; }
.cat-list { list-style:none; padding:0; margin:0; }
.cat-list li { margin-bottom:2px; }
.cat-list a { display:block; padding:8px 12px; border-radius:9px; font-size:13.5px; color:#4b5563; text-decoration:none; transition:all .18s; }
.cat-list a:hover { background:#f0fdf4; color:#16a34a; }
.cat-list a.active { background:#16a34a; color:#fff; font-weight:600; }

.product-card { border:1px solid #e5e7eb; border-radius:14px; overflow:hidden; background:#fff; transition:all .22s; height:100%; display:flex; flex-direction:column; }
.product-card:hover { border-color:#86efac; box-shadow:0 8px 28px rgba(22,163,74,.12); transform:translateY(-3px); }
.product-card .prod-img-wrap { height:200px; overflow:hidden; background:#f9fafb; display:flex; align-items:center; justify-content:center; }
.product-card .prod-img-wrap img { width:100%; height:100%; object-fit:cover; transition:transform .3s; }
.product-card:hover .prod-img-wrap img { transform:scale(1.04); }
.product-card .prod-body { padding:14px 16px 16px; display:flex; flex-direction:column; flex:1; }
.prod-cat { font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:.4px; color:#16a34a; margin-bottom:5px; }
.prod-name { font-weight:700; font-size:14px; color:#111827; text-decoration:none; display:-webkit-box; -webkit-line-clamp:2; line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; margin-bottom:6px; }
.prod-name:hover { color:#16a34a; }
.prod-price { font-weight:800; font-size:16px; color:#dc2626; }
.prod-views { font-size:11.5px; color:#9ca3af; }
.btn-buy { display:flex; align-items:center; justify-content:center; gap:6px; padding:8px; border-radius:9px; background:#16a34a; color:#fff; font-size:13px; font-weight:700; border:none; cursor:pointer; width:100%; margin-top:auto; transition:all .18s; text-decoration:none; }
.btn-buy:hover { background:#15803d; color:#fff; }
.out-stock { background:#9ca3af; pointer-events:none; }

.empty-box { border:1px dashed #d1d5db; border-radius:14px; padding:56px 20px; text-align:center; color:#6b7280; }
.empty-box i { font-size:38px; color:#d1d5db; margin-bottom:12px; }
</style>

<!-- ĐẦU TRANG -->
<div class="page-head">
    <div class="container">
        <div class="crumb"><a href="<?= BASE_URL ?>">Trang chủ</a> <span class="mx-1">/</span> Sản phẩm</div>
        <h1>
            <?php if (!empty($currentCategory)): ?>
                <?= e($currentCategory['name']) ?>
            <?php elseif ($keyword !== ''): ?>
                Kết quả cho &ldquo;<?= e($keyword) ?>&rdquo;
            <?php else: ?>
                Tất cả sản phẩm
            <?php endif; ?>
        </h1>
        <div class="crumb"><?= count($products) ?> sản phẩm</div>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4">

        <!-- BỘ LỌC DANH MỤC -->
        <div class="col-lg-3">
            <div class="filter-box">
                <div class="filter-title">Danh mục</div>
                <ul class="cat-list">
                    <li>
                        <a href="<?= BASE_URL ?>?action=list-product"
                           class="<?= empty($category_id) ? 'active' : '' ?>">Tất cả sản phẩm</a>
                    </li>
                    <?php foreach ($categories as $cat): ?>
                        <?php if (($cat['status'] ?? 1) == 0) continue; ?>
                        <li>
                            <a href="<?= BASE_URL ?>?action=list-product&category_id=<?= $cat['id'] ?>"
                               class="<?= ($category_id == $cat['id']) ? 'active' : '' ?>"><?= e($cat['name']) ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- LƯỚI SẢN PHẨM -->
        <div class="col-lg-9">
            <?php if (empty($products)): ?>
                <div class="empty-box">
                    <div><i class="fas fa-box-open"></i></div>
                    <p class="mb-3">Chưa có sản phẩm nào phù hợp.</p>
                    <a href="<?= BASE_URL ?>?action=list-product" class="btn btn-success btn-sm">Xem tất cả sản phẩm</a>
                </div>
            <?php else: ?>
                <div class="row g-3">
                    <?php foreach ($products as $pro): ?>
                        <div class="col-6 col-md-4">
                            <div class="product-card">
                                <a href="<?= BASE_URL ?>?action=detail-product&id=<?= $pro['id'] ?>" class="prod-img-wrap">
                                    <img src="<?= BASE_ASSETS_UPLOADS . $pro['image'] ?>" alt="<?= e($pro['name']) ?>">
                                </a>
                                <div class="prod-body">
                                    <div class="prod-cat"><?= e($pro['cat_name'] ?? '') ?></div>
                                    <a href="<?= BASE_URL ?>?action=detail-product&id=<?= $pro['id'] ?>"
                                       class="prod-name"><?= e($pro['name']) ?></a>
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <span class="prod-price"><?= number_format($pro['price']) ?>đ</span>
                                        <span class="prod-views"><i class="fas fa-eye me-1"></i><?= $pro['view_count'] ?? 0 ?></span>
                                    </div>
                                    <a href="<?= BASE_URL ?>?action=detail-product&id=<?= $pro['id'] ?>"
                                       class="btn-buy <?= ($pro['quantity'] ?? 0) <= 0 ? 'out-stock' : '' ?>">
                                        <?php if (($pro['quantity'] ?? 0) <= 0): ?>
                                            Tạm hết hàng
                                        <?php else: ?>
                                            <i class="fas fa-cart-plus"></i> Mua ngay
                                        <?php endif; ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>
