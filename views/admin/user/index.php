<div class="d-flex align-items-center justify-content-between mb-3">
    <p class="text-muted mb-0" style="font-size:13px;">Xem thông tin & khóa/mở tài khoản — Email được ẩn để bảo vệ thông tin người dùng</p>
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
                    <th>Tài khoản</th>
                    <th>Số điện thoại</th>
                    <th>Quyền</th>
                    <th>Trạng thái</th>
                    <th class="text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $user): ?>
                <tr>
                    <td class="text-muted"><?= $user['id'] ?></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:13px;flex-shrink:0;">
                                <?= strtoupper(substr($user['username'],0,1)) ?>
                            </div>
                            <div>
                                <div style="font-weight:600;font-size:13.5px;"><?= htmlspecialchars($user['username']) ?></div>
                                <!-- Email ẩn bớt: chỉ hiện phần đầu -->
                                <?php
                                    $email = $user['email'] ?? '';
                                    $atPos = strpos($email, '@');
                                    $masked = $atPos > 2
                                        ? substr($email, 0, 2) . str_repeat('*', $atPos - 2) . substr($email, $atPos)
                                        : '***';
                                ?>
                                <div style="font-size:11.5px;color:#9ca3af;"><?= htmlspecialchars($masked) ?></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <?php if(!empty($user['phone'])): ?>
                            <span style="font-size:13px;"><?= htmlspecialchars($user['phone']) ?></span>
                        <?php else: ?>
                            <span class="text-muted" style="font-size:12px;">Chưa cập nhật</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($user['is_main'] == 1): ?>
                            <span class="badge" style="background:#ede9fe;color:#7c3aed;"><i class="fas fa-shield-halved me-1"></i>Admin</span>
                        <?php else: ?>
                            <span class="badge bg-secondary-subtle text-secondary">Người dùng</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if(($user['status']??1) == 1): ?>
                            <span class="badge bg-success-subtle text-success"><i class="fas fa-circle me-1" style="font-size:7px;"></i>Hoạt động</span>
                        <?php else: ?>
                            <span class="badge bg-danger-subtle text-danger"><i class="fas fa-circle me-1" style="font-size:7px;"></i>Đã khóa</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <!-- Chỉ có xem + khóa/mở, không có sửa -->
                        <a href="<?= BASE_URL_ADMIN . '&action=show-user&id=' . $user['id'] ?>"
                           class="btn btn-sm" style="background:#eff6ff;color:#3b82f6;border:1px solid #dbeafe;">
                            <i class="fas fa-eye me-1"></i>Xem
                        </a>

                        <?php if($user['is_main'] != 1): ?>
                            <?php if(($user['status']??1) == 1): ?>
                                <a href="<?= BASE_URL_ADMIN . '&action=lock-user&id=' . $user['id'] ?>"
                                   onclick="return confirm('Khóa tài khoản <?= htmlspecialchars($user['username']) ?>?')"
                                   class="btn btn-sm btn-danger">
                                    <i class="fas fa-lock me-1"></i>Khóa
                                </a>
                            <?php else: ?>
                                <a href="<?= BASE_URL_ADMIN . '&action=unlock-user&id=' . $user['id'] ?>"
                                   onclick="return confirm('Mở khóa tài khoản <?= htmlspecialchars($user['username']) ?>?')"
                                   class="btn btn-sm btn-success">
                                    <i class="fas fa-lock-open me-1"></i>Mở khóa
                                </a>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="btn btn-sm btn-light disabled" style="opacity:.4;" title="Không thể khóa Admin chính">
                                <i class="fas fa-shield-halved"></i>
                            </span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if(empty($data)): ?>
        <div class="text-center py-5 text-muted">
            <i class="fas fa-users fa-3x mb-3 opacity-25"></i>
            <p>Chưa có người dùng nào.</p>
        </div>
        <?php endif; ?>
    </div>
</div>
