<style>
.crumb-bar { background:#fafafa; border-bottom:1px solid #e5e7eb; padding:14px 0; margin-bottom:28px; font-size:13px; color:#6b7280; }
.crumb-bar a { color:#16a34a; text-decoration:none; }
.crumb-bar a:hover { text-decoration:underline; }

.detail-img { border:1px solid #e5e7eb; border-radius:16px; overflow:hidden; background:#f9fafb; height:420px; display:flex; align-items:center; justify-content:center; }
.detail-img img { width:100%; height:100%; object-fit:cover; }

.detail-cat { display:inline-block; font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#16a34a; background:#f0fdf4; padding:5px 12px; border-radius:50px; margin-bottom:12px; }
.detail-name { font-size:27px; font-weight:800; color:#111827; line-height:1.3; margin-bottom:10px; }
.detail-meta { display:flex; gap:18px; font-size:12.5px; color:#9ca3af; margin-bottom:18px; }
.detail-price { font-size:32px; font-weight:800; color:#dc2626; margin-bottom:18px; }

.spec-row { display:flex; padding:10px 0; border-bottom:1px dashed #e5e7eb; font-size:13.5px; }
.spec-label { width:130px; color:#6b7280; flex-shrink:0; }
.spec-value { color:#111827; font-weight:600; }
.in-stock { color:#16a34a; }
.no-stock { color:#dc2626; }

.qty-picker { display:inline-flex; align-items:center; border:1.5px solid #e5e7eb; border-radius:10px; overflow:hidden; }
.qty-picker button { border:none; background:#fafafa; width:38px; height:42px; font-size:16px; color:#4b5563; cursor:pointer; transition:background .18s; }
.qty-picker button:hover { background:#f0fdf4; color:#16a34a; }
.qty-picker input { border:none; width:56px; height:42px; text-align:center; font-size:14px; font-weight:700; font-family:inherit; color:#111827; outline:none; }

.btn-cart { display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:12px 30px; border-radius:10px; background:#16a34a; color:#fff; font-size:14px; font-weight:700; border:none; cursor:pointer; transition:all .18s; text-decoration:none; }
.btn-cart:hover { background:#15803d; color:#fff; }
.btn-cart:disabled { background:#9ca3af; cursor:not-allowed; }

.sec-title { font-size:17px; font-weight:800; color:#111827; margin-bottom:14px; padding-bottom:10px; border-bottom:2px solid #16a34a; display:inline-block; }
.desc-box { font-size:14px; line-height:1.85; color:#374151; white-space:pre-line; }

.cmt-item { border-bottom:1px solid #f3f4f6; padding:16px 0; display:flex; gap:12px; }
.cmt-avatar { width:40px; height:40px; border-radius:50%; background:#16a34a; color:#fff; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:15px; flex-shrink:0; }
.cmt-name { font-weight:700; font-size:13.5px; color:#111827; }
.cmt-date { font-size:11.5px; color:#9ca3af; }
.cmt-body { font-size:13.5px; color:#374151; margin:5px 0 0; line-height:1.7; white-space:pre-line; }
.cmt-form textarea { border:1.5px solid #e5e7eb; border-radius:11px; font-size:13.5px; font-family:inherit; padding:12px 14px; resize:vertical; }
.cmt-form textarea:focus { border-color:#16a34a; outline:none; box-shadow:none; }
.login-hint { background:#f9fafb; border:1px dashed #d1d5db; border-radius:11px; padding:20px; text-align:center; font-size:13.5px; color:#6b7280; }

.rel-card { border:1px solid #e5e7eb; border-radius:14px; overflow:hidden; background:#fff; transition:all .22s; height:100%; }
.rel-card:hover { border-color:#86efac; box-shadow:0 6px 20px rgba(22,163,74,.1); transform:translateY(-3px); }
.rel-card .rel-img { height:170px; overflow:hidden; background:#f9fafb; display:block; }
.rel-card .rel-img img { width:100%; height:100%; object-fit:cover; }
.rel-body { padding:12px 14px 14px; }
.rel-name { font-weight:700; font-size:13.5px; color:#111827; text-decoration:none; display:-webkit-box; -webkit-line-clamp:2; line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; margin-bottom:5px; }
.rel-name:hover { color:#16a34a; }
.rel-price { font-weight:800; font-size:15px; color:#dc2626; }
</style>

<!-- ĐƯỜNG DẪN -->
<div class="crumb-bar">
    <div class="container">
        <a href="<?= BASE_URL ?>">Trang chủ</a> <span class="mx-1">/</span>
        <a href="<?= BASE_URL ?>?action=list-product">Sản phẩm</a> <span class="mx-1">/</span>
        <?php if (!empty($category)): ?>
            <a href="<?= BASE_URL ?>?action=list-product&category_id=<?= $category['id'] ?>"><?= e($category['name']) ?></a>
            <span class="mx-1">/</span>
        <?php endif; ?>
        <span class="text-dark"><?= e($product['name']) ?></span>
    </div>
</div>

<div class="container pb-5">

    <!-- THÔNG TIN SẢN PHẨM -->
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="detail-img">
                <img src="<?= BASE_ASSETS_UPLOADS . $product['image'] ?>" alt="<?= e($product['name']) ?>">
            </div>
        </div>

        <div class="col-md-6">
            <?php if (!empty($category)): ?>
                <span class="detail-cat"><?= e($category['name']) ?></span>
            <?php endif; ?>

            <h1 class="detail-name"><?= e($product['name']) ?></h1>

            <div class="detail-meta">
                <span><i class="fas fa-eye me-1"></i><?= $product['view_count'] ?> lượt xem</span>
                <span><i class="fas fa-comment-dots me-1"></i><?= count($comments) ?> bình luận</span>
            </div>

            <div class="detail-price"><?= number_format($product['price']) ?>đ</div>

            <div class="mb-4">
                <?php if (!empty($product['weights'])): ?>
                    <div class="spec-row">
                        <div class="spec-label">Khối lượng</div>
                        <div class="spec-value"><?= e($product['weights']) ?></div>
                    </div>
                <?php endif; ?>
                <div class="spec-row">
                    <div class="spec-label">Tình trạng</div>
                    <div class="spec-value <?= $product['quantity'] > 0 ? 'in-stock' : 'no-stock' ?>">
                        <?php if ($product['quantity'] > 0): ?>
                            <i class="fas fa-check-circle me-1"></i>Còn <?= $product['quantity'] ?> sản phẩm
                        <?php else: ?>
                            <i class="fas fa-times-circle me-1"></i>Tạm hết hàng
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- CHỌN SỐ LƯỢNG + THÊM VÀO GIỎ -->
            <?php if ($product['quantity'] > 0): ?>
                <form action="<?= BASE_URL ?>?action=cart-add" method="POST" class="d-flex align-items-center gap-3 flex-wrap">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                    <div class="qty-picker">
                        <button type="button" onclick="stepQty(-1)">&minus;</button>
                        <input type="number" name="quantity" id="qtyInput" value="1"
                               min="1" max="<?= $product['quantity'] ?>">
                        <button type="button" onclick="stepQty(1)">&plus;</button>
                    </div>

                    <button type="submit" class="btn-cart">
                        <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
                    </button>
                </form>
            <?php else: ?>
                <button class="btn-cart" disabled>
                    <i class="fas fa-ban"></i> Tạm hết hàng
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- MÔ TẢ -->
    <div class="mb-5">
        <div class="sec-title">Mô tả sản phẩm</div>
        <div class="desc-box">
            <?= !empty($product['description'])
                ? nl2br(e($product['description']))
                : '<span class="text-muted">Sản phẩm này chưa có mô tả.</span>' ?>
        </div>
    </div>

    <!-- BÌNH LUẬN -->
    <div class="row mb-5" id="binh-luan">
        <div class="col-lg-8">
            <div class="sec-title">Bình luận (<?= count($comments) ?>)</div>

            <?php if (!empty($commentError)): ?>
                <div class="alert alert-danger mt-3"><i class="fas fa-circle-exclamation me-2"></i><?= e($commentError) ?></div>
            <?php endif; ?>

            <!-- Ô VIẾT BÌNH LUẬN -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <form action="<?= BASE_URL ?>?action=store-comment" method="POST" class="cmt-form mt-3 mb-2">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <textarea name="content" class="form-control mb-2" rows="3"
                              placeholder="Chia sẻ cảm nhận của bạn về sản phẩm này..." required></textarea>
                    <button type="submit" class="btn-cart" style="padding:9px 22px;font-size:13px;">
                        <i class="fas fa-paper-plane"></i> Gửi bình luận
                    </button>
                </form>
            <?php else: ?>
                <div class="login-hint mt-3">
                    <i class="fas fa-lock me-1"></i>
                    Vui lòng <a href="<?= BASE_URL ?>?action=login" class="fw-bold text-success text-decoration-none">đăng nhập</a>
                    để viết bình luận.
                </div>
            <?php endif; ?>

            <!-- DANH SÁCH BÌNH LUẬN -->
            <?php if (empty($comments)): ?>
                <p class="text-muted mt-4" style="font-size:13.5px;">Chưa có bình luận nào. Hãy là người đầu tiên!</p>
            <?php else: ?>
                <div class="mt-3">
                    <?php foreach ($comments as $cmt): ?>
                        <div class="cmt-item">
                            <div class="cmt-avatar"><?= strtoupper(mb_substr($cmt['username'], 0, 1)) ?></div>
                            <div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="cmt-name"><?= e($cmt['username']) ?></span>
                                    <span class="cmt-date"><?= date('d/m/Y H:i', strtotime($cmt['created_at'])) ?></span>
                                </div>
                                <p class="cmt-body"><?= nl2br(e($cmt['content'])) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- SẢN PHẨM CÙNG DANH MỤC -->
    <?php if (!empty($related)): ?>
        <div>
            <div class="sec-title">Sản phẩm cùng danh mục</div>
            <div class="row g-3 mt-1">
                <?php foreach ($related as $item): ?>
                    <div class="col-6 col-md-3">
                        <div class="rel-card">
                            <a href="<?= BASE_URL ?>?action=detail-product&id=<?= $item['id'] ?>" class="rel-img">
                                <img src="<?= BASE_ASSETS_UPLOADS . $item['image'] ?>" alt="<?= e($item['name']) ?>">
                            </a>
                            <div class="rel-body">
                                <a href="<?= BASE_URL ?>?action=detail-product&id=<?= $item['id'] ?>"
                                   class="rel-name"><?= e($item['name']) ?></a>
                                <div class="rel-price"><?= number_format($item['price']) ?>đ</div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<script>
function stepQty(step) {
    const input = document.getElementById('qtyInput');
    const max   = parseInt(input.max, 10);
    let value   = parseInt(input.value, 10) + step;

    if (isNaN(value) || value < 1) value = 1;
    if (value > max) value = max;

    input.value = value;
}
</script>
