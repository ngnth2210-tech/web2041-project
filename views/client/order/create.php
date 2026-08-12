<div class="container py-4">
    <div class="mb-3">
        <a href="<?= BASE_URL ?>?action=detail-product&id=<?= $product['id'] ?>" style="color:#16a34a;text-decoration:none;font-size:13.5px;font-weight:600;">
            <i class="fas fa-arrow-left me-1"></i>Quay lại sản phẩm
        </a>
    </div>

    <?php if(isset($error)): ?>
    <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i><?= $error ?></div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- Product Summary -->
        <div class="col-md-4">
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:14px;padding:20px;position:sticky;top:80px;">
                <div style="font-weight:700;font-size:13px;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;margin-bottom:14px;">
                    <i class="fas fa-box-open me-2 text-primary"></i>Sản phẩm đặt mua
                </div>
                <?php if($product['image']): ?>
                <img src="<?= BASE_ASSETS_UPLOADS . $product['image'] ?>" alt=""
                     style="width:100%;height:150px;object-fit:cover;border-radius:12px;margin-bottom:14px;border:1px solid #e5e7eb;">
                <?php endif; ?>
                <div style="font-weight:700;font-size:15px;color:#111827;margin-bottom:6px;"><?= htmlspecialchars($product['name']) ?></div>
                <div style="font-size:20px;font-weight:800;color:#dc2626;margin-bottom:4px;"><?= number_format($product['price']) ?>đ</div>
                <div style="font-size:12.5px;color:#9ca3af;">Còn <?= $product['quantity'] ?> sản phẩm</div>

                <div style="margin-top:16px;padding:12px;background:#f0fdf4;border-radius:10px;border:1px solid #bbf7d0;">
                    <div style="display:flex;justify-content:space-between;font-size:13.5px;font-weight:700;">
                        <span>Tổng cộng:</span>
                        <span id="total-display" style="color:#dc2626;"><?= number_format($product['price']) ?>đ</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Form -->
        <div class="col-md-8">
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:14px;overflow:hidden;">
                <div style="padding:16px 22px;border-bottom:1px solid #f1f5f9;font-weight:700;font-size:15px;background:#f9fafb;">
                    <i class="fas fa-truck me-2 text-success"></i>Thông tin giao hàng
                </div>
                <div style="padding:22px;">
                    <!-- Form dùng chung, action sẽ đổi theo phương thức thanh toán -->
                    <form id="orderForm" action="<?= BASE_URL ?>?action=order-store" method="POST">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <input type="hidden" name="pay_method" id="pay_method" value="cod">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" name="customer_name" class="form-control" required placeholder="Nhập họ tên người nhận"
                                       value="<?= htmlspecialchars($_POST['customer_name']??$_SESSION['user_name']??'') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="tel" name="customer_phone" class="form-control" required placeholder="0xxxxxxxxx"
                                       value="<?= htmlspecialchars($_POST['customer_phone']??'') ?>">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                                <textarea name="customer_address" class="form-control" rows="2" required
                                          placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành"><?= htmlspecialchars($_POST['customer_address']??'') ?></textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Số lượng <span class="text-danger">*</span></label>
                                <input type="number" name="quantity" id="qty" class="form-control"
                                       min="1" max="<?= $product['quantity'] ?>" required
                                       value="<?= intval($_POST['quantity']??1) ?>" oninput="updateTotal()">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Ghi chú</label>
                                <textarea name="note" class="form-control" rows="2"
                                          placeholder="Ghi chú thêm (không bắt buộc)"><?= htmlspecialchars($_POST['note']??'') ?></textarea>
                            </div>
                        </div>

                        <!-- Phương thức thanh toán -->
                        <div style="margin-top:20px;">
                            <label class="form-label">Phương thức thanh toán <span class="text-danger">*</span></label>
                            <div style="display:flex;flex-direction:column;gap:10px;margin-top:8px;">

                                <!-- COD -->
                                <label id="card-cod" onclick="selectPayment('cod')"
                                       style="display:flex;align-items:center;gap:14px;padding:14px 16px;border:2px solid #6366f1;border-radius:12px;cursor:pointer;background:#f5f3ff;transition:all .18s;">
                                    <input type="radio" name="_pay_ui" value="cod" checked style="display:none;">
                                    <div style="width:40px;height:40px;border-radius:10px;background:#fff;display:flex;align-items:center;justify-content:center;font-size:20px;border:1px solid #e5e7eb;flex-shrink:0;">💵</div>
                                    <div>
                                        <div style="font-weight:700;font-size:14px;color:#111827;">Thanh toán khi nhận hàng (COD)</div>
                                        <div style="font-size:12.5px;color:#6b7280;margin-top:2px;">Trả tiền mặt khi shipper giao hàng</div>
                                    </div>
                                    <div id="check-cod" style="margin-left:auto;width:20px;height:20px;border-radius:50%;background:#6366f1;display:flex;align-items:center;justify-content:center;">
                                        <i class="fas fa-check" style="color:#fff;font-size:10px;"></i>
                                    </div>
                                </label>

                                <!-- MoMo -->
                                <label id="card-momo" onclick="selectPayment('momo')"
                                       style="display:flex;align-items:center;gap:14px;padding:14px 16px;border:2px solid #e5e7eb;border-radius:12px;cursor:pointer;background:#fff;transition:all .18s;">
                                    <input type="radio" name="_pay_ui" value="momo" style="display:none;">
                                    <div style="width:40px;height:40px;border-radius:10px;background:#fff;display:flex;align-items:center;justify-content:center;border:1px solid #e5e7eb;flex-shrink:0;overflow:hidden;">
                                        <img src="https://upload.wikimedia.org/wikipedia/vi/f/fe/MoMo_Logo.png" style="width:32px;height:32px;object-fit:contain;" alt="MoMo">
                                    </div>
                                    <div>
                                        <div style="font-weight:700;font-size:14px;color:#111827;">Ví MoMo</div>
                                        <div style="font-size:12.5px;color:#6b7280;margin-top:2px;">Thanh toán nhanh qua ứng dụng MoMo</div>
                                    </div>
                                    <div id="check-momo" style="margin-left:auto;width:20px;height:20px;border-radius:50%;background:#e5e7eb;display:flex;align-items:center;justify-content:center;">
                                        <i class="fas fa-check" style="color:#fff;font-size:10px;"></i>
                                    </div>
                                </label>

                            </div>
                        </div>

                        <div style="border-top:1px solid #f1f5f9;margin-top:22px;padding-top:18px;">
                            <button type="button" onclick="submitOrder()"
                                    style="width:100%;padding:13px;background:#16a34a;color:#fff;border:none;border-radius:11px;font-weight:800;font-size:15px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:all .18s;"
                                    id="submitBtn">
                                <i class="fas fa-check-circle"></i>
                                <span id="submitLabel">Xác nhận đặt hàng</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const price = <?= $product['price'] ?>;
