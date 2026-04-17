<?php
require_once 'config.php';

// Xử lý xuất CSV
if (isset($_GET['export']) && $_GET['export'] == 1) {
    $from = $_GET['from'] ?? '';
    $to = $_GET['to'] ?? '';
    if ($from && $to) {
        $stmt = $pdo->prepare("SELECT emp_no, name, bp, gender, received_date, is_returned FROM employees WHERE is_received = 1 AND received_date BETWEEN ? AND ? ORDER BY received_date DESC");
        $stmt->execute([$from . ' 00:00:00', $to . ' 23:59:59']);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="danh_sach_da_kham_' . date('Ymd') . '.csv"');
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($output, ['Mã NV', 'Họ tên', 'Bộ phận', 'Giới tính', 'Ngày khám', 'Đã nhận hồ sơ']);
        foreach ($rows as $row) {
            fputcsv($output, [$row['emp_no'], $row['name'], $row['bp'], $row['gender'], $row['received_date'], $row['is_returned'] ? 'Có' : 'Chưa']);
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
    <title>Admin - Thống kê & Import danh sách khám</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background: #f0f2f5; }
        .card-header { background: linear-gradient(135deg, #2c3e50, #1a2632); color: white; }
        .btn-quick { margin-right: 5px; }
        .dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter {
    display: inline-block;
    vertical-align: middle;
    margin-right: 20px;
}
.dataTables_wrapper .dataTables_filter {
    float: right;
    margin-right: 0;
   margin-bottom: 10px;
}
@media (max-width: 768px) {
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        display: block;
        float: none;
        margin-bottom: 10px;
    }
}
    </style>
</head>
<body>
<div class="container-fluid px-4 py-3">
    <div class="d-flex justify-content-between mb-4">
        <h2><i class="bi bi-calendar-check"></i> Admin: Thống kê & Import danh sách đã khám</h2>
        <div>
            <a href="index.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại quản lý</a>
        </div>
    </div>

    <div id="globalMsg"></div>

    <div class="row">
        <!-- Import file CSV -->
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm">
                <div class="card-header">Import danh sách nhân viên đã khám (CSV)</div>
                <div class="card-body">
                    <form id="importExamForm" enctype="multipart/form-data" action="import_csv.php" method="post">
                        <div class="mb-3">
                            <label class="form-label">Chọn file CSV (chỉ cần cột EmpNo)</label>
                            <input type="file" name="csv_file" class="form-control" accept=".csv" required>
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> File CSV phải có cột <strong>EmpNo</strong> (mã nhân viên). 
                                <a href="sample_import.csv" download class="ms-2"><i class="bi bi-download"></i> Tải file mẫu</a>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-upload"></i> Import & Cập nhật đã khám</button>
                    </form>
                    <div id="importMsg" class="mt-2"></div>
                </div>
            </div>
        </div>

        <!-- Thống kê -->
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm">
                <div class="card-header">Thống kê theo khoảng thời gian</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label>Từ ngày</label>
                            <input type="date" id="fromDate" class="form-control" value="<?= date('Y-m-d', strtotime('-30 days')) ?>">
                        </div>
                        <div class="col-md-4">
                            <label>Đến ngày</label>
                            <input type="date" id="toDate" class="form-control" value="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button class="btn btn-primary me-2" id="btnFilter"><i class="bi bi-search"></i> Thống kê</button>
                            <button class="btn btn-success" id="btnExport"><i class="bi bi-download"></i> Xuất CSV</button>
                        </div>
                    </div>
                    <div class="mt-2">
                        <button class="btn btn-sm btn-outline-secondary btn-quick" data-days="0">Hôm nay</button>
                        <button class="btn btn-sm btn-outline-secondary btn-quick" data-days="1">Hôm qua</button>
                        <button class="btn btn-sm btn-outline-secondary btn-quick" data-days="7">7 ngày qua</button>
                        <button class="btn btn-sm btn-outline-secondary btn-quick" data-days="30">30 ngày qua</button>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-md-4">
                            <h5>Tổng đã khám</h5>
                            <h3 id="totalCount" class="text-primary">0</h3>
                        </div>
                        <div class="col-md-4">
                            <h5>Đã nhận hồ sơ</h5>
                            <h3 id="returnedCount" class="text-success">0</h3>
                        </div>
                        <div class="col-md-4">
                            <h5>Chưa nhận hồ sơ</h5>
                            <h3 id="notReturnedCount" class="text-warning">0</h3>
                        </div>
                    </div>
                    <canvas id="dailyChart" height="150" class="mt-3"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Danh sách nhân viên đã khám -->
    <div class="card shadow-sm">
        <div class="card-header">Danh sách nhân viên đã khám (trong khoảng)</div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="examinedTable" class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr><th>Mã NV</th><th>Họ tên</th><th>Bộ phận</th><th>Giới tính</th><th>Ngày khám</th><th>Nhận hồ sơ</th><th>Ghi chú</th></tr>
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
<script>
$(document).ready(function() {
    var table = $('#examinedTable').DataTable({
        order: [[4, 'desc']],
      //language: { url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json" }
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
                } else {
                    if (window.myChart) window.myChart.destroy();
                }
            } else {
                alert('Lỗi tải thống kê: ' + (res.error || 'Không xác định'));
            }
        }, 'json').fail(function() {
            alert('Không thể kết nối đến API. Vui lòng kiểm tra file api.php');
        });
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
                        row.received_date ? row.received_date.replace(' ', '<br>') : '',
                        row.is_returned ? '<span class="badge bg-success">Đã nhận</span>' : '<span class="badge bg-danger">Chưa nhận</span>',
                        row.note || ''
                    ]);
                });
                table.draw();
            } else {
                alert('Lỗi tải dữ liệu: ' + (res.error || 'Không xác định'));
            }
        }, 'json').fail(function() {
            alert('Không thể kết nối đến API. Vui lòng kiểm tra file api.php');
        });
    }

    function setDateRange(days) {
        let toDate = new Date();
        let fromDate = new Date();
        if (days === 0) {
            // hôm nay
            fromDate = new Date();
        } else if (days === 1) {
            // hôm qua
            fromDate.setDate(toDate.getDate() - 1);
            toDate = new Date(fromDate);
        } else {
            fromDate.setDate(toDate.getDate() - days);
        }
        $('#fromDate').val(fromDate.toISOString().slice(0,10));
        $('#toDate').val(toDate.toISOString().slice(0,10));
        $('#btnFilter').click();
    }

    $('.btn-quick').click(function() {
        let days = $(this).data('days');
        setDateRange(days);
    });

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
            window.location.href = 'admin_stats.php?export=1&from=' + from + '&to=' + to;
        } else alert('Chọn đầy đủ ngày');
    });

    // Import form AJAX
    $('#importExamForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: 'import_csv.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                try {
                    var data = JSON.parse(res);
                    if (data.success) {
                        $('#importMsg').html('<div class="alert alert-success">Import thành công! Đã cập nhật ' + data.updated + ' nhân viên.</div>');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        $('#importMsg').html('<div class="alert alert-danger">Lỗi: ' + data.error + '</div>');
                    }
                } catch(e) {
                    $('#importMsg').html('<div class="alert alert-danger">Lỗi phân tích phản hồi từ server: ' + res + '</div>');
                }
            },
            error: function(xhr) {
                $('#importMsg').html('<div class="alert alert-danger">Lỗi kết nối: ' + xhr.statusText + '</div>');
            }
        });
    });

    // Tự động tải ban đầu
    $('#btnFilter').click();
});
</script>
</body>
</html>