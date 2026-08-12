<?php
$revenueLabels = [];
$revenueValues = [];
foreach ($revenueByMonth as $r) {
    [$y, $m] = explode('-', $r['month']);
    $revenueLabels[] = "T{$m}/{$y}";
    $revenueValues[] = (float)$r['revenue'];
}

$dayLabels = [];
$dayValues = [];
foreach ($ordersByDay as $d) {
    $dayLabels[] = date('d/m', strtotime($d['day']));
    $dayValues[] = (int)$d['total'];
}

$statusLabels = ['Chờ xác nhận', 'Đã xác nhận', 'Đang giao', 'Hoàn thành', 'Đã huỷ'];
$statusKeys   = ['pending', 'confirmed', 'shipping', 'completed', 'cancelled'];
$statusValues = array_map(fn($k) => $ordersByStatus[$k] ?? 0, $statusKeys);
$statusColors = ['#f59e0b', '#6366f1', '#3b82f6', '#10b981', '#ef4444'];

$catLabels = array_column($productsByCategory, 'name');
$catValues = array_map('intval', array_column($productsByCategory, 'total'));

function statusBadge($s)
{
    return match ($s) {
        'pending'   => '<span class="badge bg-warning text-dark">Chờ xác nhận</span>',
        'confirmed' => '<span class="badge bg-primary">Đã xác nhận</span>',
        'shipping'  => '<span class="badge bg-info text-dark">Đang giao</span>',
        'completed' => '<span class="badge bg-success">Hoàn thành</span>',
        'cancelled' => '<span class="badge bg-danger">Đã huỷ</span>',
        default     => '<span class="badge bg-secondary">' . $s . '</span>',
    };
}
function fmtMoney($v)
{
    return number_format($v, 0, ',', '.') . ' ₫';
}
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<style>
    .stat-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 20px 22px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, .05);
        transition: transform .2s, box-shadow .2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(0, 0, 0, .08);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .stat-value {
        font-size: 22px;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.1;
    }

    .stat-label {
        font-size: 12px;
        color: #64748b;
        font-weight: 500;
        margin-top: 2px;
    }

    .stat-sub {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 4px;
    }

    .chart-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, .04);
        height: 100%;
    }

    .chart-title {
        font-size: 13.5px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .chart-title i {
        color: #6366f1;
    }

    .top-product-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .top-product-row:last-child {
        border-bottom: none;
    }

    .top-product-img {
        width: 40px;
        height: 40px;
        border-radius: 9px;
        object-fit: cover;
        background: #f1f5f9;
        flex-shrink: 0;
    }

    .rank-badge {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .sold-bar-wrap {
        flex: 1;
        background: #f1f5f9;
        border-radius: 4px;
        height: 6px;
        min-width: 60px;
    }

    .sold-bar {
        height: 6px;
        border-radius: 4px;
        background: linear-gradient(90deg, #6366f1, #8b5cf6);
    }
</style>

<!-- HEADER -->
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h5 class="fw-bold mb-0" style="color:#0f172a">
            <i class="fas fa-chart-pie me-2" style="color:#6366f1"></i>Thống kê & Báo cáo
        </h5>
        <p class="text-muted mb-0" style="font-size:12.5px">Cập nhật theo thời gian thực từ cơ sở dữ liệu</p>
    </div>
    <span class="badge bg-light text-muted border" style="font-size:11.5px">
        <i class="fas fa-clock me-1"></i><?= date('d/m/Y H:i') ?>
    </span>
</div>

<!-- STAT CARDS -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eef2ff"><i class="fas fa-wallet" style="color:#6366f1"></i></div>
            <div>
                <div class="stat-value" style="font-size:17px"><?= fmtMoney($totalRevenue) ?></div>
                <div class="stat-label">Tổng doanh thu</div>
                <div class="stat-sub">Đơn hoàn thành</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#ecfdf5"><i class="fas fa-receipt" style="color:#10b981"></i></div>
            <div>
                <div class="stat-value"><?= number_format($totalOrders) ?></div>
                <div class="stat-label">Tổng đơn hàng</div>
                <div class="stat-sub"><?= ($ordersByStatus['completed'] ?? 0) ?> hoàn thành</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fff7ed"><i class="fas fa-box-open" style="color:#f59e0b"></i></div>
            <div>
                <div class="stat-value"><?= number_format($totalProducts) ?></div>
                <div class="stat-label">Sản phẩm</div>
                <div class="stat-sub">Trong kho</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fdf2f8"><i class="fas fa-users" style="color:#a855f7"></i></div>
            <div>
                <div class="stat-value"><?= number_format($totalUsers) ?></div>
                <div class="stat-label">Người dùng</div>
                <div class="stat-sub">Đã đăng ký</div>
            </div>
        </div>
    </div>
</div>

<!-- DOANH THU HÔM NAY / THÁNG -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="stat-card" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);border:none">
            <div class="stat-icon" style="background:rgba(255,255,255,.2)"><i class="fas fa-sun" style="color:#fff"></i></div>
            <div>
                <div class="stat-value" style="color:#fff;font-size:20px"><?= fmtMoney($revenueToday) ?></div>
                <div class="stat-label" style="color:rgba(255,255,255,.75)">Doanh thu hôm nay</div>
                <div class="stat-sub" style="color:rgba(255,255,255,.55)"><?= date('d/m/Y') ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="stat-card" style="background:linear-gradient(135deg,#10b981,#059669);border:none">
            <div class="stat-icon" style="background:rgba(255,255,255,.2)"><i class="fas fa-calendar-alt" style="color:#fff"></i></div>
            <div>
                <div class="stat-value" style="color:#fff;font-size:20px"><?= fmtMoney($revenueThisMonth) ?></div>
                <div class="stat-label" style="color:rgba(255,255,255,.75)">Doanh thu tháng này</div>
                <div class="stat-sub" style="color:rgba(255,255,255,.55)">Tháng <?= date('m/Y') ?></div>
            </div>
        </div>
    </div>
</div>

<!-- BIỂU ĐỒ HÀNG 1 -->
<div class="row g-3 mb-4">
    <div class="col-md-8">
        <div class="chart-card">
            <div class="chart-title"><i class="fas fa-chart-line"></i>Doanh thu 12 tháng qua</div>
            <canvas id="revenueChart" height="100"></canvas>
        </div>
    </div>
    <div class="col-md-4">
        <div class="chart-card">
            <div class="chart-title"><i class="fas fa-chart-pie"></i>Trạng thái đơn hàng</div>
            <canvas id="statusChart" height="180"></canvas>
            <div class="mt-3">
                <?php foreach ($statusKeys as $i => $sk): ?>
                    <div class="d-flex align-items-center gap-2 mb-1" style="font-size:12px">
                        <span style="width:10px;height:10px;border-radius:3px;background:<?= $statusColors[$i] ?>;flex-shrink:0"></span>
                        <span style="flex:1;color:#64748b"><?= $statusLabels[$i] ?></span>
                        <strong><?= $statusValues[$i] ?></strong>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- BIỂU ĐỒ HÀNG 2 -->
<div class="row g-3 mb-4">
    <div class="col-md-7">
        <div class="chart-card">
            <div class="chart-title"><i class="fas fa-chart-bar"></i>Số đơn hàng 30 ngày gần nhất</div>
            <canvas id="dailyChart" height="110"></canvas>
        </div>
    </div>
    <div class="col-md-5">
        <div class="chart-card">
            <div class="chart-title"><i class="fas fa-layer-group"></i>Sản phẩm theo danh mục</div>
            <canvas id="categoryChart" height="180"></canvas>
        </div>
    </div>
</div>

<!-- TOP SẢN PHẨM + ĐƠN MỚI NHẤT -->
<div class="row g-3 mb-2">
    <div class="col-md-5">
        <div class="chart-card">
            <div class="chart-title"><i class="fas fa-fire"></i>Top 5 sản phẩm bán chạy</div>
            <?php
            $maxSold    = max(1, max(array_column($topProducts, 'sold') ?: [1]));
            $rankColors = ['#f59e0b', '#94a3b8', '#cd7f32', '#6366f1', '#10b981'];
            foreach ($topProducts as $i => $p):
                $pct = round($p['sold'] / $maxSold * 100);
            ?>
                <div class="top-product-row">
                    <span class="rank-badge" style="background:<?= $rankColors[$i] ?? '#e2e8f0' ?>;color:#fff"><?= $i + 1 ?></span>
                    <?php if ($p['image']): ?>
                        <img src="<?= BASE_ASSETS_UPLOADS . htmlspecialchars($p['image']) ?>" class="top-product-img" alt="">
                    <?php else: ?>
                        <div class="top-product-img d-flex align-items-center justify-content-center text-muted"><i class="fas fa-image"></i></div>
                    <?php endif; ?>
                    <div style="flex:1;min-width:0">
                        <div style="font-size:13px;font-weight:600;color:#1e293b" class="text-truncate"><?= htmlspecialchars($p['name']) ?></div>
                        <div style="font-size:11.5px;color:#64748b"><?= fmtMoney($p['price']) ?></div>
                        <div class="d-flex align-items-center gap-2 mt-1">
                            <div class="sold-bar-wrap">
                                <div class="sold-bar" style="width:<?= $pct ?>%"></div>
                            </div>
                            <span style="font-size:11px;color:#64748b;white-space:nowrap"><?= number_format($p['sold']) ?> đã bán</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($topProducts)): ?>
                <p class="text-muted text-center py-3" style="font-size:13px">Chưa có dữ liệu</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-md-7">
        <div class="chart-card">
            <div class="chart-title d-flex justify-content-between align-items-center">
                <span><i class="fas fa-clock"></i>Đơn hàng mới nhất</span>
                <a href="?mode=admin&action=list-order" class="btn btn-sm btn-outline-secondary" style="font-size:11.5px">Xem tất cả</a>
            </div>
            <div class="table-responsive">
                <table class="table mb-0" style="font-size:12.5px">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($latestOrders as $ord): ?>
                            <tr>
                                <td><a href="?mode=admin&action=show-order&id=<?= $ord['id'] ?>" style="color:#6366f1;font-weight:600">#<?= $ord['id'] ?></a></td>
                                <td><?= htmlspecialchars($ord['customer_name']) ?></td>
                                <td style="font-weight:600"><?= fmtMoney($ord['total_price']) ?></td>
                                <td><?= statusBadge($ord['status']) ?></td>
                                <td style="color:#94a3b8"><?= date('d/m/Y', strtotime($ord['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($latestOrders)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">Chưa có đơn hàng</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    Chart.defaults.font.family = "'Be Vietnam Pro', sans-serif";
    Chart.defaults.font.size = 11;
    const gridColor = 'rgba(0,0,0,0.05)';

    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: <?= json_encode($revenueLabels) ?>,
            datasets: [{
                label: 'Doanh thu (₫)',
                data: <?= json_encode($revenueValues) ?>,
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99,102,241,0.08)',
                borderWidth: 2.5,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#6366f1',
                pointRadius: 4,
                pointHoverRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    grid: {
                        color: gridColor
                    },
                    ticks: {
                        callback: v => (v / 1e6).toFixed(1) + 'M ₫'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($statusLabels) ?>,
            datasets: [{
                data: <?= json_encode($statusValues) ?>,
                backgroundColor: <?= json_encode($statusColors) ?>,
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            cutout: '65%',
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    new Chart(document.getElementById('dailyChart'), {
        type: 'bar',
        data: {
            labels: <?= json_encode($dayLabels) ?>,
            datasets: [{
                label: 'Số đơn',
                data: <?= json_encode($dayValues) ?>,
                backgroundColor: 'rgba(99,102,241,0.7)',
                borderRadius: 5,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    grid: {
                        color: gridColor
                    },
                    ticks: {
                        stepSize: 1
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        maxTicksLimit: 10
                    }
                }
            }
        }
    });

    const catColors = ['#6366f1', '#10b981', '#f59e0b', '#ef4444', '#3b82f6', '#a855f7', '#ec4899', '#14b8a6'];
    new Chart(document.getElementById('categoryChart'), {
        type: 'pie',
        data: {
            labels: <?= json_encode($catLabels) ?>,
            datasets: [{
                data: <?= json_encode($catValues) ?>,
                backgroundColor: catColors.slice(0, <?= count($catLabels) ?>),
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 10
                    }
                }
            }
        }
    });
</script>