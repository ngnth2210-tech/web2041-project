<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-pen me-2 text-warning"></i> Chỉnh sửa danh mục
            </div>
            <div class="card-body p-4">
                <?php if(isset($error)): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
             <form action="<?= BASE_URL_ADMIN ?>&action=update-category&id=<?= $data['id'] ?>" method="POST">
                    <div class="mb-4">
                        <label class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($data['name']) ?>" required>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i>Cập nhật</button>
                        <a href="<?= BASE_URL_ADMIN ?>&action=list-category" class="btn btn-light">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
