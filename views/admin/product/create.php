<?php if (!empty($_SESSION['errors'])): ?>
    <div class="alert alert-danger">
        <ul class="mb-0"><?php foreach($_SESSION['errors'] as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
    </div>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <span><i class="fas fa-plus-circle me-2 text-primary"></i>Thêm sản phẩm mới</span>
                <a href="<?= BASE_URL_ADMIN . '&action=list-product' ?>" class="btn btn-sm btn-light"><i class="fas fa-arrow-left me-1"></i>Quay lại</a>
            </div>
            <div class="card-body p-4">
                <form action="<?= BASE_URL_ADMIN . '&action=store-product' ?>" method="POST" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Nhập tên sản phẩm..."
                                   value="<?= htmlspecialchars($_SESSION['old']['name']??'') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Danh mục <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select">
                                <?php foreach($categories as $cat): ?>
                                <option value="<?= $cat["id"] ?>" <?= (isset($_SESSION['old']['category_id']) && $_SESSION['old']['category_id']==$cat['id'])?'selected':'' ?>><?= $cat["name"] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Mô tả</label>
                            <input type="text" name="description" class="form-control" placeholder="Mô tả ngắn về sản phẩm..."
                                   value="<?= htmlspecialchars($_SESSION['old']['description']??'') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Giá (đ) <span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control" placeholder="0"
                                   value="<?= htmlspecialchars($_SESSION['old']['price']??'') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Số lượng <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" class="form-control" placeholder="0"
                                   value="<?= htmlspecialchars($_SESSION['old']['quantity']??'') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Trọng lượng</label>
                            <input type="text" name="weights" class="form-control" placeholder="300g,500g,1kg"
                                   value="<?= htmlspecialchars($_SESSION['old']['weights']??'') ?>">
                            <div class="form-text">Cách nhau bằng dấu phẩy</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Ảnh sản phẩm</label>
                            <input type="file" name="image" class="form-control" accept="image/*" id="imgInput">
                            <div class="mt-2" id="imgPreview" style="display:none;">
                                <img id="imgPreviewEl" style="width:100px;height:100px;object-fit:cover;border-radius:10px;border:2px solid #e2e8f0;">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Lưu sản phẩm</button>
                        <a href="<?= BASE_URL_ADMIN . '&action=list-product' ?>" class="btn btn-light">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php unset($_SESSION['old']); ?>

<script>
document.getElementById('imgInput').addEventListener('change', function(e){
    const file = e.target.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = (ev) => {
            document.getElementById('imgPreviewEl').src = ev.target.result;
            document.getElementById('imgPreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});
</script>
