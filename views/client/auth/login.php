<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div style="text-align:center;margin-bottom:28px;">
                <div style="width:52px;height:52px;border-radius:14px;background:#16a34a;display:inline-flex;align-items:center;justify-content:center;font-size:22px;color:#fff;margin-bottom:14px;">
                    <i class="fas fa-leaf"></i>
                </div>
                <h4 style="font-weight:800;color:#111827;margin-bottom:4px;">Đăng nhập</h4>
                <p style="color:#6b7280;font-size:13.5px;margin:0;">Chào mừng bạn quay trở lại!</p>
            </div>

            <?php if(isset($error)): ?>
                <div class="alert alert-danger"><i class="fas fa-circle-exclamation me-2"></i><?= $error ?></div>
            <?php endif; ?>

            <?php if(isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i><?= $_SESSION['success_message'] ?></div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:28px;box-shadow:0 4px 20px rgba(0,0,0,0.05);">
                <form action="<?= BASE_URL ?>?action=handle-login" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Tên đăng nhập</label>
                        <div style="position:relative;">
                            <span style="position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:14px;"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" name="username" required placeholder="Nhập tên đăng nhập..." style="padding-left:38px;">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Mật khẩu</label>
                        <div style="position:relative;">
                            <span style="position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:14px;"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" name="password" required placeholder="Nhập mật khẩu..." style="padding-left:38px;">
                        </div>
                    </div>
                    <button type="submit" class="btn w-100" style="background:#16a34a;color:#fff;padding:11px;border-radius:10px;font-weight:700;font-size:14px;">
                        <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                    </button>
                </form>
                <div class="text-center mt-4" style="font-size:13.5px;color:#6b7280;">
                    Chưa có tài khoản? <a href="<?= BASE_URL ?>?action=register" style="color:#16a34a;font-weight:600;text-decoration:none;">Đăng ký ngay</a>
                </div>
            </div>
        </div>
    </div>
</div>
