<?php $title = 'Giỏ hàng'; ?>

<div class="container py-4">
    <h4 style="font-weight:800;margin-bottom:4px;"><i class="fas fa-shopping-basket me-2 text-success"></i>Giỏ hàng của bạn</h4>
    <p class="text-muted mb-4" style="font-size:13.5px;">Kiểm tra và chỉnh sửa trước khi thanh toán</p>

    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($_SESSION['success']) ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if(empty($cart)): ?>
    <div class="text-center py-5" style="background:#f9fafb;border-radius:16px;border:1px solid #e5e7eb;">
        <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" alt="" width="90" style="opacity:.3;margin-bottom:16px;">
        <h5 style="font-weight:700;color:#374151;">Giỏ hàng đang trống</h5>
        <p class="text-muted" style="font-size:13.5px;">Hãy thêm sản phẩm vào giỏ để tiếp tục mua sắm.</p>
        <a href="<?= BASE_URL ?>" class="btn btn-success px-4 rounded-pill mt-1">
            <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm
        </a>
    </div>

    <?php else: ?>
    <div class="row g-4">
        <!-- Cart Items -->
        <div class="col-lg-8">
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:14px;overflow:hidden;">
                <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;font-size:13px;font-weight:600;color:#6b7280;display:flex;gap:0;">
                    <span style="flex:1;">Sản phẩm</span>
                    <span style="width:140px;text-align:center;">Số lượng</span>
                    <span style="width:110px;text-align:right;">Thành tiền</span>
                    <span style="width:44px;"></span>
                </div>

                <?php foreach($cart as $id => $item): ?>
                <div style="display:flex;align-items:center;padding:14px 20px;border-bottom:1px solid #f9fafb;gap:14px;">
                    <!-- Image -->
                    <?php if(!empty($item['image'])): ?>
                        <img src="<?= BASE_ASSETS_UPLOADS . 'products/' . htmlspecialchars($item['image']) ?>" alt=""
                             style="width:60px;height:60px;object-fit:cover;border-radius:10px;border:1px solid #e5e7eb;flex-shrink:0;">
                    <?php else: ?>
                        <div style="width:60px;height:60px;background:#f3f4f6;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:22px;">📦</div>
                    <?php endif; ?>

                    <!-- Name -->
                    <div style="flex:1;">
                        <div style="font-weight:600;font-size:14px;color:#111827;"><?= htmlspecialchars($item['name']) ?></div>
                        <div style="font-size:12.5px;color:#9ca3af;margin-top:2px;"><?= number_format($item['price']) ?>đ / sản phẩm</div>
                    </div>

                    <!-- Qty -->
                    <div style="width:140px;">
                        <form method="POST" action="<?= BASE_URL ?>?action=cart-update"
                              style="display:flex;align-items:center;justify-content:center;gap:6px;">
                            <input type="hidden" name="product_id" value="<?= $id ?>">
                            <button type="button" onclick="changeQty(this,-1)"
                                    style="width:30px;height:30px;border-radius:8px;border:1.5px solid #e5e7eb;background:#fff;font-size:16px;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#374151;flex-shrink:0;">−</button>
                            <input type="number" name="quantity" value="<?= (int)$item['quantity'] ?>" min="1" max="999"
                                   style="width:46px;height:30px;border:1.5px solid #e5e7eb;border-radius:8px;text-align:center;font-size:13.5px;font-weight:600;outline:none;"
                                   onchange="this.form.submit()">
                            <button type="button" onclick="changeQty(this,1)"
                                    style="width:30px;height:30px;border-radius:8px;border:1.5px solid #e5e7eb;background:#fff;font-size:16px;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#374151;flex-shrink:0;">+</button>
                        </form>
                    </div>

                    <!-- Subtotal -->
                    <div style="width:110px;text-align:right;font-weight:700;color:#dc2626;font-size:14.5px;">
                        <?= number_format($item['price'] * $item['quantity']) ?>đ
                    </div>

                    <!-- Remove -->
                    <div style="width:44px;text-align:center;">
                        <a href="<?= BASE_URL ?>?action=cart-remove&id=<?= $id ?>"
                           onclick="return confirm('Xóa sản phẩm này?')"
                           style="width:30px;height:30px;border-radius:8px;background:#fef2f2;border:1px solid #fee2e2;color:#ef4444;display:inline-flex;align-items:center;justify-content:center;font-size:13px;text-decoration:none;transition:all .18s;"
                           title="Xóa"><i class="fas fa-trash-can"></i></a>
                    </div>
                </div>
                <?php endforeach; ?>

                <div style="padding:12px 20px;display:flex;justify-content:space-between;background:#fafafa;">
                    <a href="<?= BASE_URL ?>" class="btn btn-sm btn-light rounded-pill">
                        <i class="fas fa-arrow-left me-1"></i>Tiếp tục mua sắm
                    </a>
                    <a href="<?= BASE_URL ?>?action=cart-clear"
                       onclick="return confirm('Xóa toàn bộ giỏ hàng?')"
                       class="btn btn-sm" style="background:#fef2f2;color:#ef4444;border:1px solid #fee2e2;border-radius:20px;">
                        <i class="fas fa-trash me-1"></i>Xóa tất cả
                    </a>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:14px;padding:22px;position:sticky;top:80px;">
                <h6 style="font-weight:700;margin-bottom:16px;font-size:15px;">Tóm tắt đơn hàng</h6>

                <div style="display:flex;justify-content:space-between;margin-bottom:10px;font-size:13.5px;">
                    <span style="color:#6b7280;">Số lượng</span>
                    <span style="font-weight:600;"><?= array_sum(array_column($cart,'quantity')) ?> sản phẩm</span>
                </div>
                <div style="display:flex;justify-content:space-between;margin-bottom:10px;font-size:13.5px;">
                    <span style="color:#6b7280;">Tạm tính</span>
                    <span style="font-weight:600;"><?= number_format($total) ?>đ</span>
                </div>
                <div style="display:flex;justify-content:space-between;margin-bottom:14px;font-size:13.5px;">
                    <span style="color:#6b7280;">Phí vận chuyển</span>
                    <span style="font-weight:600;color:#16a34a;">Miễn phí</span>
                </div>
                <div style="border-top:1px solid #e5e7eb;padding-top:14px;display:flex;justify-content:space-between;margin-bottom:18px;">
                    <span style="font-weight:700;font-size:15px;">Tổng cộng</span>
                    <span style="font-weight:800;font-size:18px;color:#dc2626;"><?= number_format($total) ?>đ</span>
                </div>

                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="<?= BASE_URL ?>?action=order-create-cart"
                       style="display:flex;align-items:center;justify-content:center;gap:8px;padding:13px;background:#16a34a;color:#fff;border-radius:11px;font-weight:700;font-size:14px;text-decoration:none;transition:all .18s;">
                        <i class="fas fa-credit-card"></i> Đặt hàng ngay
                    </a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>?action=login"
                       style="display:flex;align-items:center;justify-content:center;gap:8px;padding:13px;background:#f59e0b;color:#fff;border-radius:11px;font-weight:700;font-size:14px;text-decoration:none;">
                        <i class="fas fa-sign-in-alt"></i> Đăng nhập để đặt hàng
                    </a>
                <?php endif; ?>

                <div style="margin-top:14px;padding:10px;background:#f0fdf4;border-radius:9px;font-size:12px;color:#15803d;text-align:center;">
                    <i class="fas fa-shield-halved me-1"></i>Thanh toán bảo mật 100%
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
function changeQty(btn, delta) {
    const form = btn.closest('form');
    const input = form.querySelector('input[name="quantity"]');
    const val = Math.max(1, parseInt(input.value) + delta);
    input.value = val;
    form.submit();
}
</script>
