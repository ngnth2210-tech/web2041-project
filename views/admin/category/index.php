<div class="d-flex align-items-center justify-content-between mb-3">
    <p class="text-muted mb-0" style="font-size:13px;">Disable danh mục để ẩn — không xóa để giữ liên kết với sản phẩm cũ</p>
    <a href="<?= BASE_URL_ADMIN . '&action=create-category' ?>" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Thêm danh mục
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
                    <th>Tên danh mục</th>
                    <th>Trạng thái</th>
                    <th class="text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $cat):
                    $isActive = ($cat['status'] ?? 1) == 1;
                ?>
                <tr style="<?= !$isActive ? 'opacity:.5;' : '' ?>">
                    <td class="text-muted"><?= $cat['id'] ?></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:8px;height:8px;border-radius:50%;background:<?= $isActive?'#6366f1':'#9ca3af' ?>;flex-shrink:0;"></div>
                            <span style="font-weight:500;"><?= htmlspecialchars($cat['name']) ?></span>
                        </div>
                    </td>
                    <td>
                        <?php if($isActive): ?>
                            <span class="badge bg-success-subtle text-success"><i class="fas fa-circle me-1" style="font-size:7px;"></i>Hiển thị</span>
                        <?php else: ?>
                            <span class="badge bg-secondary-subtle text-secondary"><i class="fas fa-circle me-1" style="font-size:7px;"></i>Đã ẩn</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <a href="<?= BASE_URL_ADMIN . '&action=edit-category&id=' . $cat['id'] ?>" class="btn btn-sm btn-warning"><i class="fas fa-pen me-1"></i>Sửa</a>
                        <a href="<?= BASE_URL_ADMIN . '&action=toggle-category&id=' . $cat['id'] ?>"
                           onclick="return confirm('<?= $isActive ? 'Ẩn danh mục này?' : 'Hiển thị lại danh mục này?' ?>')"
                           class="btn btn-sm <?= $isActive ? 'btn-secondary' : 'btn-success' ?>">
                            <i class="fas <?= $isActive ? 'fa-eye-slash' : 'fa-eye' ?> me-1"></i>
                            <?= $isActive ? 'Ẩn' : 'Hiện' ?>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if(empty($data)): ?>
        <div class="text-center py-5 text-muted">
            <i class="fas fa-layer-group fa-3x mb-3 opacity-25"></i>
            <p>Chưa có danh mục nào.</p>
        </div>
        <?php endif; ?>
    </div>
</div>
