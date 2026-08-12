<?php
$statusMap = [
    'pending'   => ['label'=>'Chờ xác nhận', 'color'=>'#f59e0b', 'bg'=>'#fffbeb', 'border'=>'#fde68a'],
    'confirmed' => ['label'=>'Đã xác nhận',  'color'=>'#06b6d4', 'bg'=>'#ecfeff', 'border'=>'#a5f3fc'],
    'shipping'  => ['label'=>'Đang giao',     'color'=>'#3b82f6', 'bg'=>'#eff6ff', 'border'=>'#bfdbfe'],
    'completed' => ['label'=>'Hoàn thành',    'color'=>'#16a34a', 'bg'=>'#f0fdf4', 'border'=>'#bbf7d0'],
    'cancelled' => ['label'=>'Đã hủy',        'color'=>'#ef4444', 'bg'=>'#fef2f2', 'border'=>'#fecaca'],
];
?>

<div class="container py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 style="font-weight:800;margin-bottom:3px;">📦 Lịch sử đơn hàng</h4>
            <p class="text-muted mb-0" style="font-size:13.5px;">Theo dõi tất cả đơn hàng của bạn</p>
        </div>
        <a href="<?= BASE_URL ?>" style="font-size:13.5px;color:#16a34a;text-decoration:none;font-weight:600;">
            <i class="fas fa-arrow-left me-1"></i>Về trang chủ
        </a>
    </div>

    <?php if(isset($_SESSION['success'])): ?>
    <div class="alert alert-success mb-3"><i class="fas fa-check-circle me-2"></i><?= $_SESSION['success'] ?></div>
    <?php unset($_SESSION['success']); endif; ?>

    <?php if(isset($_SESSION['error'])): ?>
    <div class="alert alert-danger mb-3"><i class="fas fa-exclamation-circle me-2"></i><?= $_SESSION['error'] ?></div>
    <?php unset($_SESSION['error']); endif; ?>

    <?php if(empty($orders)): ?>
    <div style="text-align:center;padding:60px 20px;background:#f9fafb;border-radius:16px;border:1px solid #e5e7eb;">
        <div style="font-size:56px;margin-bottom:16px;">🛍️</div>
        <h5 style="font-weight:700;color:#374151;">Bạn chưa có đơn hàng nào</h5>
        <p class="text-muted" style="font-size:13.5px;">Hãy đặt hàng ngay để trải nghiệm dịch vụ của chúng tôi!</p>
        <a href="<?= BASE_URL ?>?action=list-product"
           style="display:inline-flex;align-items:center;gap:8px;padding:11px 24px;background:#16a34a;color:#fff;border-radius:50px;font-weight:700;font-size:14px;text-decoration:none;margin-top:8px;">
            <i class="fas fa-shopping-bag"></i>Mua sắm ngay
        </a>
    </div>

    <?php else: ?>
    <div style="display:flex;flex-direction:column;gap:14px;">
        <?php foreach($orders as $order):
            $st = $statusMap[$order['status']] ?? ['label'=>$order['status'],'color'=>'#6b7280','bg'=>'#f9fafb','border'=>'#e5e7eb'];
            $canCancel = $order['status'] === 'pending';
        ?>
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:14px;overflow:hidden;transition:box-shadow .2s;"
             onmouseover="this.style.boxShadow='0 4px 16px rgba(0,0,0,0.07)'"
             onmouseout="this.style.boxShadow=''">

            <!-- Header -->
            <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
                <div style="display:flex;align-items:center;gap:14px;">
                    <span style="font-weight:700;font-size:15px;color:#6366f1;">#<?= $order['id'] ?></span>
                    <span style="font-size:12px;color:#9ca3af;"><i class="fas fa-clock me-1"></i><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></span>
                    <span style="font-size:12px;color:#9ca3af;"><i class="fas fa-box me-1"></i><?= $order['total_items'] ?> sản phẩm</span>
                </div>
                <div style="display:flex;align-items:center;gap:10px;">
                    <!-- Badge trạng thái -->
                    <span style="padding:5px 12px;border-radius:20px;font-size:12px;font-weight:600;background:<?= $st['bg'] ?>;color:<?= $st['color'] ?>;border:1px solid <?= $st['border'] ?>;">
                        <span style="display:inline-block;width:7px;height:7px;border-radius:50%;background:<?= $st['color'] ?>;margin-right:5px;vertical-align:middle;"></span>
                        <?= $st['label'] ?>
                    </span>
                    <!-- Tổng tiền -->
                    <span style="font-weight:800;font-size:15px;color:#dc2626;"><?= number_format($order['total_price']) ?>đ</span>
                </div>
            </div>

            <!-- Body -->
            <div style="padding:14px 20px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
                <div style="font-size:13.5px;color:#374151;">
                    <i class="fas fa-user me-2 text-muted"></i><?= htmlspecialchars($order['customer_name']) ?>
                    &nbsp;·&nbsp;
                    <i class="fas fa-phone me-2 text-muted"></i><?= htmlspecialchars($order['customer_phone']) ?>
                    &nbsp;·&nbsp;
                    <i class="fas fa-map-marker-alt me-2 text-muted"></i><?= htmlspecialchars($order['customer_address']) ?>
                </div>
                <div style="display:flex;gap:8px;">
                    <a href="<?= BASE_URL ?>?action=order-detail&id=<?= $order['id'] ?>"
                       style="padding:8px 16px;border:1.5px solid #e5e7eb;border-radius:9px;color:#374151;font-size:13px;font-weight:600;text-decoration:none;transition:all .15s;"
                       onmouseover="this.style.borderColor='#16a34a';this.style.color='#16a34a'"
                       onmouseout="this.style.borderColor='#e5e7eb';this.style.color='#374151'">
                        <i class="fas fa-eye me-1"></i>Xem chi tiết
                    </a>
                    <?php if($canCancel): ?>
                    <a href="<?= BASE_URL ?>?action=order-cancel&id=<?= $order['id'] ?>"
                       onclick="return confirm('Bạn chắc chắn muốn hủy đơn hàng #<?= $order['id'] ?>?')"
                       style="padding:8px 16px;border:1.5px solid #fecaca;border-radius:9px;color:#ef4444;background:#fef2f2;font-size:13px;font-weight:600;text-decoration:none;">
                        <i class="fas fa-times me-1"></i>Hủy đơn
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
