<style>
/* ── VỀ CHÚNG TÔI ── */

/* Tiêu đề mục — định nghĩa tại chỗ, không mượn từ trang chủ */
.section-title { font-weight: 800; font-size: 22px; line-height: 1.32; letter-spacing: -.02em; color: #111827; margin: 0; }
.section-title::after { content: ''; display: block; width: 36px; height: 3px; border-radius: 2px; background: #16a34a; margin-top: 11px; }
.section-subtitle { font-size: 13.5px; color: #6b7280; line-height: 1.72; max-width: 46ch; margin: 12px 0 22px; }

/* Nút hành động */
.page-btn { display: inline-flex; align-items: center; gap: 8px; padding: 12px 28px; border-radius: 50px; background: #16a34a; color: #fff; font-weight: 700; font-size: 14px; text-decoration: none; transition: all .18s; }
.page-btn:hover { background: #15803d; color: #fff; transform: translateY(-2px); box-shadow: 0 8px 22px rgba(22,163,74,.28); }
.about-hero { background: linear-gradient(135deg, #16a34a, #059669); color: #fff; border-radius: 18px; padding: 48px 44px; margin-bottom: 40px; position: relative; overflow: hidden; }
.about-hero::after { content: ''; position: absolute; right: -60px; top: -60px; width: 260px; height: 260px; border-radius: 50%; background: rgba(255,255,255,.08); }
.about-hero::before { content: ''; position: absolute; right: 60px; bottom: -90px; width: 180px; height: 180px; border-radius: 50%; background: rgba(255,255,255,.06); }
.about-hero .eyebrow { font-size: 12px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; opacity: .8; margin-bottom: 10px; }
.about-hero h1 { font-weight: 800; font-size: 34px; margin-bottom: 14px; max-width: 18ch; line-height: 1.25; }
.about-hero p { font-size: 15px; opacity: .92; margin: 0; max-width: 62ch; line-height: 1.75; }

.about-section { margin-bottom: 44px; }
.about-lead { font-size: 15.5px; line-height: 1.9; color: #374151; }
.about-lead p { margin-bottom: 14px; }
.about-lead p:last-child { margin-bottom: 0; }

.value-card { border: 1px solid #e5e7eb; border-radius: 14px; padding: 24px 22px; height: 100%; background: #fff; transition: all .22s; }
.value-card:hover { border-color: #86efac; box-shadow: 0 8px 28px rgba(22,163,74,.12); transform: translateY(-3px); }
.value-icon { width: 46px; height: 46px; border-radius: 12px; background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 19px; margin-bottom: 14px; }
.value-card h3 { font-weight: 700; font-size: 15px; color: #111827; margin-bottom: 7px; }
.value-card p { font-size: 13.5px; color: #6b7280; margin: 0; line-height: 1.75; }

.stat-strip { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 16px; padding: 30px 20px; }
.stat-item { text-align: center; padding: 8px 4px; }
.stat-num { font-weight: 800; font-size: 30px; color: #16a34a; line-height: 1.1; }
.stat-label { font-size: 12.5px; color: #4b5563; margin-top: 5px; }

.flow-step { display: flex; gap: 18px; padding: 20px 0; border-bottom: 1px dashed #e5e7eb; }
.flow-step:last-child { border-bottom: none; padding-bottom: 0; }
.flow-num { flex-shrink: 0; width: 38px; height: 38px; border-radius: 50%; background: #16a34a; color: #fff; font-weight: 800; font-size: 14px; display: flex; align-items: center; justify-content: center; }
.flow-body h4 { font-weight: 700; font-size: 14.5px; color: #111827; margin-bottom: 5px; }
.flow-body p { font-size: 13.5px; color: #6b7280; margin: 0; line-height: 1.75; }

.pledge-list { list-style: none; padding: 0; margin: 0; }
.pledge-list li { display: flex; gap: 11px; align-items: flex-start; padding: 11px 0; font-size: 14px; color: #374151; border-bottom: 1px solid #f3f4f6; }
.pledge-list li:last-child { border-bottom: none; }
.pledge-list i { color: #16a34a; margin-top: 4px; flex-shrink: 0; }

.about-cta { background: #fafafa; border: 1px solid #e5e7eb; border-radius: 16px; padding: 32px; text-align: center; }
.about-cta h3 { font-weight: 800; font-size: 20px; color: #111827; margin-bottom: 8px; }
.about-cta p { color: #6b7280; font-size: 14px; margin-bottom: 20px; }

@media (max-width: 767px) {
    .about-hero { padding: 34px 24px; }
    .about-hero h1 { font-size: 26px; }
}
</style>

<div class="container py-4">

    <!-- HERO -->
    <div class="about-hero">
        <div class="eyebrow">Về chúng tôi</div>
        <h1>Thực phẩm sạch, gửi thẳng từ vùng nguyên liệu tới bếp nhà bạn</h1>
        <p>FoodShop là cửa hàng đặc sản và thực phẩm khô, chọn lọc từ những vùng làm nghề lâu năm trên khắp cả nước. Chúng tôi tin rằng một món ngon tử tế thì phải biết rõ nó đến từ đâu.</p>
    </div>

    <!-- CÂU CHUYỆN -->
    <div class="about-section">
        <div class="row g-4 align-items-start">
            <div class="col-md-4">
                <div class="section-title">Câu chuyện của chúng tôi</div>
                <div class="section-subtitle">Từ một gian hàng nhỏ tới cửa hàng trực tuyến</div>
            </div>
            <div class="col-md-8 about-lead">
                <p>FoodShop bắt đầu từ một gian hàng nhỏ bán bò khô và cơm cháy do chính gia đình tự làm. Khách quen ngày một đông, nhiều người ở xa muốn mua nhưng không có cách nào đặt hàng, nên chúng tôi mở cửa hàng trực tuyến để ai ở đâu cũng mua được.</p>
                <p>Đến nay FoodShop làm việc trực tiếp với các hộ sản xuất ở Gia Lai, Đắk Lắk, Ninh Bình và Đà Lạt. Không qua trung gian, nên chúng tôi biết rõ từng mẻ hàng được làm ra thế nào và giữ được giá hợp lý cho người mua.</p>
                <p>Chúng tôi không bán thật nhiều mặt hàng. Mỗi sản phẩm lên kệ đều được nếm thử, kiểm tra hạn dùng và đóng gói lại tại kho trước khi giao đi.</p>
            </div>
        </div>
    </div>

    <!-- GIÁ TRỊ -->
    <div class="about-section">
        <div class="section-title">Điều chúng tôi giữ</div>
        <div class="section-subtitle">Bốn nguyên tắc không thay đổi kể từ ngày đầu</div>
        <div class="row g-3">
            <div class="col-md-6 col-lg-3">
                <div class="value-card">
                    <div class="value-icon"><i class="fas fa-seedling"></i></div>
                    <h3>Rõ nguồn gốc</h3>
                    <p>Mỗi sản phẩm đều ghi rõ nơi sản xuất và cơ sở làm ra. Bạn hỏi, chúng tôi trả lời được.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="value-card">
                    <div class="value-icon"><i class="fas fa-leaf"></i></div>
                    <h3>Không chất bảo quản</h3>
                    <p>Hàng làm theo mẻ nhỏ, hạn dùng ngắn. Chúng tôi chọn vị thật thay vì kéo dài hạn sử dụng.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="value-card">
                    <div class="value-icon"><i class="fas fa-truck-fast"></i></div>
                    <h3>Giao nhanh</h3>
                    <p>Nội thành Hà Nội giao trong 24 giờ. Các tỉnh thành khác từ 2 đến 4 ngày làm việc.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="value-card">
                    <div class="value-icon"><i class="fas fa-rotate-left"></i></div>
                    <h3>Đổi trả dễ</h3>
                    <p>Hàng không đúng mô tả hoặc hỏng khi nhận, chúng tôi đổi mới hoặc hoàn tiền trong 7 ngày.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- SỐ LIỆU -->
    <div class="about-section">
        <div class="stat-strip">
            <div class="row">
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="stat-num">5+</div>
                        <div class="stat-label">Năm hoạt động</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="stat-num">12.000</div>
                        <div class="stat-label">Khách hàng đã mua</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="stat-num">63</div>
                        <div class="stat-label">Tỉnh thành giao tới</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="stat-num">30+</div>
                        <div class="stat-label">Hộ sản xuất hợp tác</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- QUY TRÌNH -->
    <div class="about-section">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="section-title">Từ vùng nguyên liệu tới nhà bạn</div>
                <div class="section-subtitle">Bốn bước, không cắt bớt bước nào</div>
            </div>
            <div class="col-md-8">
                <div class="flow-step">
                    <div class="flow-num">1</div>
                    <div class="flow-body">
                        <h4>Chọn cơ sở sản xuất</h4>
                        <p>Chúng tôi tới tận nơi xem cách làm, hỏi về nguyên liệu đầu vào và xin giấy tờ an toàn thực phẩm trước khi nhập lô đầu tiên.</p>
                    </div>
                </div>
                <div class="flow-step">
                    <div class="flow-num">2</div>
                    <div class="flow-body">
                        <h4>Nếm thử và kiểm tra</h4>
                        <p>Mỗi mẻ hàng về kho đều được mở kiểm tra ngẫu nhiên: mùi vị, độ ẩm, bao bì và hạn dùng. Lô không đạt được trả lại ngay.</p>
                    </div>
                </div>
                <div class="flow-step">
                    <div class="flow-num">3</div>
                    <div class="flow-body">
                        <h4>Đóng gói tại kho</h4>
                        <p>Hàng được chia phần, hút chân không với sản phẩm cần thiết và dán nhãn ghi ngày đóng gói trước khi lên kệ.</p>
                    </div>
                </div>
                <div class="flow-step">
                    <div class="flow-num">4</div>
                    <div class="flow-body">
                        <h4>Giao tới tay khách</h4>
                        <p>Đơn đặt trước 15 giờ được gửi đi trong ngày. Bạn theo dõi được trạng thái đơn ngay trong mục lịch sử đơn hàng.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CAM KẾT -->
    <div class="about-section">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="section-title">Cam kết với khách hàng</div>
                <div class="section-subtitle">Những điều bạn luôn nhận được khi mua tại FoodShop</div>
            </div>
            <div class="col-md-8">
                <ul class="pledge-list">
                    <li><i class="fas fa-circle-check"></i><span>Giá niêm yết đúng bằng giá thanh toán, không phát sinh phụ phí ẩn.</span></li>
                    <li><i class="fas fa-circle-check"></i><span>Hàng còn tối thiểu hai phần ba hạn sử dụng tính từ ngày giao.</span></li>
                    <li><i class="fas fa-circle-check"></i><span>Thông tin cá nhân và địa chỉ của bạn không được chia sẻ cho bên thứ ba.</span></li>
                    <li><i class="fas fa-circle-check"></i><span>Mọi khiếu nại được phản hồi trong vòng 24 giờ làm việc.</span></li>
                    <li><i class="fas fa-circle-check"></i><span>Hủy đơn miễn phí khi đơn còn ở trạng thái chờ xác nhận.</span></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="about-cta">
        <h3>Bắt đầu với một món bạn thích</h3>
        <p>Hơn 30 mặt hàng đặc sản đang chờ bạn trong gian hàng.</p>
        <a href="<?= BASE_URL ?>?action=list-product" class="page-btn">
            <i class="fas fa-store"></i> Xem sản phẩm
        </a>
    </div>

</div>
