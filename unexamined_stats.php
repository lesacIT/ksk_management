<?php
require_once 'config.php';

// Xử lý xuất Excel danh sách bệnh nhân chưa khám
if (isset($_GET['export']) && $_GET['export'] == 'excel') {
    $filter_bp = $_GET['bp'] ?? '';
    $sql = "SELECT emp_no, name, bp, dept, created_at FROM employees WHERE is_received = 0";
    $params = [];
    if (!empty($filter_bp) && $filter_bp != 'all') {
        $sql .= " AND bp = :bp";
        $params[':bp'] = $filter_bp;
    }
    $sql .= " ORDER BY bp, emp_no";
    $stmt = $pdo->prepare($sql);
    foreach ($params as $key => $val) $stmt->bindValue($key, $val);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="benh_nhan_chua_kham_' . date('Y-m-d') . '.csv"');
    echo "\xEF\xBB\xBF";
    $output = fopen('php://output', 'w');
    fputcsv($output, ['MSNV', 'Họ tên', 'Bộ phận', 'Phòng ban', 'Ngày tạo']);
    foreach ($rows as $row) {
        fputcsv($output, [
            $row['emp_no'],
            $row['name'],
            $row['bp'],
            $row['dept'],
            date('d/m/Y', strtotime($row['created_at']))
        ]);
    }
    fclose($output);
    exit;
}

// Lấy dữ liệu thống kê theo bộ phận
$stats_sql = "SELECT bp, COUNT(*) as total FROM employees WHERE is_received = 0 GROUP BY bp ORDER BY total DESC";
$stats = $pdo->query($stats_sql)->fetchAll(PDO::FETCH_ASSOC);

// Lấy danh sách bộ phận để lọc
$bp_list = $pdo->query("SELECT DISTINCT bp FROM employees WHERE is_received = 0 AND bp IS NOT NULL AND bp != '' ORDER BY bp")->fetchAll(PDO::FETCH_COLUMN);

// Lấy danh sách bệnh nhân chưa khám (có lọc theo bộ phận nếu có)
$filter_bp = $_GET['bp'] ?? '';
$sql = "SELECT emp_no, name, bp, dept, created_at FROM employees WHERE is_received = 0";
$params = [];
if (!empty($filter_bp) && $filter_bp != 'all') {
    $sql .= " AND bp = :bp";
    $params[':bp'] = $filter_bp;
}
$sql .= " ORDER BY bp, emp_no";
$stmt = $pdo->prepare($sql);
foreach ($params as $key => $val) $stmt->bindValue($key, $val);
$stmt->execute();
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê bệnh nhân chưa khám</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background: #f4f6f9; }
        .card-header { background: linear-gradient(135deg, #2c3e50, #1a2632); color: white; }
        .filter-form { background: #fff; padding: 15px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        .stats-card { background: #fff; border-radius: 10px; padding: 15px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .stats-number { font-size: 2rem; font-weight: bold; color: #2c3e50; }
    </style>
</head>
<body>
<div class="container-fluid px-4 py-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-person-x"></i> Thống kê bệnh nhân chưa khám</h2>
        <div>
            <a href="index.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
            <a href="note_stats.php" class="btn btn-info"><i class="bi bi-journal-text"></i> Ghi chú</a>
        </div>
    </div>

    <!-- Biểu đồ và tổng số -->
    <div class="row">
        <div class="col-md-6">
            <div class="stats-card">
                <h5><i class="bi bi-pie-chart"></i> Thống kê theo bộ phận</h5>
                <canvas id="bpChart" width="400" height="300"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stats-card">
                <h5><i class="bi bi-bar-chart-steps"></i> Tổng quan</h5>
                <?php
                $total_unexamined = array_sum(array_column($stats, 'total'));
                ?>
                <div class="stats-number"><?= $total_unexamined ?></div>
                <p>Tổng số bệnh nhân chưa khám</p>
                <hr>
                <h6>Danh sách bộ phận có bệnh nhân chưa khám:</h6>
                <ul>
                    <?php foreach ($stats as $s): ?>
                        <li><strong><?= htmlspecialchars($s['bp']) ?></strong>: <?= $s['total'] ?> người</li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Form lọc theo bộ phận và xuất Excel -->
    <div class="filter-form">
        <form method="GET" action="" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Lọc theo bộ phận</label>
                <select name="bp" class="form-select">
                    <option value="all" <?= ($filter_bp == '' || $filter_bp == 'all') ? 'selected' : '' ?>>Tất cả bộ phận</option>
                    <?php foreach ($bp_list as $bp): ?>
                        <option value="<?= htmlspecialchars($bp) ?>" <?= ($filter_bp == $bp) ? 'selected' : '' ?>><?= htmlspecialchars($bp) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-funnel"></i> Lọc</button>
                <a href="?bp=all" class="btn btn-secondary">Xóa lọc</a>
            </div>
            <div class="col-md-4 text-end">
                <button type="button" id="exportExcelBtn" class="btn btn-success"><i class="bi bi-file-excel"></i> Xuất Excel danh sách</button>
            </div>
        </form>
    </div>

    <!-- Bảng danh sách bệnh nhân chưa khám -->
    <div class="card shadow-sm">
        <div class="card-header">
            <i class="bi bi-table"></i> Danh sách bệnh nhân chưa khám
            <?php if (!empty($filter_bp) && $filter_bp != 'all'): ?>
                - Bộ phận: <?= htmlspecialchars($filter_bp) ?>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="patientTable" class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>MSNV</th>
                            <th>Họ tên</th>
                            <th>Bộ phận</th>
                            <th>Phòng ban</th>
                            <th>Ngày tạo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($patients as $p): ?>
                            <tr>
                                <td><?= htmlspecialchars($p['emp_no']) ?></td>
                                <td><?= htmlspecialchars($p['name']) ?></td>
                                <td><?= htmlspecialchars($p['bp']) ?></td>
                                <td><?= htmlspecialchars($p['dept']) ?></td>
                                <td><?= date('d/m/Y', strtotime($p['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#patientTable').DataTable({
        language: {
            "sProcessing":   "Đang xử lý...",
            "sLengthMenu":   "Hiển thị _MENU_ dòng",
            "sZeroRecords":  "Không có bệnh nhân chưa khám",
            "sInfo":         "Hiển thị _START_ đến _END_ của _TOTAL_ dòng",
            "sInfoEmpty":    "Hiển thị 0 đến 0 của 0 dòng",
            "sSearch":       "Tìm kiếm:",
            "oPaginate": {
                "sFirst":    "Đầu",
                "sPrevious": "Trước",
                "sNext":     "Tiếp",
                "sLast":     "Cuối"
            }
        },
        order: [[0, 'asc']],
        pageLength: 25
    });

    // Xuất Excel
    $('#exportExcelBtn').click(function() {
        var bp = $('select[name="bp"]').val();
        var url = '?export=excel&bp=' + encodeURIComponent(bp);
        window.location.href = url;
    });
});

// Vẽ biểu đồ cột
const ctx = document.getElementById('bpChart').getContext('2d');
const bpLabels = <?= json_encode(array_column($stats, 'bp')) ?>;
const bpData = <?= json_encode(array_column($stats, 'total')) ?>;
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: bpLabels,
        datasets: [{
            label: 'Số bệnh nhân chưa khám',
            data: bpData,
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});
</script>
</body>
</html>