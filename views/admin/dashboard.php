<h1 class="h3 fw-bold mb-4">Tổng quan</h1>

<div class="row g-3">
    <div class="col-md-4">
        <div class="info-card">
            <div class="info-label">Khu vực</div>
            <div class="info-value">Quản trị</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="info-card">
            <div class="info-label">CSDL</div>
            <div class="info-value"><?= e(DB_NAME) ?></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="info-card">
            <div class="info-label">PHP</div>
            <div class="info-value"><?= phpversion() ?></div>
        </div>
    </div>
</div>

<p class="text-muted mt-4">
    Thêm chức năng quản trị bằng cách tạo controller trong <code>controllers/admin/</code>
    rồi khai báo action trong <code>routes/admin.php</code>.
</p>
