<?php
require_once 'config.php';
// Xuất CSV nếu có tham số export
if (isset($_GET['export']) && $_GET['export'] == 1) {
    $from = $_GET['from'] ?? '';
    $to = $_GET['to'] ?? '';
    if ($from && $to) {
        $stmt = $pdo->prepare("SELECT emp_no, name, bp, gender, received_date, is_returned FROM employees WHERE is_received = 1 AND received_date BETWEEN ? AND ? ORDER BY received_date DESC");
        $stmt->execute([$from . ' 00:00:00', $to . ' 23:59:59']);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="danh_sach_kham_' . date('Ymd') . '.csv"');
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM UTF-8
        fputcsv($output, ['Mã NV', 'Họ tên', 'Bộ phận', 'Giới tính', 'Ngày khám', 'Đã nhận hồ sơ']);
        foreach ($rows as $row) {
            fputcsv($output, [
                $row['emp_no'],
                $row['name'],
                $row['bp'],
                $row['gender'],
                $row['received_date'],
                $row['is_returned'] ? 'Có' : 'Chưa'
            ]);
        }
        fclose($output);
        exit;
    } else {
        die('Thiếu tham số ngày');
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê khám sức khỏe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="icon" type="image/jpeg" href="https://cdn-healthcare.hellohealthgroup.com/2022/11/1669708514_6385bae2942755.91630106.jpg">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background: #f4f6f9; }
        .card-header { background: linear-gradient(135deg, #2c3e50, #1a2632); color: white; }
    </style>
</head>
<body>
<div class="container-fluid px-4 py-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-graph-up"></i> Thống kê & Báo cáo</h2>
        <a href="index.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại quản lý</a>
    </div>

    <!-- Bộ lọc -->
    <div class="card shadow-sm mb-4">
        <div class="card-header">Chọn khoảng thời gian</div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Từ ngày</label>
                    <input type="date" id="fromDate" class="form-control" value="<?= date('Y-m-d', strtotime('-7 days')) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Đến ngày</label>
                    <input type="date" id="toDate" class="form-control" value="<?= date('Y-m-d') ?>">
                </div>
                <div class="col-md-12 d-flex align-items-end">
                    <button class="btn btn-primary me-2" id="btnFilter"><i class="bi bi-search"></i> Thống kê</button>
                    <button class="btn btn-success me-2" id="btnExport"><i class="bi bi-file-earmark-excel"></i> Xuất CSV</button>
                    <a href="admin_stats.php" class="btn btn-warning me-2"><i class="bi bi-people"></i> Nhập danh sách</a>
                    <a href="note_stats.php" class="btn btn-info me-2"><i class="bi bi-journal-text"></i> Báo cáo MSXN</a>
                    <a href="unexamined_stats.php" class="btn btn-dark"><i class="bi bi-person-x"></i> Thống kê chưa khám</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Thống kê nhanh -->
    <div class="row mb-4 g-3" id="statsCards">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <h5 class="text-muted">Tổng NV đã khám</h5>
                    <h2 class="text-primary" id="totalCount">0</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <h5 class="text-muted">Đã nhận hồ sơ</h5>
                    <h2 class="text-success" id="returnedCount">0</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <h5 class="text-muted">Chưa nhận hồ sơ</h5>
                    <h2 class="text-warning" id="notReturnedCount">0</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Biểu đồ -->
    <div class="card shadow-sm mb-4">
        <div class="card-header">Biểu đồ số lượng khám theo ngày</div>
        <div class="card-body">
            <canvas id="dailyChart" height="100"></canvas>
        </div>
    </div>

    <!-- Danh sách nhân viên đã khám -->
    <div class="card shadow-sm">
        <div class="card-header">Danh sách nhân viên đã khám</div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="examinedTable" class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr><th>Mã NV</th><th>Họ tên</th><th>Bộ phận</th><th>Giới tính</th><th>Ngày khám</th><th>Trạng thái hồ sơ</th></tr>
                    </thead>
                    <tbody></tbody>
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
    var table = $('#examinedTable').DataTable({
        processing: true,
        serverSide: false,
        order: [[4, 'desc']],
        language: { url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json" }
    });

    function loadStats(from, to) {
        $.get('api.php', { action: 'statsByDateRange', from: from, to: to }, function(res) {
            if (res.success) {
                $('#totalCount').text(res.total);
                $('#returnedCount').text(res.returned);
                $('#notReturnedCount').text(res.not_returned);
                if (res.daily && res.daily.length) {
                    var labels = res.daily.map(item => item.date);
                    var counts = res.daily.map(item => item.count);
                    if (window.myChart) window.myChart.destroy();
                    var ctx = document.getElementById('dailyChart').getContext('2d');
                    window.myChart = new Chart(ctx, {
                        type: 'bar',
                        data: { labels: labels, datasets: [{ label: 'Số lượng khám', data: counts, backgroundColor: 'rgba(54, 162, 235, 0.5)' }] }
                    });
                }
            } else alert('Lỗi tải thống kê');
        }, 'json');
    }

    function loadTableData(from, to) {
        $.get('api.php', { action: 'employeesByDateRange', from: from, to: to }, function(res) {
            if (res.success) {
                table.clear();
                res.data.forEach(row => {
                    table.row.add([
                        row.emp_no,
                        row.name,
                        row.bp,
                        row.gender,
                        row.received_date,
                        row.is_returned ? '<span class="badge bg-success">Đã nhận</span>' : '<span class="badge bg-danger">Chưa nhận</span>'
                    ]);
                });
                table.draw();
            }
        }, 'json');
    }

    $('#btnFilter').click(function() {
        var from = $('#fromDate').val();
        var to = $('#toDate').val();
        if (from && to) {
            loadStats(from, to);
            loadTableData(from, to);
        } else alert('Chọn đầy đủ ngày');
    });

    $('#btnExport').click(function() {
        var from = $('#fromDate').val();
        var to = $('#toDate').val();
        if (from && to) {
            window.location.href = 'admin.php?export=1&from=' + from + '&to=' + to;
        } else alert('Chọn đầy đủ ngày');
    });

    // Tự động tải khi vào trang
    $('#btnFilter').click();
});
</script>
</body>
</html>