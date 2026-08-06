<div class="d-flex align-items-center gap-2 mb-3">
    <a href="<?= BASE_URL_ADMIN ?>&action=list-user" class="btn btn-light btn-sm"><i class="fas fa-arrow-left me-1"></i>Danh sách</a>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <span><i class="fas fa-user me-2 text-primary"></i>Thông tin tài khoản</span>
            </div>
            <div class="card-body p-0">
                <!-- Avatar + tên -->
                <div style="padding:24px 20px;text-align:center;border-bottom:1px solid #f1f5f9;">
                    <div style="width:64px;height:64px;border-radius:16px;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:inline-flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:26px;margin-bottom:12px;">
                        <?= strtoupper(substr($data['username'],0,1)) ?>
                    </div>
                    <div style="font-weight:700;font-size:17px;color:#111827;"><?= htmlspecialchars($data['username']) ?></div>
                    <div style="margin-top:6px;">
                        <?php if($data['is_main'] == 1): ?>
                            <span class="badge" style="background:#ede9fe;color:#7c3aed;"><i class="fas fa-shield-halved me-1"></i>Administrator</span>
                        <?php else: ?>
                            <span class="badge bg-secondary-subtle text-secondary">Người dùng</span>
                        <?php endif; ?>
                        &nbsp;
                        <?php if(($data['status']??1) == 1): ?>
                            <span class="badge bg-success-subtle text-success">Đang hoạt động</span>
                        <?php else: ?>
                            <span class="badge bg-danger-subtle text-danger">Đã bị khóa</span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Chi tiết -->
                <?php
                $phone = $data['phone'] ?? null;
                $email = $data['email'] ?? '';
                // Chỉ cho phép xem SĐT đầy đủ, email ẩn bớt
                $atPos = strpos($email, '@');
                $maskedEmail = $atPos > 2
                    ? substr($email, 0, 2) . str_repeat('*', $atPos - 2) . substr($email, $atPos)
                    : '***@***';
                ?>
                <div style="padding:0;">
                    <div style="display:flex;padding:13px 20px;border-bottom:1px solid #f1f5f9;font-size:13.5px;gap:12px;align-items:center;">
                        <span style="width:140px;color:#6b7280;font-weight:600;flex-shrink:0;"><i class="fas fa-user me-2"></i>Tên đăng nhập</span>
                        <span style="font-weight:600;"><?= htmlspecialchars($data['username']) ?></span>
                    </div>
                    <div style="display:flex;padding:13px 20px;border-bottom:1px solid #f1f5f9;font-size:13.5px;gap:12px;align-items:center;">
                        <span style="width:140px;color:#6b7280;font-weight:600;flex-shrink:0;"><i class="fas fa-envelope me-2"></i>Email</span>
                        <span style="color:#6b7280;"><?= htmlspecialchars($maskedEmail) ?></span>
                        <span class="badge bg-secondary-subtle text-secondary" style="font-size:10px;">Ẩn</span>
                    </div>
                    <div style="display:flex;padding:13px 20px;border-bottom:1px solid #f1f5f9;font-size:13.5px;gap:12px;align-items:center;">
                        <span style="width:140px;color:#6b7280;font-weight:600;flex-shrink:0;"><i class="fas fa-phone me-2"></i>Số điện thoại</span>
                        <?php if($phone): ?>
                            <span style="font-weight:600;"><?= htmlspecialchars($phone) ?></span>
                        <?php else: ?>
                            <span class="text-muted">Chưa cập nhật</span>
                        <?php endif; ?>
                    </div>
                    <div style="display:flex;padding:13px 20px;font-size:13.5px;gap:12px;align-items:center;">
                        <span style="width:140px;color:#6b7280;font-weight:600;flex-shrink:0;"><i class="fas fa-id-badge me-2"></i>ID</span>
                        <span class="text-muted">#<?= $data['id'] ?></span>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-top" style="padding:14px 20px;display:flex;gap:8px;">
                <?php if($data['is_main'] != 1): ?>
                    <?php if(($data['status']??1) == 1): ?>
                        <a href="<?= BASE_URL_ADMIN ?>&action=lock-user&id=<?= $data['id'] ?>"
                           onclick="return confirm('Khóa tài khoản này?')"
                           class="btn btn-sm btn-danger"><i class="fas fa-lock me-1"></i>Khóa tài khoản</a>
                    <?php else: ?>
                        <a href="<?= BASE_URL_ADMIN ?>&action=unlock-user&id=<?= $data['id'] ?>"
                           onclick="return confirm('Mở khóa tài khoản này?')"
                           class="btn btn-sm btn-success"><i class="fas fa-lock-open me-1"></i>Mở khóa</a>
                    <?php endif; ?>
                <?php else: ?>
                    <span class="text-muted" style="font-size:12.5px;"><i class="fas fa-info-circle me-1"></i>Tài khoản Admin chính — không thể khóa</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
