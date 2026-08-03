<div class="d-flex align-items-center justify-content-between mb-3">
    <p class="text-muted mb-0" style="font-size:13px;">Chi tiết thông tin sản phẩm</p>
    <div class="d-flex gap-2">
        <a href="<?= BASE_URL_ADMIN ?>&action=edit-product&id=<?= $product['id'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-pen me-1"></i>Chỉnh sửa</a>
        <a href="<?= BASE_URL_ADMIN ?>&action=list-product" class="btn btn-light btn-sm"><i class="fas fa-arrow-left me-1"></i>Quay lại</a>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body p-3 text-center">
                <div style="background:#f8fafc;border-radius:12px;padding:16px;margin-bottom:14px;aspect-ratio:1;display:flex;align-items:center;justify-content:center;">
                    <img src="<?= BASE_ASSETS_UPLOADS . $product['image'] ?>" alt=""
                         style="max-width:100%;max-height:260px;object-fit:contain;border-radius:8px;">
                </div>
                <div style="font-weight:700;font-size:16px;color:#111827;"><?= htmlspecialchars($product['name']) ?></div>
                <div style="color:#6b7280;font-size:12.5px;margin-top:4px;">Mã: SP<?= $product['id'] ?></div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Thông tin sản phẩm</div>
            <div class="card-body p-0">
                <?php
                $fields = [
                    ['Mã sản phẩm', 'SP'.$product['id'], ''],
                    ['Giá bán', number_format($product['price']).'đ', 'text-danger fw-bold fs-5'],
                    ['Danh mục', $product['category_name']??$product['category_id'], 'badge' ],
                    ['Số lượng tồn', $product['quantity'], $product['quantity']>0?'text-success fw-bold':'text-danger fw-bold'],
                    ['Lượt xem', $product['view_count']??'N/A', 'text-muted'],
                ];
                foreach($fields as [$label, $val, $cls]):
                ?>
                <div style="display:flex;padding:13px 20px;border-bottom:1px solid #f1f5f9;font-size:13.5px;align-items:center;">
                    <span style="width:160px;color:#6b7280;font-weight:600;flex-shrink:0;"><?= $label ?></span>
                    <?php if($cls==='badge'): ?>
                        <span class="badge" style="background:#ede9fe;color:#6d28d9;"><?= htmlspecialchars($val) ?></span>
                    <?php else: ?>
                        <span class="<?= $cls ?>"><?= htmlspecialchars($val) ?></span>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
                <div style="padding:16px 20px;">
                    <div style="color:#6b7280;font-weight:600;font-size:13px;margin-bottom:8px;">Mô tả sản phẩm</div>
                    <div style="background:#f8fafc;border-radius:10px;padding:14px;font-size:13.5px;color:#374151;line-height:1.7;min-height:80px;">
                        <?= nl2br(htmlspecialchars($product['description'])) ?>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-top" style="padding:14px 20px;display:flex;justify-content:flex-end;gap:8px;">
                <a href="<?= BASE_URL_ADMIN ?>&action=edit-product&id=<?= $product['id'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-pen me-1"></i>Sửa sản phẩm</a>
                <a href="<?= BASE_URL_ADMIN ?>&action=delete-product&id=<?= $product['id'] ?>"
                   onclick="return confirm('Xóa sản phẩm này?')"
                   class="btn btn-danger btn-sm"><i class="fas fa-trash me-1"></i>Xóa</a>
            </div>
        </div>
    </div>
</div>
