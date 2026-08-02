<div class="d-flex align-items-center justify-content-between mb-3">
    <p class="text-muted mb-0" style="font-size:13px;">Quản lý toàn bộ sản phẩm — Disable để ẩn khỏi cửa hàng, không xóa để giữ lịch sử đơn hàng</p>
    <a href="<?= BASE_URL_ADMIN .'&action=create-product' ?>" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Thêm sản phẩm
    </a>
</div>

<?php if(isset($_SESSION['error'])): ?>
<div class="alert alert-danger"><i class="fas fa-circle-exclamation me-2"></i><?= $_SESSION['error'] ?></div>
<?php unset($_SESSION['error']); endif; ?>

<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Trạng thái</th>
                    <th class="text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $pro):
                    $isActive = ($pro['status'] ?? 1) == 1;
                ?>
                <tr style="<?= !$isActive ? 'opacity:.5;' : '' ?>">
                    <td class="text-muted"><?= $pro["id"] ?></td>
                    <td>
                        <img src="<?= BASE_ASSETS_UPLOADS .$pro["image"] ?>" alt=""
                             style="width:44px;height:44px;object-fit:cover;border-radius:8px;border:1px solid #e2e8f0;<?= !$isActive?'filter:grayscale(1);':'' ?>">
                    </td>
                    <td>
                        <div style="font-weight:600;font-size:13.5px;"><?= htmlspecialchars($pro["name"]) ?></div>
                        <div class="text-muted" style="font-size:12px;max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= htmlspecialchars($pro["description"]) ?></div>
                    </td>
                    <td>
                        <span class="badge" style="background:#ede9fe;color:#6d28d9;"><?= htmlspecialchars($pro["cat_name"]) ?></span>
                    </td>
                    <td class="fw-bold text-danger"><?= number_format($pro["price"]) ?>đ</td>
                    <td>
                        <span class="badge <?= $pro['quantity'] > 10 ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' ?>">
                            <?= $pro["quantity"] ?>
                        </span>
                    </td>
                    <td>
                        <?php if($isActive): ?>
                            <span class="badge bg-success-subtle text-success"><i class="fas fa-circle me-1" style="font-size:7px;"></i>Hiển thị</span>
                        <?php else: ?>
                            <span class="badge bg-secondary-subtle text-secondary"><i class="fas fa-circle me-1" style="font-size:7px;"></i>Đã ẩn</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <a href="<?= BASE_URL_ADMIN .'&action=show-product&id='. $pro["id"]?>" class="btn btn-sm" style="background:#eff6ff;color:#3b82f6;border:1px solid #dbeafe;" title="Xem"><i class="fas fa-eye"></i></a>
                        <a href="<?= BASE_URL_ADMIN .'&action=edit-product&id='. $pro["id"]?>" class="btn btn-sm btn-warning" title="Sửa"><i class="fas fa-pen"></i></a>
                        <a href="<?= BASE_URL_ADMIN .'&action=toggle-product&id='. $pro["id"]?>"
                           onclick="return confirm('<?= $isActive ? 'Ẩn sản phẩm này khỏi cửa hàng?' : 'Hiển thị lại sản phẩm này?' ?>')"
                           class="btn btn-sm <?= $isActive ? 'btn-secondary' : 'btn-success' ?>"
                           title="<?= $isActive ? 'Ẩn sản phẩm' : 'Hiển thị lại' ?>">
                            <i class="fas <?= $isActive ? 'fa-eye-slash' : 'fa-eye' ?>"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if(empty($data)): ?>
        <div class="text-center py-5 text-muted">
            <i class="fas fa-box-open fa-3x mb-3 opacity-25"></i>
            <p>Chưa có sản phẩm nào.</p>
        </div>
        <?php endif; ?>
    </div>
</div>
