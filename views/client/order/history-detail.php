<?php
$statusMap = [
    'pending'   => ['label'=>'Chờ xác nhận', 'color'=>'#f59e0b', 'bg'=>'#fffbeb', 'border'=>'#fde68a'],
    'confirmed' => ['label'=>'Đã xác nhận',  'color'=>'#06b6d4', 'bg'=>'#ecfeff', 'border'=>'#a5f3fc'],
    'shipping'  => ['label'=>'Đang giao',     'color'=>'#3b82f6', 'bg'=>'#eff6ff', 'border'=>'#bfdbfe'],
    'completed' => ['label'=>'Hoàn thành',    'color'=>'#16a34a', 'bg'=>'#f0fdf4', 'border'=>'#bbf7d0'],
    'cancelled' => ['label'=>'Đã hủy',        'color'=>'#ef4444', 'bg'=>'#fef2f2', 'border'=>'#fecaca'],
];
$st = $statusMap[$order['status']] ?? ['label'=>$order['status'],'color'=>'#6b7280','bg'=>'#f9fafb','border'=>'#e5e7eb'];
$canCancel = $order['status'] === 'pending';

// Timeline steps
$steps = [
    'pending'   => 'Chờ xác nhận',
    'confirmed' => 'Đã xác nhận',
    'shipping'  => 'Đang giao hàng',
    'completed' => 'Hoàn thành',
];
$stepKeys  = array_keys($steps);
$currentIdx = array_search($order['status'], $stepKeys);
$isCancelled = $order['status'] === 'cancelled';
?>

<div class="container py-4">
    <!-- Back + title -->
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
        <div>
            <a href="<?= BASE_URL ?>?action=order-history" style="font-size:13px;color:#16a34a;text-decoration:none;font-weight:600;">
                <i class="fas fa-arrow-left me-1"></i>Lịch sử đơn hàng
            </a>
            <h4 style="font-weight:800;margin:6px 0 2px;">Đơn hàng <span style="color:#6366f1;">#<?= $order['id'] ?></span></h4>
            <span style="font-size:12.5px;color:#9ca3af;"><i class="fas fa-clock me-1"></i>Đặt lúc <?= date('H:i - d/m/Y', strtotime($order['created_at'])) ?></span>
        </div>
        <div style="display:flex;align-items:center;gap:10px;">
            <span style="padding:7px 16px;border-radius:20px;font-size:13px;font-weight:600;background:<?= $st['bg'] ?>;color:<?= $st['color'] ?>;border:1px solid <?= $st['border'] ?>;">
                <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:<?= $st['color'] ?>;margin-right:6px;vertical-align:middle;"></span>
                <?= $st['label'] ?>
            </span>
            <?php if($canCancel): ?>
            <a href="<?= BASE_URL ?>?action=order-cancel&id=<?= $order['id'] ?>"
               onclick="return confirm('Hủy đơn hàng #<?= $order['id'] ?>?')"
               style="padding:7px 16px;background:#fef2f2;color:#ef4444;border:1px solid #fecaca;border-radius:9px;font-size:13px;font-weight:600;text-decoration:none;">
                <i class="fas fa-times me-1"></i>Hủy đơn
            </a>
            <?php endif; ?>
        </div>
    </div>

    <?php // hiển thị payment badge nếu có ?>
<?php if(isset($order['payment_method']) && $order['payment_method'] === 'momo'): ?>
    <div style="margin-bottom:16px;padding:12px 16px;background:#fdf0f6;border:1px solid #f9a8d4;border-radius:12px;display:flex;align-items:center;gap:10px;font-size:13.5px;">
        <img src="https://upload.wikimedia.org/wikipedia/vi/f/fe/MoMo_Logo.png" style="width:24px;height:24px;object-fit:contain;">
        <span>Đơn hàng này thanh toán qua <strong>Ví MoMo</strong>.</span>
        <?php if(($order['payment_status']??'') === 'paid'): ?>
        <span style="margin-left:auto;background:#dcfce7;color:#15803d;padding:3px 10px;border-radius:20px;font-weight:600;font-size:12px;">✓ Đã thanh toán</span>
        <?php endif; ?>
    </div>
