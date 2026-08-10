<?php
$statusMap = [
    'pending'   => ['label'=>'Chờ xác nhận','cls'=>'bg-warning-subtle text-warning','dot'=>'#f59e0b'],
    'confirmed' => ['label'=>'Đã xác nhận','cls'=>'bg-info-subtle text-info','dot'=>'#06b6d4'],
    'shipping'  => ['label'=>'Đang giao','cls'=>'','style'=>'background:#eff6ff;color:#3b82f6;','dot'=>'#3b82f6'],
    'completed' => ['label'=>'Hoàn thành','cls'=>'bg-success-subtle text-success','dot'=>'#10b981'],
    'cancelled' => ['label'=>'Đã hủy','cls'=>'bg-danger-subtle text-danger','dot'=>'#ef4444'],
];
$st = $statusMap[$order['status']] ?? ['label'=>$order['status'],'cls'=>'bg-secondary','dot'=>'#6b7280'];
$isLocked = in_array($order['status'], ['completed','cancelled']);

// Dùng model để lấy danh sách trạng thái được phép chuyển tới
$allowedStatuses = $allowedStatuses ?? Order::allowedNextStatuses($order['status']);
?>

<div class="d-flex align-items-center gap-2 mb-3">
    <a href="<?= BASE_URL_ADMIN ?>&action=list-order" class="btn btn-light btn-sm"><i class="fas fa-arrow-left me-1"></i>Danh sách</a>
    <span class="badge <?= $st['cls'] ?>" <?= isset($st['style'])?"style=\"{$st['style']}font-size:13px;padding:6px 14px;\"":"style=\"font-size:13px;padding:6px 14px;\"" ?>>
        <span style="display:inline-block;width:7px;height:7px;border-radius:50%;background:<?= $st['dot'] ?>;margin-right:6px;vertical-align:middle;"></span>
        <?= $st['label'] ?>
    </span>
</div>

<?php if(isset($_SESSION['error'])): ?>
<div class="alert alert-danger mb-3"><i class="fas fa-exclamation-circle me-2"></i><?= $_SESSION['error'] ?></div>
<?php unset($_SESSION['error']); endif; ?>

