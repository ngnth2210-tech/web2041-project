<?php
if (!empty($_SESSION['errors'])): ?>
    <div class="alert alert-danger">
        <ul class="mb-0"><?php foreach($_SESSION['errors'] as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
    </div>
    <?php unset($_SESSION['errors']);
endif;
$old = $_SESSION['old'] ?? null;
unset($_SESSION['old']);
?>

<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <span><i class="fas fa-pen me-2 text-warning"></i>Chỉnh sửa: <?= htmlspecialchars($product['name']) ?></span>
                <a href="<?= BASE_URL_ADMIN ?>&action=list-product" class="btn btn-sm btn-light"><i class="fas fa-arrow-left me-1"></i>Quay lại</a>
            </div>
            <div class="card-body p-4">
                <form action="<?= BASE_URL_ADMIN ?>&action=update-product&id=<?= $product['id'] ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="current_image" value="<?= $product['image'] ?>">
                    <div class="row g-4">
                        <!-- Image Column -->
                        <div class="col-md-3 text-center">
                            <label class="form-label d-block">Ảnh hiện tại</label>
                            <img src="<?= BASE_ASSETS_UPLOADS . $product['image'] ?>" alt="" id="currentImg"
                                 style="width:120px;height:120px;object-fit:cover;border-radius:12px;border:2px solid #e2e8f0;">
                            <div class="mt-3">
                                <label class="form-label d-block" style="font-size:12px;">Thay ảnh mới</label>
                                <input type="file" name="image" class="form-control form-control-sm" accept="image/*" id="imgInput">
                            </div>
                        </div>
                        <!-- Fields Column -->
                        <div class="col-md-9">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control"
                                           value="<?= htmlspecialchars($old['name']??$product['name']) ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Danh mục <span class="text-danger">*</span></label>
                                    <select name="category_id" class="form-select">
                                        <?php
                                        $selCat = $old['category_id'] ?? $product['category_id'];
                                        foreach($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>" <?= ($cat['id']==$selCat)?'selected':'' ?>><?= $cat['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Giá (đ) <span class="text-danger">*</span></label>
                                    <input type="number" name="price" class="form-control"
                                           value="<?= htmlspecialchars($old['price']??$product['price']) ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Số lượng <span class="text-danger">*</span></label>
                                    <input type="number" name="quantity" class="form-control"
                                           value="<?= htmlspecialchars($old['quantity']??$product['quantity']) ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Trọng lượng</label>
                                    <input type="text" name="weights" class="form-control" placeholder="300g,500g,1kg"
                                           value="<?= htmlspecialchars($old['weights']??$product['weights']??'') ?>">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Mô tả sản phẩm</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="Nhập mô tả..."><?= htmlspecialchars($old['description']??$product['description']) ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i>Cập nhật</button>
                        <a href="<?= BASE_URL_ADMIN ?>&action=list-product" class="btn btn-light">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('imgInput').addEventListener('change', function(e){
    const file = e.target.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = (ev) => { document.getElementById('currentImg').src = ev.target.result; };
        reader.readAsDataURL(file);
    }
});
</script>