<?php endif; ?>
    <?php if(isset($_SESSION['error'])): ?>
    <div class="alert alert-danger mb-3"><i class="fas fa-exclamation-circle me-2"></i><?= $_SESSION['error'] ?></div>
    <?php unset($_SESSION['error']); endif; ?>

    <div class="row g-4">
        <!-- LEFT: Timeline + Sản phẩm -->
        <div class="col-md-7">

            <!-- Timeline trạng thái -->
            <?php if(!$isCancelled): ?>
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:14px;padding:22px;margin-bottom:16px;">
                <div style="font-weight:700;font-size:14px;margin-bottom:20px;color:#111827;">Trạng thái đơn hàng</div>
                <div style="position:relative;padding-left:28px;">
                    <!-- Line dọc -->
                    <div style="position:absolute;left:10px;top:6px;bottom:6px;width:2px;background:#e5e7eb;"></div>

                    <?php foreach($steps as $key => $label):
                        $idx  = array_search($key, $stepKeys);
                        $done = $currentIdx !== false && $idx <= $currentIdx;
                        $curr = $key === $order['status'];
                    ?>
                    <div style="position:relative;margin-bottom:<?= $key==='completed'?'0':'20px' ?>;">
                        <!-- Dot -->
                        <div style="position:absolute;left:-22px;top:3px;width:16px;height:16px;border-radius:50%;
                             background:<?= $done?'#16a34a':'#e5e7eb' ?>;
                             border:2px solid <?= $done?'#16a34a':'#d1d5db' ?>;
                             display:flex;align-items:center;justify-content:center;">
                            <?php if($done): ?>
                            <i class="fas fa-check" style="font-size:8px;color:#fff;"></i>
                            <?php endif; ?>
                        </div>
                        <div style="font-weight:<?= $curr?'700':'500' ?>;font-size:13.5px;color:<?= $done?'#111827':'#9ca3af' ?>;">
                            <?= $label ?>
                            <?php if($curr): ?>
                            <span style="margin-left:8px;font-size:11px;background:#dcfce7;color:#15803d;padding:2px 8px;border-radius:10px;font-weight:600;">Hiện tại</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php else: ?>
            <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:14px;padding:18px;margin-bottom:16px;display:flex;align-items:center;gap:14px;">
                <div style="width:40px;height:40px;border-radius:50%;background:#fee2e2;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fas fa-times" style="color:#ef4444;font-size:18px;"></i>
                </div>
                <div>
                    <div style="font-weight:700;color:#b91c1c;margin-bottom:2px;">Đơn hàng đã bị hủy</div>
                    <div style="font-size:13px;color:#ef4444;">Số lượng sản phẩm đã được hoàn trả về kho.</div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Danh sách sản phẩm -->
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:14px;overflow:hidden;">
                <div style="padding:14px 18px;border-bottom:1px solid #f1f5f9;font-weight:700;font-size:14px;color:#111827;">
                    <i class="fas fa-box-open me-2 text-primary"></i>Sản phẩm trong đơn
                </div>
                <?php foreach($orderItems as $item): ?>
                <div style="display:flex;align-items:center;gap:14px;padding:14px 18px;border-bottom:1px solid #f9fafb;">
                    <img src="<?= BASE_ASSETS_UPLOADS . $item['product_image'] ?>" alt=""
                         style="width:56px;height:56px;object-fit:cover;border-radius:10px;border:1px solid #e5e7eb;flex-shrink:0;">
                    <div style="flex:1;">
                        <div style="font-weight:600;font-size:14px;color:#111827;"><?= htmlspecialchars($item['product_name']) ?></div>
                        <div style="font-size:12.5px;color:#9ca3af;margin-top:2px;">
                            <?= number_format($item['price']) ?>đ × <?= $item['quantity'] ?>
                        </div>
                    </div>
                    <div style="font-weight:800;color:#dc2626;font-size:15px;white-space:nowrap;">
                        <?= number_format($item['price'] * $item['quantity']) ?>đ
                    </div>
                </div>
                <?php endforeach; ?>
                <div style="padding:14px 18px;display:flex;justify-content:space-between;font-weight:800;font-size:16px;background:#f9fafb;">
                    <span>Tổng cộng</span>
                    <span style="color:#dc2626;"><?= number_format($order['total_price']) ?>đ</span>
                </div>
            </div>
        </div>

        <!-- RIGHT: Thông tin giao hàng -->
        <div class="col-md-5">
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:14px;overflow:hidden;position:sticky;top:80px;">
                <div style="padding:14px 18px;border-bottom:1px solid #f1f5f9;font-weight:700;font-size:14px;color:#111827;">
                    <i class="fas fa-truck me-2 text-success"></i>Thông tin giao hàng
                </div>
                <div style="padding:0;">
                    <?php
                    $fields = [
                        ['fas fa-user',         'Người nhận',    $order['customer_name']],
                        ['fas fa-phone',        'Điện thoại',    $order['customer_phone']],
                        ['fas fa-map-marker-alt','Địa chỉ',      $order['customer_address']],
                    ];
                    if(!empty($order['note'])) {
                        $fields[] = ['fas fa-sticky-note','Ghi chú', $order['note']];
                    }
                    foreach($fields as [$icon, $label, $val]):
                    ?>
                    <div style="display:flex;gap:12px;padding:13px 18px;border-bottom:1px solid #f9fafb;font-size:13.5px;">
                        <span style="width:110px;color:#6b7280;font-weight:600;flex-shrink:0;"><i class="<?= $icon ?> me-2"></i><?= $label ?></span>
                        <span style="color:#111827;"><?= htmlspecialchars($val) ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>

                <?php if($order['status'] === 'pending'): ?>
                <div style="padding:16px 18px;background:#fffbeb;border-top:1px solid #fde68a;">
                    <div style="font-size:12.5px;color:#92400e;line-height:1.6;">
                        <i class="fas fa-info-circle me-1"></i>
                        Đơn hàng đang <strong>chờ xác nhận</strong>. Bạn có thể hủy đơn trong giai đoạn này.
                        Sau khi đơn được xác nhận, bạn không thể hủy.
                    </div>
                </div>
                <?php elseif($order['status'] === 'shipping'): ?>
                <div style="padding:16px 18px;background:#eff6ff;border-top:1px solid #bfdbfe;">
                    <div style="font-size:12.5px;color:#1e40af;line-height:1.6;">
                        <i class="fas fa-truck me-1"></i>
                        Đơn hàng đang trên đường giao đến bạn. Vui lòng để ý điện thoại!
                    </div>
                </div>
                <?php elseif($order['status'] === 'completed'): ?>
                <div style="padding:16px 18px;background:#f0fdf4;border-top:1px solid #bbf7d0;">
                    <div style="font-size:12.5px;color:#15803d;line-height:1.6;">
                        <i class="fas fa-check-circle me-1"></i>
                        Đơn hàng đã giao thành công. Cảm ơn bạn đã mua hàng!
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>