<div class="row g-4">
    <!-- Order info + status update -->
    <div class="col-md-5">
        <!-- Info Card -->
        <div class="card mb-3">
            <div class="card-header">
                <span><i class="fas fa-receipt me-2 text-primary"></i>Đơn hàng #<?= $order['id'] ?></span>
            </div>
            <div class="card-body p-0">
                <?php
                $rows = [
                    ['Người nhận', htmlspecialchars($order['customer_name']), 'fw-bold'],
                    ['Số điện thoại', htmlspecialchars($order['customer_phone']), ''],
                    ['Địa chỉ', htmlspecialchars($order['customer_address']), ''],
                    ['Ngày đặt', date('H:i - d/m/Y', strtotime($order['created_at'])), 'text-muted'],
                    ['Tổng tiền', number_format($order['total_price']).'đ', 'text-danger fw-bold fs-6'],
                ];
                if(!empty($order['note'])) $rows[] = ['Ghi chú', htmlspecialchars($order['note']), 'fst-italic text-muted'];
                foreach($rows as [$label, $val, $cls]):
                ?>
                <div style="display:flex;padding:12px 18px;border-bottom:1px solid #f1f5f9;font-size:13.5px;gap:12px;">
                    <span style="width:130px;color:#6b7280;font-weight:600;flex-shrink:0;"><?= $label ?></span>
                    <span class="<?= $cls ?>"><?= $val ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Status Update Card -->
        <div class="card">
            <div class="card-header"><i class="fas fa-arrows-rotate me-2 text-warning"></i>Cập nhật trạng thái</div>
            <div class="card-body">
                <?php if($isLocked): ?>
                <div class="alert mb-0 <?= $order['status']==='completed'?'alert-success':'alert-danger' ?>" style="border-radius:10px;font-size:13.5px;">
                    <i class="fas fa-lock me-2"></i>
                    <strong><?= $order['status']==='completed'?'Đơn đã hoàn thành':'Đơn đã hủy' ?></strong>
                    — Trạng thái bị khóa, không thể thay đổi.
                </div>

                <?php elseif(empty($allowedStatuses)): ?>
                <div class="alert alert-secondary mb-0" style="border-radius:10px;font-size:13.5px;">
                    Không có trạng thái tiếp theo khả dụng.
                </div>

                <?php else: ?>
                <div style="font-size:12.5px;color:#6b7280;margin-bottom:10px;">
                    <i class="fas fa-info-circle me-1"></i>
                    Chỉ có thể chuyển sang trạng thái tiếp theo, không thể quay lại.
                </div>
                <form id="statusForm" action="<?= BASE_URL_ADMIN ?>&action=update-order-status&id=<?= $order['id'] ?>" method="POST">
                    <label class="form-label">Chuyển sang</label>
                    <select name="status" id="statusSelect" class="form-select mb-3">
                        <option value="">-- Chọn trạng thái --</option>
                        <?php foreach($allowedStatuses as $key): ?>
                        <option value="<?= $key ?>"><?= $statusMap[$key]['label'] ?? $key ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" onclick="confirmUpdate()" class="btn btn-warning w-100 fw-bold">
                        <i class="fas fa-save me-1"></i>Cập nhật trạng thái
                    </button>
                </form>
                <?php endif; ?>

                <!-- Timeline -->
                <div class="mt-4">
                    <?php
                    $steps = ['pending'=>'Chờ xác nhận','confirmed'=>'Xác nhận','shipping'=>'Đang giao','completed'=>'Hoàn thành'];
                    $stepKeys = array_keys($steps);
                    $curIdx = array_search($order['status'], $stepKeys);
                    ?>
                    <div style="display:flex;align-items:flex-start;position:relative;">
                        <div style="position:absolute;top:12px;left:12px;right:12px;height:2px;background:#e5e7eb;z-index:0;"></div>
                        <?php foreach($steps as $key=>$label):
                            $idx  = array_search($key, $stepKeys);
                            $done = ($curIdx!==false && $idx<=$curIdx && $order['status']!=='cancelled');
                        ?>
                        <div style="flex:1;text-align:center;position:relative;z-index:1;">
                            <div style="width:24px;height:24px;border-radius:50%;background:<?= $done?'#10b981':'#e5e7eb' ?>;margin:0 auto;display:flex;align-items:center;justify-content:center;font-size:11px;color:#fff;font-weight:700;">
                                <?= $done?'✓':($idx+1) ?>
                            </div>
                            <div style="font-size:10.5px;margin-top:5px;color:<?= $done?'#10b981':'#9ca3af' ?>;font-weight:<?= $done?'600':'400' ?>;"><?= $label ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if($order['status']==='cancelled'): ?>
                    <div class="alert alert-danger mt-3 mb-0 py-2 text-center" style="font-size:13px;border-radius:9px;">
                        <i class="fas fa-times-circle me-1"></i>Đơn hàng đã bị hủy
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header"><i class="fas fa-basket-shopping me-2 text-success"></i>Sản phẩm trong đơn</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th class="text-center">SL</th>
                            <th class="text-end">Đơn giá</th>
                            <th class="text-end">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($orderItems as $item): ?>
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <?php if($item['product_image']): ?>
                                    <img src="<?= BASE_ASSETS_UPLOADS . 'products/' . $item['product_image'] ?>" alt=""
                                         style="width:40px;height:40px;object-fit:cover;border-radius:8px;border:1px solid #e5e7eb;flex-shrink:0;">
                                    <?php endif; ?>
                                    <span style="font-weight:600;font-size:13.5px;"><?= htmlspecialchars($item['product_name']) ?></span>
                                </div>
                            </td>
                            <td class="text-center"><span class="badge bg-secondary-subtle text-secondary"><?= $item['quantity'] ?></span></td>
                            <td class="text-end text-muted"><?= number_format($item['price']) ?>đ</td>
                            <td class="text-end fw-bold text-danger"><?= number_format($item['price']*$item['quantity']) ?>đ</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr style="background:#f8fafc;">
                            <td colspan="3" class="text-end fw-bold" style="padding:14px 16px;">Tổng cộng</td>
                            <td class="text-end fw-bold text-danger" style="font-size:16px;padding:14px 16px;"><?= number_format($order['total_price']) ?>đ</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <?php if($order['status'] === 'pending'): ?>
        <div class="mt-3">
            <form method="POST"
                  action="<?= BASE_URL_ADMIN ?>&action=update-order-status&id=<?= $order['id'] ?>"
                  onsubmit="return confirm('Hủy đơn hàng #' + <?= $order['id'] ?> + '? Kho hàng sẽ được hoàn trả.')">
                <input type="hidden" name="status" value="cancelled">
                <button type="submit" class="btn btn-sm btn-outline-danger">
                    <i class="fas fa-ban me-1"></i>Hủy đơn hàng này
                </button>
            </form>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Confirm Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content" style="border-radius:14px;border:none;">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold">Xác nhận thay đổi</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalBody" style="font-size:13.5px;padding:16px 20px;"></div>
            <div class="modal-footer border-0 pt-0 gap-2">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-warning btn-sm fw-bold" id="confirmBtn"
                        onclick="document.getElementById('statusForm').submit()">Xác nhận</button>
            </div>
        </div>
    </div>
</div>

<script>
const statusLabels = {pending:'Chờ xác nhận',confirmed:'Đã xác nhận',shipping:'Đang giao',completed:'Hoàn thành',cancelled:'Đã hủy'};
function confirmUpdate(){
    const sel = document.getElementById('statusSelect');
    if(!sel.value) { alert('Vui lòng chọn trạng thái!'); return; }
    const label = statusLabels[sel.value] ?? sel.value;
    const isFinal = ['completed','cancelled'].includes(sel.value);
    document.getElementById('modalBody').innerHTML =
        `Chuyển sang <strong>"${label}"</strong>?`
        + (isFinal ? `<br><span class="text-danger" style="font-size:12px;">⚠️ Không thể hoàn tác sau khi xác nhận.</span>` : '');
    document.getElementById('confirmBtn').className = isFinal ? 'btn btn-danger btn-sm fw-bold' : 'btn btn-warning btn-sm fw-bold';
    new bootstrap.Modal(document.getElementById('confirmModal')).show();
}
</script>