const codAction   = "<?= BASE_URL ?>?action=order-store";
const momoAction  = "<?= BASE_URL ?>?action=momo-pay";

function updateTotal() {
    const qty = Math.max(1, parseInt(document.getElementById('qty').value) || 1);
    document.getElementById('total-display').textContent = (price * qty).toLocaleString('vi-VN') + 'đ';
}

function selectPayment(method) {
    document.getElementById('pay_method').value = method;

    const isMomo = method === 'momo';

    // Style card COD
    const cardCod = document.getElementById('card-cod');
    cardCod.style.border = isMomo ? '2px solid #e5e7eb' : '2px solid #6366f1';
    cardCod.style.background = isMomo ? '#fff' : '#f5f3ff';
    document.getElementById('check-cod').style.background = isMomo ? '#e5e7eb' : '#6366f1';

    // Style card MoMo
    const cardMomo = document.getElementById('card-momo');
    cardMomo.style.border = isMomo ? '2px solid #ae2070' : '2px solid #e5e7eb';
    cardMomo.style.background = isMomo ? '#fdf0f6' : '#fff';
    document.getElementById('check-momo').style.background = isMomo ? '#ae2070' : '#e5e7eb';

    // Đổi label nút submit
    const label = document.getElementById('submitLabel');
    const btn   = document.getElementById('submitBtn');
    if (isMomo) {
        label.textContent = 'Thanh toán qua MoMo';
        btn.style.background = '#ae2070';
    } else {
        label.textContent = 'Xác nhận đặt hàng';
        btn.style.background = '#16a34a';
    }
}

function submitOrder() {
    const method = document.getElementById('pay_method').value;
    const form   = document.getElementById('orderForm');
    form.action  = method === 'momo' ? momoAction : codAction;
    form.submit();
}
</script>
