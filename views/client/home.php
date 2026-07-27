<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Dự án đã khởi tạo thành công</h1>
        <p class="text-muted">Khung MVC thuần PHP — sẵn sàng để phát triển.</p>
    </div>

    <div class="row g-3 justify-content-center">
        <div class="col-md-4">
            <div class="info-card">
                <div class="info-label">PHP</div>
                <div class="info-value"><?= phpversion() ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-card">
                <div class="info-label">Document root</div>
                <div class="info-value"><?= e(PATH_ROOT) ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-card">
                <div class="info-label">Base URL</div>
                <div class="info-value"><?= e(BASE_URL) ?></div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h5 class="fw-bold mb-3">Bước tiếp theo</h5>
        <ol class="text-muted">
            <li>Tạo bảng trong CSDL <code><?= e(DB_NAME) ?></code> (xem <code>database.sql</code>).</li>
            <li>Thêm model mới vào <code>models/</code>, kế thừa <code>BaseModel</code>.</li>
            <li>Thêm controller vào <code>controllers/client/</code> hoặc <code>controllers/admin/</code>.</li>
            <li>Khai báo action mới trong <code>routes/client.php</code> hoặc <code>routes/admin.php</code>.</li>
            <li>Tạo view tương ứng trong <code>views/</code>.</li>
        </ol>
    </div>
</div>
