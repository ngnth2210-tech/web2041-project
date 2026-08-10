<?php
$statusMap = [
    'pending'   => ['label'=>'Chờ xác nhận','cls'=>'bg-warning-subtle text-warning','dot'=>'#f59e0b'],
    'confirmed' => ['label'=>'Đã xác nhận','cls'=>'bg-info-subtle text-info','dot'=>'#06b6d4'],
    'shipping'  => ['label'=>'Đang giao','cls'=>'','style'=>'background:#eff6ff;color:#3b82f6;','dot'=>'#3b82f6'],
    'completed' => ['label'=>'Hoàn thành','cls'=>'bg-success-subtle text-success','dot'=>'#10b981'],
    'cancelled' => ['label'=>'Đã hủy','cls'=>'bg-danger-subtle text-danger','dot'=>'#ef4444'],
];
$counts = ['pending'=>0,'confirmed'=>0,'shipping'=>0,'completed'=>0,'cancelled'=>0];
$total_revenue = 0;
foreach($data as $o){
    if(isset($counts[$o['status']])) $counts[$o['status']]++;
    if($o['status']==='completed') $total_revenue += $o['total_price'];
}
?>

<?php if(isset($_SESSION['error'])): ?>
<div class="alert alert-danger mb-3"><i class="fas fa-circle-exclamation me-2"></i><?= $_SESSION['error'] ?></div>
<?php unset($_SESSION['error']); endif; ?>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-2">
        <div class="card border-0" style="background:#f8fafc;">
            <div class="card-body py-3 text-center">
                <div class="fw-bold" style="font-size:22px;color:#1e293b;"><?= count($data) ?></div>
                <div class="text-muted" style="font-size:12px;">Tất cả</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="card border-0" style="background:#fffbeb;">
            <div class="card-body py-3 text-center">
                <div class="fw-bold text-warning" style="font-size:22px;"><?= $counts['pending'] ?></div>
                <div class="text-muted" style="font-size:12px;">Chờ xác nhận</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="card border-0" style="background:#eff6ff;">
            <div class="card-body py-3 text-center">
                <div class="fw-bold text-primary" style="font-size:22px;"><?= $counts['shipping'] ?></div>
                <div class="text-muted" style="font-size:12px;">Đang giao</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="card border-0" style="background:#f0fdf4;">
            <div class="card-body py-3 text-center">
                <div class="fw-bold text-success" style="font-size:22px;"><?= $counts['completed'] ?></div>
                <div class="text-muted" style="font-size:12px;">Hoàn thành</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="card border-0" style="background:#fff1f2;">
            <div class="card-body py-3 text-center">
                <div class="fw-bold text-danger" style="font-size:22px;"><?= $counts['cancelled'] ?></div>
                <div class="text-muted" style="font-size:12px;">Đã hủy</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="card border-0" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">
            <div class="card-body py-3 text-center">
                <div class="fw-bold text-white" style="font-size:13px;"><?= number_format($total_revenue) ?>đ</div>
                <div class="text-white opacity-75" style="font-size:12px;">Doanh thu</div>
            </div>
        </div>
    </div>
</div>

<?php if(empty($data)): ?>
<div class="card">
    <div class="card-body text-center py-5 text-muted">
        <i class="fas fa-receipt fa-3x mb-3 opacity-25"></i>
        <p>Chưa có đơn hàng nào.</p>
    </div>
</div>
<?php else: ?>
<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Khách hàng</th>
                    <th>Điện thoại</th>
                    <th>Tổng tiền</th>
                    <th>Số SP</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                    <th class="text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $order):
                    $st = $statusMap[$order['status']] ?? ['label'=>$order['status'],'cls'=>'bg-secondary','dot'=>'#6b7280'];
                ?>
                <tr>
                    <td><strong style="color:#6366f1;">#<?= $order['id'] ?></strong></td>
                    <td style="font-weight:500;"><?= htmlspecialchars($order['customer_name']) ?></td>
                    <td class="text-muted"><?= htmlspecialchars($order['customer_phone']) ?></td>
                    <td class="fw-bold text-danger"><?= number_format($order['total_price']) ?>đ</td>
                    <td><span class="badge bg-secondary-subtle text-secondary"><?= $order['total_items'] ?> SP</span></td>
                    <td>
                        <span class="badge <?= $st['cls'] ?>" <?= isset($st['style'])?"style=\"{$st['style']}\"":'' ?>>
                            <span style="display:inline-block;width:6px;height:6px;border-radius:50%;background:<?= $st['dot'] ?>;margin-right:4px;vertical-align:middle;"></span>
                            <?= $st['label'] ?>
                        </span>
                    </td>
                    <td class="text-muted" style="font-size:12.5px;"><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                    <td class="text-center">
                        <a href="<?= BASE_URL_ADMIN ?>&action=show-order&id=<?= $order['id'] ?>"
                           class="btn btn-sm" style="background:#eff6ff;color:#3b82f6;border:1px solid #dbeafe;">
                            <i class="fas fa-eye me-1"></i>Chi tiết
                        </a>
                        <?php if($order['status'] === 'pending'): ?>
                            <form method="POST"
                                  action="<?= BASE_URL_ADMIN ?>&action=update-order-status&id=<?= $order['id'] ?>"
                                  style="display:inline;"
                                  onsubmit="return confirm('Hủy đơn hàng #<?= $order["id"] ?>?')"
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-ban me-1"></i>Hủy đơn
                                </button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php endif; ?>
