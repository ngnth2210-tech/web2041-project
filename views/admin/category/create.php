<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-layer-group me-2 text-primary"></i> Thêm danh mục mới
            </div>
            <div class="card-body p-4">
                <?php if(isset($error)): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
               <form action="<?= BASE_URL_ADMIN ?>&action=store-category" method="POST">
                    <div class="mb-4">
                        <label class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" required placeholder="Nhập tên danh mục...">
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Lưu lại</button>
                        <a href="<?= BASE_URL_ADMIN ?>&action=list-category" class="btn btn-light">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
