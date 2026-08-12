<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <!-- Success Banner -->
            <div style="text-align:center;margin-bottom:32px;">
                <div style="width:72px;height:72px;background:#dcfce7;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;margin-bottom:16px;font-size:32px;">✅</div>
                <h3 style="font-weight:800;color:#111827;margin-bottom:8px;">Đặt hàng thành công!</h3>
                <p style="color:#6b7280;font-size:14px;">Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ xác nhận và giao hàng sớm nhất.</p>
            </div>

            <!-- Order Info -->
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:14px;overflow:hidden;margin-bottom:16px;">
                <div style="padding:14px 20px;background:#f9fafb;border-bottom:1px solid #e5e7eb;font-weight:700;font-size:14px;">
                    <i class="fas fa-receipt me-2 text-success"></i>Đơn hàng #<?= $order['id'] ?>
                    <span style="float:right;font-size:11.5px;background:#fef9c3;color:#b45309;padding:3px 10px;border-radius:20px;font-weight:600;border:1px solid #fde68a;">Chờ xác nhận</span>
                </div>
                <div style="padding:16px 20px;">
                    <?php $rows = [
                        ['Người nhận','customer_name'],
                        ['Số điện thoại','customer_phone'],
                        ['Địa chỉ giao hàng','customer_address'],
                    ]; ?>
                    <?php foreach($rows as [$label,$key]): ?>
                    <div style="display:flex;gap:16px;margin-bottom:10px;font-size:13.5px;">
                        <span style="color:#6b7280;width:140px;flex-shrink:0;"><?= $label ?></span>
                        <span style="font-weight:600;color:#111827;"><?= htmlspecialchars($order[$key]) ?></span>
                    </div>
                    <?php endforeach; ?>
                    <?php if(!empty($order['note'])): ?>
                    <div style="display:flex;gap:16px;font-size:13.5px;">
                        <span style="color:#6b7280;width:140px;flex-shrink:0;">Ghi chú</span>
                        <span style="color:#6b7280;font-style:italic;"><?= htmlspecialchars($order['note']) ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Items Table -->
            <?php if(!empty($items)): ?>
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:14px;overflow:hidden;margin-bottom:20px;">
                <div style="padding:13px 20px;background:#f9fafb;border-bottom:1px solid #e5e7eb;font-weight:700;font-size:14px;">
                    <i class="fas fa-box me-2 text-primary"></i>Sản phẩm đã đặt
                </div>
                <?php foreach($items as $item): ?>
                <div style="display:flex;align-items:center;gap:14px;padding:14px 20px;border-bottom:1px solid #f9fafb;">
                    <img src="<?= BASE_ASSETS_UPLOADS . $item['product_image'] ?>" alt=""
                         style="width:52px;height:52px;object-fit:cover;border-radius:9px;border:1px solid #e5e7eb;flex-shrink:0;">
                    <div style="flex:1;">
                        <div style="font-weight:600;font-size:14px;color:#111827;"><?= htmlspecialchars($item['product_name']) ?></div>
                        <div style="font-size:12.5px;color:#9ca3af;">x<?= $item['quantity'] ?> — <?= number_format($item['price']) ?>đ/sản phẩm</div>
                    </div>
                    <div style="font-weight:700;color:#dc2626;font-size:15px;"><?= number_format($item['price']*$item['quantity']) ?>đ</div>
                </div>
                <?php endforeach; ?>
                <div style="padding:14px 20px;display:flex;justify-content:space-between;font-weight:800;font-size:16px;">
                    <span>Tổng cộng</span>
                    <span style="color:#dc2626;"><?= number_format($order['total_price']) ?>đ</span>
                </div>
            </div>
            <?php endif; ?>

            <div style="display:flex;gap:12px;justify-content:center;">
                <a href="<?= BASE_URL ?>"
                   style="padding:11px 24px;background:#16a34a;color:#fff;border-radius:11px;font-weight:700;font-size:14px;text-decoration:none;display:flex;align-items:center;gap:7px;">
                    <i class="fas fa-home"></i>Về trang chủ
                </a>
                <a href="<?= BASE_URL ?>?action=list-product"
                   style="padding:11px 24px;border:1.5px solid #e5e7eb;color:#374151;border-radius:11px;font-weight:600;font-size:14px;text-decoration:none;display:flex;align-items:center;gap:7px;">
                    <i class="fas fa-cart-shopping"></i>Tiếp tục mua sắm
                </a>
            </div>
        </div>
    </div>
</div>
