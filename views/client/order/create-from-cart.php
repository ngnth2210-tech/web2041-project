<?php $title = 'Xác nhận đặt hàng'; ?>

<div class="container py-4">
    <h4 style="font-weight:800;margin-bottom:4px;"><i class="fas fa-check-circle me-2 text-success"></i>Xác nhận đặt hàng</h4>
    <p class="text-muted mb-4" style="font-size:13.5px;">Điền thông tin giao hàng để hoàn tất đơn</p>

    <div class="row g-4">
        <!-- Form -->
        <div class="col-md-7">
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:14px;overflow:hidden;">
                <div style="padding:14px 20px;background:#f9fafb;border-bottom:1px solid #e5e7eb;font-weight:700;font-size:14px;">
                    <i class="fas fa-map-marker-alt me-2 text-success"></i>Thông tin giao hàng
                </div>
                <form method="POST" action="<?= BASE_URL ?>?action=order-store" style="padding:22px;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" name="customer_name" class="form-control" required placeholder="Người nhận hàng"
                                   value="<?= htmlspecialchars($_SESSION['user_name']??'') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" name="customer_phone" class="form-control" required placeholder="0xxxxxxxxx">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                            <input type="text" name="customer_address" class="form-control" required placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Ghi chú</label>
                            <textarea name="note" class="form-control" rows="2" placeholder="Ghi chú thêm về đơn hàng..."></textarea>
                        </div>
                    </div>
                        <!-- Phương thức thanh toán -->
                        <div style="margin-top:16px;">
                            <label class="form-label">Phương thức thanh toán</label>
                            <div style="display:flex;gap:10px;margin-top:8px;flex-wrap:wrap;">
                                <label id="cc-cod" onclick="selPay('cod')"
                                       style="flex:1;min-width:140px;display:flex;align-items:center;gap:10px;padding:12px 14px;border:2px solid #6366f1;border-radius:11px;cursor:pointer;background:#f5f3ff;">
                                    <span style="font-size:20px;">💵</span>
                                    <div>
                                        <div style="font-weight:700;font-size:13px;">Thanh toán khi nhận (COD)</div>
                                        <div style="font-size:11.5px;color:#6b7280;">Trả tiền mặt khi nhận hàng</div>
                                    </div>
                                    <div id="ck-cod" style="margin-left:auto;width:18px;height:18px;border-radius:50%;background:#6366f1;flex-shrink:0;"></div>
                                </label>
                                <label id="cc-momo" onclick="selPay('momo')"
                                       style="flex:1;min-width:140px;display:flex;align-items:center;gap:10px;padding:12px 14px;border:2px solid #e5e7eb;border-radius:11px;cursor:pointer;background:#fff;">
                                    <img src="https://upload.wikimedia.org/wikipedia/vi/f/fe/MoMo_Logo.png" style="width:28px;height:28px;object-fit:contain;">
                                    <div>
                                        <div style="font-weight:700;font-size:13px;">Ví MoMo</div>
                                        <div style="font-size:11.5px;color:#6b7280;">Thanh toán qua ứng dụng MoMo</div>
                                    </div>
                                    <div id="ck-momo" style="margin-left:auto;width:18px;height:18px;border-radius:50%;background:#e5e7eb;flex-shrink:0;"></div>
                                </label>
                            </div>
                            <input type="hidden" name="pay_method" id="cart_pay_method" value="cod">
                        </div>

                    <div style="border-top:1px solid #f1f5f9;margin-top:18px;padding-top:16px;display:flex;gap:10px;">
                        <button type="button" onclick="submitCartOrder()"
                                id="cartSubmitBtn"
                                style="flex:1;padding:13px;background:#16a34a;color:#fff;border:none;border-radius:11px;font-weight:800;font-size:14px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;">
                            <i class="fas fa-check-circle"></i>
                            <span id="cartSubmitLabel">Xác nhận đặt hàng</span>
                        </button>
                        <a href="<?= BASE_URL ?>?action=cart"
                           style="padding:13px 20px;border:1.5px solid #e5e7eb;border-radius:11px;color:#374151;font-weight:600;font-size:14px;text-decoration:none;display:flex;align-items:center;gap:6px;">
                            <i class="fas fa-arrow-left"></i> Giỏ hàng
                        </a>
                    </div>
                </form>

<script>
const cartCodAction  = "<?= BASE_URL ?>?action=order-store";
const cartMomoAction = "<?= BASE_URL ?>?action=momo-pay";
function selPay(m){
    document.getElementById('cart_pay_method').value = m;
    const isMomo = m === 'momo';
    document.getElementById('cc-cod').style.cssText  = `flex:1;min-width:140px;display:flex;align-items:center;gap:10px;padding:12px 14px;border:2px solid ${isMomo?'#e5e7eb':'#6366f1'};border-radius:11px;cursor:pointer;background:${isMomo?'#fff':'#f5f3ff'};`;
    document.getElementById('cc-momo').style.cssText = `flex:1;min-width:140px;display:flex;align-items:center;gap:10px;padding:12px 14px;border:2px solid ${isMomo?'#ae2070':'#e5e7eb'};border-radius:11px;cursor:pointer;background:${isMomo?'#fdf0f6':'#fff'};`;
    document.getElementById('ck-cod').style.background  = isMomo ? '#e5e7eb' : '#6366f1';
    document.getElementById('ck-momo').style.background = isMomo ? '#ae2070' : '#e5e7eb';
    const btn = document.getElementById('cartSubmitBtn');
    document.getElementById('cartSubmitLabel').textContent = isMomo ? 'Thanh toán qua MoMo' : 'Xác nhận đặt hàng';
    btn.style.background = isMomo ? '#ae2070' : '#16a34a';
}
function submitCartOrder(){
    const m = document.getElementById('cart_pay_method').value;
    const f = document.querySelector('#cc-cod').closest('form');
    f.action = m === 'momo' ? cartMomoAction : cartCodAction;
    f.submit();
}
</script>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-md-5">
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:14px;overflow:hidden;position:sticky;top:80px;">
                <div style="padding:14px 20px;background:#f9fafb;border-bottom:1px solid #e5e7eb;font-weight:700;font-size:14px;">
                    <i class="fas fa-basket-shopping me-2 text-primary"></i>Giỏ hàng (<?= count($cart) ?> sản phẩm)
                </div>
                <div style="padding:0;">
                    <?php foreach($cart as $item): ?>
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 18px;border-bottom:1px solid #f9fafb;gap:10px;">
                        <div style="flex:1;">
                            <div style="font-size:13.5px;font-weight:600;color:#111827;"><?= htmlspecialchars($item['name']) ?></div>
                            <div style="font-size:12px;color:#9ca3af;">x<?= $item['quantity'] ?></div>
                        </div>
                        <div style="font-weight:700;color:#374151;font-size:13.5px;white-space:nowrap;"><?= number_format($item['price']*$item['quantity']) ?>đ</div>
                    </div>
                    <?php endforeach; ?>
                    <div style="padding:16px 18px;display:flex;justify-content:space-between;font-weight:800;font-size:16px;border-top:2px solid #e5e7eb;">
                        <span>Tổng cộng</span>
                        <span style="color:#dc2626;"><?= number_format($total) ?>đ</span>
                    </div>
                </div>
                <div style="padding:0 18px 18px;">
                    <div style="padding:10px;background:#f0fdf4;border-radius:9px;font-size:12px;color:#15803d;text-align:center;">
                        <i class="fas fa-truck me-1"></i>Miễn phí vận chuyển
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
