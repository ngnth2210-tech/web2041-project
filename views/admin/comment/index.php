<div class="d-flex align-items-center justify-content-between mb-3">
    <p class="text-muted mb-0" style="font-size:13px;">
        Kiểm duyệt và quản lý bình luận người dùng
    </p>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Người dùng</th>
                    <th>Sản phẩm</th>
                    <th>Nội dung</th>
                    <th>Ngày tạo</th>
                    <th>Trạng thái</th>
                    <th class="text-center">Thao tác</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($data as $cmt): ?>
                    <tr>
                        <td class="text-muted">
                            <?= $cmt["id"] ?>
                        </td>

                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="
                                    width:28px;
                                    height:28px;
                                    border-radius:6px;
                                    background:linear-gradient(135deg,#6366f1,#8b5cf6);
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    color:#fff;
                                    font-weight:700;
                                    font-size:11px;
                                    flex-shrink:0;
                                ">
                                    <?= strtoupper(substr($cmt["username"], 0, 1)) ?>
                                </div>

                                <span style="font-weight:500;font-size:13px;">
                                    <?= htmlspecialchars($cmt["username"]) ?>
                                </span>
                            </div>
                        </td>

                        <td>
                            <span class="badge" style="background:#ede9fe;color:#6d28d9;">
                                <?= htmlspecialchars($cmt["product_name"]) ?>
                            </span>
                        </td>

                        <td style="max-width:220px;font-size:13px;color:#374151;">
                            <?= htmlspecialchars($cmt["content"]) ?>
                        </td>

                        <td class="text-muted" style="font-size:12px;">
                            <?= date('d/m/Y H:i', strtotime($cmt["created_at"])) ?>
                        </td>

                        <td>
                            <?php if ($cmt["status"] == 1): ?>

                                <span class="badge bg-success-subtle text-success">
                                    <i class="fas fa-eye me-1"></i>
                                    Hiển thị
                                </span>

                            <?php else: ?>

                                <span class="badge bg-secondary-subtle text-secondary">
                                    <i class="fas fa-eye-slash me-1"></i>
                                    Ẩn
                                </span>

                            <?php endif; ?>
                        </td>

                        <td class="text-center">

                            <!-- NÚT ẨN / HIỆN -->
                            <a href="?mode=admin&action=update-comment&id=<?= $cmt['id'] ?>&status=<?= ($cmt['status'] == 1) ? 0 : 1 ?>"
                               class="btn btn-sm <?= ($cmt['status'] == 1) ? 'btn-warning' : 'btn-success' ?>">

                                <?= ($cmt['status'] == 1)
                                    ? '<i class="fas fa-eye-slash me-1"></i>Ẩn'
                                    : '<i class="fas fa-eye me-1"></i>Hiện'
                                ?>

                            </a>

                            <!-- NÚT XÓA -->
                            <a href="?mode=admin&action=delete-comment&id=<?= $cmt['id'] ?>"
                               onclick="return confirm('Xóa bình luận này?')"
                               class="btn btn-sm btn-danger">

                                <i class="fas fa-trash"></i>

                            </a>

                        </td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if (empty($data)): ?>

            <div class="text-center py-5 text-muted">
                <i class="fas fa-comments fa-3x mb-3 opacity-25"></i>
                <p>Chưa có bình luận nào.</p>
            </div>

        <?php endif; ?>

    </div>
</div>