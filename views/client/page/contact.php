<style>
/* ── LIÊN HỆ ── */

/* Tiêu đề mục — định nghĩa tại chỗ, không mượn từ trang chủ */
.section-title { font-weight: 800; font-size: 22px; line-height: 1.32; letter-spacing: -.02em; color: #111827; margin: 0; }
.section-title::after { content: ''; display: block; width: 36px; height: 3px; border-radius: 2px; background: #0f766e; margin-top: 11px; }
.section-subtitle { font-size: 13.5px; color: #6b7280; line-height: 1.72; max-width: 46ch; margin: 12px 0 22px; }
.contact-hero { background: linear-gradient(135deg, #0f766e, #16a34a); color: #fff; border-radius: 18px; padding: 44px 42px; margin-bottom: 38px; position: relative; overflow: hidden; }
.contact-hero::after { content: ''; position: absolute; right: -70px; top: -50px; width: 240px; height: 240px; border-radius: 50%; background: rgba(255,255,255,.08); }
.contact-hero .eyebrow { font-size: 12px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; opacity: .85; margin-bottom: 10px; }
.contact-hero h1 { font-weight: 800; font-size: 32px; margin-bottom: 12px; line-height: 1.25; max-width: 20ch; }
.contact-hero p { font-size: 15px; opacity: .93; margin: 0; max-width: 58ch; line-height: 1.75; }

.contact-section { margin-bottom: 42px; }

/* Thẻ thông tin liên hệ */
.info-card { border: 1px solid #e5e7eb; border-radius: 14px; padding: 22px 20px; background: #fff; height: 100%; transition: all .22s; }
.info-card:hover { border-color: #86efac; box-shadow: 0 8px 26px rgba(22,163,74,.11); transform: translateY(-3px); }
.info-icon { width: 44px; height: 44px; border-radius: 12px; background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 18px; margin-bottom: 13px; }
.info-card h3 { font-weight: 700; font-size: 14.5px; color: #111827; margin-bottom: 7px; }
.info-card p { font-size: 13.8px; color: #374151; margin: 0 0 3px; line-height: 1.7; }
.info-card .sub { font-size: 12.5px; color: #9ca3af; }
.info-card a { color: #16a34a; text-decoration: none; font-weight: 600; }
.info-card a:hover { text-decoration: underline; }

/* Giờ làm việc */
.hours-wrap { border: 1px solid #e5e7eb; border-radius: 14px; overflow: hidden; background: #fff; }
.hours-row { display: flex; justify-content: space-between; align-items: center; gap: 14px; padding: 13px 18px; border-bottom: 1px solid #f3f4f6; font-size: 13.8px; }
.hours-row:last-child { border-bottom: none; }
.hours-day { color: #374151; font-weight: 600; }
.hours-time { color: #6b7280; font-variant-numeric: tabular-nums; }
.hours-row.closed .hours-time { color: #dc2626; font-weight: 600; }

/* Bản đồ giả lập */
.map-box { border: 1px solid #e5e7eb; border-radius: 16px; overflow: hidden; background: #f0fdf4; }
.map-inner { height: 268px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 9px; background-image: linear-gradient(#dcfce7 1px, transparent 1px), linear-gradient(90deg, #dcfce7 1px, transparent 1px); background-size: 34px 34px; }
.map-pin { width: 52px; height: 52px; border-radius: 50%; background: #16a34a; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 21px; box-shadow: 0 6px 18px rgba(22,163,74,.35); }
.map-label { font-weight: 700; font-size: 14px; color: #166534; }
.map-sub { font-size: 12.5px; color: #4b5563; }
.map-foot { padding: 14px 18px; border-top: 1px solid #dcfce7; font-size: 13px; color: #4b5563; background: #fff; }

/* FAQ */
.faq-item { border: 1px solid #e5e7eb; border-radius: 12px; padding: 17px 19px; background: #fff; margin-bottom: 11px; }
.faq-item:last-child { margin-bottom: 0; }
.faq-q { font-weight: 700; font-size: 14px; color: #111827; margin-bottom: 6px; display: flex; gap: 9px; align-items: flex-start; }
.faq-q i { color: #16a34a; margin-top: 3px; flex-shrink: 0; font-size: 13px; }
.faq-a { font-size: 13.5px; color: #6b7280; margin: 0 0 0 22px; line-height: 1.78; }

/* Dải liên hệ cuối trang */
.contact-cta { background: linear-gradient(135deg, #0f766e, #16a34a); border-radius: 16px; padding: 32px; color: #fff; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 18px; }
.contact-cta h3 { font-weight: 800; font-size: 21px; margin-bottom: 7px; letter-spacing: -.015em; }
.contact-cta p { margin: 0; opacity: .9; font-size: 14px; }
.cta-actions { display: flex; gap: 10px; flex-wrap: wrap; }
.cta-btn { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: 50px; font-weight: 700; font-size: 14px; text-decoration: none; white-space: nowrap; transition: all .18s; }
.cta-btn-solid { background: #fff; color: #0f766e; }
.cta-btn-solid:hover { background: #ecfdf5; color: #0f766e; transform: translateY(-2px); }
.cta-btn-ghost { border: 1.5px solid rgba(255,255,255,.55); color: #fff; }
.cta-btn-ghost:hover { background: rgba(255,255,255,.14); color: #fff; transform: translateY(-2px); }

@media (max-width: 767px) {
    .contact-hero { padding: 32px 22px; }
    .contact-hero h1 { font-size: 25px; }
    .contact-cta { padding: 26px 22px; }
}
</style>

<div class="container py-4">

    <!-- HERO -->
    <div class="contact-hero">
        <div class="eyebrow">Liên hệ</div>
        <h1>Có việc cần hỏi, cứ nhắn cho chúng tôi</h1>
        <p>Đặt hàng, đổi trả, hợp tác cung cấp nguyên liệu hay góp ý về sản phẩm — chúng tôi đều đọc và trả lời trong vòng 24 giờ làm việc.</p>
    </div>

    <!-- THÔNG TIN LIÊN HỆ -->
    <div class="contact-section">
        <div class="section-title">Thông tin liên hệ</div>
        <div class="section-subtitle">Chọn cách nào tiện nhất cho bạn</div>
        <div class="row g-3">
            <div class="col-md-6 col-lg-3">
                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-location-dot"></i></div>
                    <h3>Cửa hàng</h3>
                    <p>123 Đường ABC, quận Cầu Giấy, Hà Nội</p>
                    <div class="sub">Mời bạn ghé nếm thử trực tiếp</div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-phone"></i></div>
                    <h3>Tổng đài</h3>
                    <p><a href="tel:1800xxxx">1800 xxxx</a></p>
                    <div class="sub">Miễn phí gọi, 8 giờ đến 21 giờ mỗi ngày</div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-envelope"></i></div>
                    <h3>Email</h3>
                    <p><a href="mailto:hello@foodshop.vn">hello@foodshop.vn</a></p>
                    <div class="sub">Phản hồi trong 24 giờ làm việc</div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-handshake"></i></div>
                    <h3>Hợp tác</h3>
                    <p><a href="mailto:hoptac@foodshop.vn">hoptac@foodshop.vn</a></p>
                    <div class="sub">Dành cho nhà cung cấp và đại lý</div>
                </div>
            </div>
        </div>
    </div>

    <!-- GIỜ LÀM VIỆC + BẢN ĐỒ -->
    <div class="contact-section">
        <div class="row g-4">

            <div class="col-lg-5">
                <div class="section-title">Giờ làm việc</div>
                <div class="section-subtitle">Đơn đặt ngoài giờ được xử lý vào buổi làm việc kế tiếp</div>
                <div class="hours-wrap">
                    <div class="hours-row"><span class="hours-day">Thứ Hai – Thứ Sáu</span><span class="hours-time">8:00 – 21:00</span></div>
                    <div class="hours-row"><span class="hours-day">Thứ Bảy</span><span class="hours-time">8:00 – 20:00</span></div>
                    <div class="hours-row"><span class="hours-day">Chủ nhật</span><span class="hours-time">9:00 – 18:00</span></div>
                    <div class="hours-row closed"><span class="hours-day">Ngày lễ, Tết</span><span class="hours-time">Nghỉ</span></div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="section-title">Ghé cửa hàng</div>
                <div class="section-subtitle">Mời bạn tới nếm thử trước khi mua, nhân viên luôn có mặt trong giờ làm việc</div>
                <div class="map-box">
                    <div class="map-inner">
                        <div class="map-pin"><i class="fas fa-store"></i></div>
                        <div class="map-label">FoodShop Cầu Giấy</div>
                        <div class="map-sub">123 Đường ABC, Hà Nội</div>
                    </div>
                    <div class="map-foot">
                        <i class="fas fa-circle-info me-1" style="color:#16a34a;"></i>
                        Gần bến xe buýt số 27, có chỗ để xe máy trước cửa.
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- FAQ -->
    <div class="contact-section">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="section-title">Câu hỏi thường gặp</div>
                <div class="section-subtitle">Có thể câu trả lời bạn cần đã có sẵn ở đây</div>
            </div>
            <div class="col-md-8">
                <div class="faq-item">
                    <div class="faq-q"><i class="fas fa-circle-question"></i><span>Bao lâu thì tôi nhận được hàng?</span></div>
                    <p class="faq-a">Nội thành Hà Nội giao trong 24 giờ. Các tỉnh thành khác từ 2 đến 4 ngày làm việc. Đơn đặt trước 15 giờ được gửi đi ngay trong ngày.</p>
                </div>
                <div class="faq-item">
                    <div class="faq-q"><i class="fas fa-circle-question"></i><span>Tôi muốn hủy đơn thì làm thế nào?</span></div>
                    <p class="faq-a">Vào mục lịch sử đơn hàng, mở đơn cần hủy rồi bấm nút hủy. Chỉ hủy được khi đơn còn ở trạng thái chờ xác nhận. Đơn đã giao đi cần gọi tổng đài để được hỗ trợ.</p>
                </div>
                <div class="faq-item">
                    <div class="faq-q"><i class="fas fa-circle-question"></i><span>Hàng nhận về không đúng mô tả thì sao?</span></div>
                    <p class="faq-a">Bạn chụp ảnh sản phẩm và gửi kèm mã đơn qua form phía trên hoặc gọi tổng đài trong vòng 7 ngày kể từ khi nhận. Chúng tôi đổi mới hoặc hoàn tiền.</p>
                </div>
                <div class="faq-item">
                    <div class="faq-q"><i class="fas fa-circle-question"></i><span>Có nhận đặt hàng số lượng lớn không?</span></div>
                    <p class="faq-a">Có. Đơn quà tặng doanh nghiệp hoặc đặt sỉ vui lòng gửi email tới hoptac@foodshop.vn để nhận báo giá riêng.</p>
                </div>
                <div class="faq-item">
                    <div class="faq-q"><i class="fas fa-circle-question"></i><span>Thanh toán bằng cách nào?</span></div>
                    <p class="faq-a">Bạn chọn trả tiền mặt khi nhận hàng, hoặc thanh toán trước qua ví MoMo ngay ở bước đặt hàng.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- DẢI LIÊN HỆ -->
    <div class="contact-cta">
        <div>
            <h3>Chưa tìm thấy câu trả lời?</h3>
            <p>Gọi tổng đài hoặc gửi email, chúng tôi phản hồi trong 24 giờ làm việc.</p>
        </div>
        <div class="cta-actions">
            <a href="tel:1800xxxx" class="cta-btn cta-btn-solid">
                <i class="fas fa-phone"></i> 1800 xxxx
            </a>
            <a href="mailto:hello@foodshop.vn" class="cta-btn cta-btn-ghost">
                <i class="fas fa-envelope"></i> hello@foodshop.vn
            </a>
        </div>
    </div>

</div>
