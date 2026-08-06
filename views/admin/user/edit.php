<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <span><i class="fas fa-pen me-2 text-warning"></i>Chỉnh sửa tài khoản</span>
                <a href="<?= BASE_URL_ADMIN . '&action=list-user' ?>" class="btn btn-sm btn-light"><i class="fas fa-arrow-left me-1"></i>Quay lại</a>
            </div>
            <div class="card-body p-4">
                <?php if(isset($error)): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
                <form action="<?= BASE_URL_ADMIN . '&action=update-user&id=' . $data['id'] ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Tên tài khoản <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($data['username']) ?>" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($data['email']) ?>" required>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i>Lưu thay đổi</button>
                        <a href="<?= BASE_URL_ADMIN . '&action=list-user' ?>" class="btn btn-light">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
