<style>
/* ── KHUYẾN MÃI ── */

/* Tiêu đề mục — định nghĩa tại chỗ, không mượn từ trang chủ */
.section-title { font-weight: 800; font-size: 22px; line-height: 1.32; letter-spacing: -.02em; color: #111827; margin: 0; }
.section-title::after { content: ''; display: block; width: 36px; height: 3px; border-radius: 2px; background: #f59e0b; margin-top: 11px; }
.section-subtitle { font-size: 13.5px; color: #6b7280; line-height: 1.72; max-width: 50ch; margin: 12px 0 22px; }

/* Dải kêu gọi cuối trang */
.cta-band { background: linear-gradient(135deg, #16a34a, #059669); border-radius: 16px; padding: 32px; color: #fff; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 18px; margin-top: 8px; }
.cta-band h3 { font-weight: 800; font-size: 21px; margin-bottom: 7px; letter-spacing: -.015em; }
.cta-band p { margin: 0; opacity: .88; font-size: 14px; }
.page-btn { display: inline-flex; align-items: center; gap: 8px; padding: 12px 28px; border-radius: 50px; background: #fff; color: #16a34a; font-weight: 700; font-size: 14px; text-decoration: none; white-space: nowrap; transition: all .18s; }
.page-btn:hover { background: #f0fdf4; color: #15803d; transform: translateY(-2px); }
.promo-hero { background: linear-gradient(135deg, #f59e0b, #dc2626); color: #fff; border-radius: 18px; padding: 44px 42px; margin-bottom: 38px; position: relative; overflow: hidden; }
.promo-hero::after { content: ''; position: absolute; right: -50px; bottom: -70px; width: 230px; height: 230px; border-radius: 50%; background: rgba(255,255,255,.1); }
.promo-hero .eyebrow { font-size: 12px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; opacity: .85; margin-bottom: 10px; }
.promo-hero h1 { font-weight: 800; font-size: 32px; margin-bottom: 12px; line-height: 1.25; max-width: 20ch; }
.promo-hero p { font-size: 15px; opacity: .93; margin: 0; max-width: 58ch; line-height: 1.75; }

.promo-section { margin-bottom: 42px; }

/* Thẻ mã giảm giá */
.coupon { display: flex; border: 1.5px dashed #fbbf24; border-radius: 14px; background: #fffbeb; overflow: hidden; height: 100%; transition: all .22s; }
.coupon:hover { box-shadow: 0 8px 26px rgba(245,158,11,.18); transform: translateY(-3px); border-color: #f59e0b; }
.coupon-left { width: 104px; flex-shrink: 0; background: linear-gradient(160deg,#f59e0b,#d97706); color: #fff; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 14px 8px; text-align: center; }
.coupon-off { font-weight: 800; font-size: 24px; line-height: 1.05; }
.coupon-unit { font-size: 11.5px; opacity: .9; margin-top: 3px; }
.coupon-right { padding: 16px 18px; flex: 1; }
.coupon-right h3 { font-weight: 700; font-size: 15px; color: #111827; margin-bottom: 6px; }
.coupon-right p { font-size: 13px; color: #6b7280; margin-bottom: 10px; line-height: 1.7; }
.coupon-code { display: inline-flex; align-items: center; gap: 7px; font-weight: 800; font-size: 13.5px; letter-spacing: 1.2px; color: #b45309; background: #fef3c7; border: 1px solid #fcd34d; border-radius: 7px; padding: 5px 12px; }
.coupon-meta { font-size: 11.5px; color: #9ca3af; margin-top: 9px; }

/* Ưu đãi thường trực */
.perk-card { border: 1px solid #e5e7eb; border-radius: 14px; padding: 22px 20px; background: #fff; height: 100%; transition: all .22s; }
.perk-card:hover { border-color: #86efac; box-shadow: 0 8px 26px rgba(22,163,74,.11); transform: translateY(-3px); }
.perk-icon { width: 44px; height: 44px; border-radius: 12px; background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 18px; margin-bottom: 13px; }
.perk-card h3 { font-weight: 700; font-size: 14.5px; color: #111827; margin-bottom: 6px; }
.perk-card p { font-size: 13.5px; color: #6b7280; margin: 0; line-height: 1.75; }

/* Bảng hạng thành viên */
.tier-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
.tier-table th { background: #f0fdf4; color: #166534; font-weight: 700; font-size: 12.5px; text-transform: uppercase; letter-spacing: .5px; padding: 12px 14px; text-align: left; border-bottom: 2px solid #bbf7d0; white-space: nowrap; }
.tier-table td { padding: 13px 14px; border-bottom: 1px solid #f3f4f6; color: #374151; }
.tier-table tr:last-child td { border-bottom: none; }
.tier-table tbody tr:hover { background: #fafafa; }
.tier-name { font-weight: 700; color: #111827; }
.tier-wrap { border: 1px solid #e5e7eb; border-radius: 14px; overflow: hidden; }
.table-scroll { overflow-x: auto; }

/* Thể lệ */
.rule-list { list-style: none; padding: 0; margin: 0; counter-reset: rule; }
.rule-list li { position: relative; padding: 12px 0 12px 38px; font-size: 13.8px; color: #374151; line-height: 1.75; border-bottom: 1px solid #f3f4f6; counter-increment: rule; }
.rule-list li:last-child { border-bottom: none; }
.rule-list li::before { content: counter(rule); position: absolute; left: 0; top: 12px; width: 24px; height: 24px; border-radius: 50%; background: #f3f4f6; color: #4b5563; font-size: 11.5px; font-weight: 700; display: flex; align-items: center; justify-content: center; }

.notice-box { background: #fef2f2; border: 1px solid #fecaca; border-left: 4px solid #dc2626; border-radius: 10px; padding: 16px 18px; }
.notice-box h4 { font-weight: 700; font-size: 14px; color: #991b1b; margin-bottom: 7px; }
.notice-box p { font-size: 13.3px; color: #7f1d1d; margin: 0; line-height: 1.75; }

@media (max-width: 767px) {
    .promo-hero { padding: 32px 22px; }
    .promo-hero h1 { font-size: 25px; }
    .coupon-left { width: 88px; }
}
</style>

<div class="container py-4">

    <!-- HERO -->
    <div class="promo-hero">
        <div class="eyebrow">Khuyến mãi</div>
        <h1>Ưu đãi đang chạy tại FoodShop</h1>
        <p>Đọc mã cho nhân viên khi mua tại cửa hàng, hoặc báo mã khi đặt qua tổng đài 1800 xxxx. Mỗi đơn hàng áp dụng một mã, không cộng dồn với nhau.</p>
    </div>

    <!-- MÃ GIẢM GIÁ -->
    <div class="promo-section">
        <div class="section-title">Mã giảm giá trong tháng</div>
        <div class="section-subtitle">Áp dụng khi mua tại cửa hàng hoặc đặt qua tổng đài, số lượng mã có hạn</div>
        <div class="row g-3">

            <div class="col-md-6">
                <div class="coupon">
                    <div class="coupon-left">
                        <div class="coupon-off">15%</div>
                        <div class="coupon-unit">tối đa 50.000đ</div>
                    </div>
                    <div class="coupon-right">
                        <h3>Chào khách mới</h3>
                        <p>Dành cho tài khoản vừa đăng ký, dùng cho đơn hàng đầu tiên.</p>
                        <span class="coupon-code"><i class="fas fa-ticket"></i> FOODNEW15</span>
                        <div class="coupon-meta">Đơn từ 200.000đ · Mỗi tài khoản dùng một lần</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="coupon">
                    <div class="coupon-left">
                        <div class="coupon-off">30K</div>
                        <div class="coupon-unit">giảm trực tiếp</div>
                    </div>
                    <div class="coupon-right">
                        <h3>Cuối tuần vui vẻ</h3>
                        <p>Dùng được vào thứ Bảy và Chủ nhật hàng tuần cho mọi mặt hàng.</p>
                        <span class="coupon-code"><i class="fas fa-ticket"></i> WEEKEND30</span>
                        <div class="coupon-meta">Đơn từ 300.000đ · Áp dụng thứ Bảy và Chủ nhật</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="coupon">
                    <div class="coupon-left">
                        <div class="coupon-off">0đ</div>
                        <div class="coupon-unit">phí giao hàng</div>
                    </div>
                    <div class="coupon-right">
                        <h3>Miễn phí vận chuyển</h3>
                        <p>Bỏ toàn bộ phí giao hàng, áp dụng trên phạm vi cả nước.</p>
                        <span class="coupon-code"><i class="fas fa-ticket"></i> FREESHIP</span>
                        <div class="coupon-meta">Đơn từ 500.000đ · Không giới hạn số lần dùng</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="coupon">
                    <div class="coupon-left">
                        <div class="coupon-off">10%</div>
                        <div class="coupon-unit">toàn bộ đơn</div>
                    </div>
                    <div class="coupon-right">
                        <h3>Mua nhiều tiết kiệm nhiều</h3>
                        <p>Dành cho đơn mua từ năm sản phẩm trở lên, không kể loại hàng.</p>
                        <span class="coupon-code"><i class="fas fa-ticket"></i> COMBO10</span>
                        <div class="coupon-meta">Từ 5 sản phẩm · Không áp dụng cùng mã khác</div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- ƯU ĐÃI THƯỜNG TRỰC -->
    <div class="promo-section">
        <div class="section-title">Ưu đãi luôn có</div>
        <div class="section-subtitle">Không cần mã, nhân viên áp dụng sẵn khi đơn đủ điều kiện</div>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="perk-card">
                    <div class="perk-icon"><i class="fas fa-box-open"></i></div>
                    <h3>Tặng quà kèm đơn</h3>
                    <p>Đơn từ 700.000đ được tặng một hộp trà nhỏ dùng thử, gói cùng đơn hàng.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="perk-card">
                    <div class="perk-icon"><i class="fas fa-cake-candles"></i></div>
                    <h3>Ưu đãi sinh nhật</h3>
                    <p>Giảm 20% cho một đơn trong tháng sinh nhật của bạn, tối đa 100.000đ.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="perk-card">
                    <div class="perk-icon"><i class="fas fa-arrows-rotate"></i></div>
                    <h3>Mua lại nhanh</h3>
                    <p>Đặt lại đơn cũ từ mục lịch sử đơn hàng được giảm thêm 5% cho lần mua tiếp theo.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- HẠNG THÀNH VIÊN -->
    <div class="promo-section">
        <div class="section-title">Hạng thành viên</div>
        <div class="section-subtitle">Tính theo tổng tiền các đơn đã hoàn thành trong 12 tháng gần nhất</div>
        <div class="tier-wrap">
            <div class="table-scroll">
                <table class="tier-table">
                    <thead>
                        <tr>
                            <th>Hạng</th>
                            <th>Điều kiện</th>
                            <th>Giảm giá mỗi đơn</th>
                            <th>Quyền lợi thêm</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="tier-name">Thành viên</td>
                            <td>Đăng ký tài khoản</td>
                            <td>2%</td>
                            <td>Nhận mã giảm giá qua email</td>
                        </tr>
                        <tr>
                            <td class="tier-name">Bạc</td>
                            <td>Từ 3.000.000đ</td>
                            <td>5%</td>
                            <td>Miễn phí giao hàng nội thành</td>
                        </tr>
                        <tr>
                            <td class="tier-name">Vàng</td>
                            <td>Từ 8.000.000đ</td>
                            <td>8%</td>
                            <td>Miễn phí giao hàng toàn quốc, đổi trả trong 14 ngày</td>
                        </tr>
                        <tr>
                            <td class="tier-name">Kim cương</td>
                            <td>Từ 20.000.000đ</td>
                            <td>12%</td>
                            <td>Ưu tiên giữ hàng mùa cao điểm, tặng quà cuối năm</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- THỂ LỆ -->
    <div class="promo-section">
        <div class="row g-4">
            <div class="col-md-7">
                <div class="section-title">Thể lệ áp dụng</div>
                <div class="section-subtitle">Đọc trước khi dùng mã để tránh nhầm lẫn</div>
                <ul class="rule-list">
                    <li>Mỗi đơn hàng chỉ dùng được một mã giảm giá, các mã không cộng dồn với nhau.</li>
                    <li>Giá trị đơn để xét điều kiện là tổng tiền hàng, chưa gồm phí giao hàng.</li>
                    <li>Đọc mã cho nhân viên thu ngân tại cửa hàng, hoặc báo mã cho tổng đài viên khi đặt qua điện thoại.</li>
                    <li>Đơn bị hủy hoặc hoàn trả thì mã đã dùng không được trả lại.</li>
                    <li>Ưu đãi theo hạng thành viên được nhân viên tra cứu theo số điện thoại của bạn và cộng được với quà tặng kèm đơn.</li>
                </ul>
            </div>
            <div class="col-md-5">
                <div class="section-title">Cần lưu ý</div>
                <div class="section-subtitle">Vài trường hợp mã sẽ không dùng được</div>
                <div class="notice-box">
                    <h4>Mã không áp dụng khi</h4>
                    <p>Sản phẩm đang trong đợt giảm giá riêng, hoặc mã đã hết lượt sử dụng trong ngày. Khi đó nhân viên sẽ báo lại ngay để bạn chọn mã khác.</p>
                </div>
                <div class="notice-box" style="margin-top:14px;background:#f0fdf4;border-color:#bbf7d0;border-left-color:#16a34a;">
                    <h4 style="color:#166534;">Chưa có tài khoản?</h4>
                    <p style="color:#15803d;">Đăng ký để bắt đầu tích lũy hạng thành viên. Mọi đơn đặt trên website đều được ghi nhận vào tổng chi tiêu của bạn.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="cta-band">
        <div>
            <h3>Xem hàng trước, ưu đãi tính sau</h3>
            <p>Chương trình áp dụng cho toàn bộ sản phẩm đang bán tại FoodShop.</p>
        </div>
        <a href="<?= BASE_URL ?>?action=list-product" class="page-btn">
            <i class="fas fa-store"></i> Mua sắm ngay
        </a>
    </div>

</div>
