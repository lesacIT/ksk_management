<?php
require_once 'config.php';

// Xử lý xuất Excel (dùng created_at, chỉ lấy note có nội dung)
if (isset($_GET['export']) && $_GET['export'] == 'excel') {
    $filter_type = $_GET['filter_type'] ?? 'all';
    $from_date = $_GET['from_date'] ?? '';
    $to_date = $_GET['to_date'] ?? '';

    // Chỉ lấy các dòng có ghi chú không rỗng
    $sql = "SELECT emp_no, name, bp, note, created_at FROM employees WHERE note IS NOT NULL AND note != ''";
    $params = [];

    if ($filter_type == 'today') {
        $sql .= " AND DATE(created_at) = CURDATE()";
    } elseif ($filter_type == 'week') {
        $sql .= " AND YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)";
    } elseif ($filter_type == 'month') {
        $sql .= " AND MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
    } elseif ($filter_type == 'range' && !empty($from_date) && !empty($to_date)) {
        $sql .= " AND DATE(created_at) BETWEEN :from_date AND :to_date";
        $params[':from_date'] = $from_date;
        $params[':to_date'] = $to_date;
    }
    $sql .= " ORDER BY emp_no";

    $stmt = $pdo->prepare($sql);
    foreach ($params as $key => $val) {
        $stmt->bindValue($key, $val);
    }
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="thong_ke_ghi_chu_' . date('Y-m-d') . '.csv"');
    echo "\xEF\xBB\xBF";
    $output = fopen('php://output', 'w');
    fputcsv($output, ['MSNV', 'Họ tên', 'Bộ phận', 'Ghi chú', 'Ngày tạo']);
    foreach ($rows as $row) {
        fputcsv($output, [
            $row['emp_no'],
            $row['name'],
            $row['bp'],
            $row['note'],
            date('d/m/Y', strtotime($row['created_at']))
        ]);
    }
    fclose($output);
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê ghi chú nhân viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="icon" type="image/jpeg" href="https://cdn-healthcare.hellohealthgroup.com/2022/11/1669708514_6385bae2942755.91630106.jpg">
    <style>
        body { background: #f4f6f9; }
        .card-header { background: linear-gradient(135deg, #2c3e50, #1a2632); color: white; }
        .filter-form { background: #fff; padding: 15px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        .alert-custom { font-size: 0.9rem; padding: 5px 10px; margin-top: 5px; }
    </style>
</head>
<body>
<div class="container-fluid px-4 py-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-journal-text"></i> Thống kê ghi chú nhân viên</h2>
        <div>
            <a href="index.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
            <a href="admin_stats.php" class="btn btn-info"><i class="bi bi-graph-up"></i> Thống kê khám</a>
        </div>
    </div>

    <!-- Form lọc theo ngày -->
    <div class="filter-form">
        <form method="GET" action="" id="filterForm" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Lọc theo</label>
                <select name="filter_type" id="filter_type" class="form-select">
                    <option value="all" <?= ($_GET['filter_type'] ?? 'all') == 'all' ? 'selected' : '' ?>>Tất cả</option>
                    <option value="today" <?= ($_GET['filter_type'] ?? '') == 'today' ? 'selected' : '' ?>>Hôm nay</option>
                    <option value="week" <?= ($_GET['filter_type'] ?? '') == 'week' ? 'selected' : '' ?>>Tuần này</option>
                    <option value="month" <?= ($_GET['filter_type'] ?? '') == 'month' ? 'selected' : '' ?>>Tháng này</option>
                    <option value="range" <?= ($_GET['filter_type'] ?? '') == 'range' ? 'selected' : '' ?>>Khoảng ngày</option>
                </select>
            </div>
            <div class="col-md-3" id="date_range" style="display: none;">
                <label class="form-label">Từ ngày</label>
                <input type="date" name="from_date" class="form-control" value="<?= htmlspecialchars($_GET['from_date'] ?? '') ?>">
            </div>
            <div class="col-md-3" id="date_range_to" style="display: none;">
                <label class="form-label">Đến ngày</label>
                <input type="date" name="to_date" class="form-control" value="<?= htmlspecialchars($_GET['to_date'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary"><i class="bi bi-funnel"></i> Lọc</button>
                <a href="?filter_type=all" class="btn btn-secondary">Xóa lọc</a>
                <button type="button" id="exportExcelBtn" class="btn btn-success"><i class="bi bi-file-excel"></i> Xuất Excel</button>
            </div>
        </form>
        <?php
        if (isset($_GET['filter_type']) && $_GET['filter_type'] == 'range') {
            $from = $_GET['from_date'] ?? '';
            $to = $_GET['to_date'] ?? '';
            if (empty($from) || empty($to)) {
                echo '<div class="alert alert-warning alert-custom mt-2"><i class="bi bi-exclamation-triangle"></i> Bạn chưa chọn đầy đủ ngày bắt đầu và kết thúc. Hiển thị tất cả dữ liệu.</div>';
            }
        }
        ?>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <i class="bi bi-table"></i> Danh sách ghi chú
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="noteTable" class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>MSNV</th>
                            <th>Họ tên</th>
                            <th>Bộ phận</th>
                            <th>Ghi chú</th>
                            <th>Ngày tạo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $filter_type = $_GET['filter_type'] ?? 'all';
                        $from_date = $_GET['from_date'] ?? '';
                        $to_date = $_GET['to_date'] ?? '';

                        // Chỉ lấy các dòng có ghi chú không rỗng
                        $sql = "SELECT emp_no, name, bp, note, created_at FROM employees WHERE note IS NOT NULL AND note != ''";
                        $params = [];

                        if ($filter_type == 'today') {
                            $sql .= " AND DATE(created_at) = CURDATE()";
                        } elseif ($filter_type == 'week') {
                            $sql .= " AND YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)";
                        } elseif ($filter_type == 'month') {
                            $sql .= " AND MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
                        } elseif ($filter_type == 'range' && !empty($from_date) && !empty($to_date)) {
                            $sql .= " AND DATE(created_at) BETWEEN :from_date AND :to_date";
                            $params[':from_date'] = $from_date;
                            $params[':to_date'] = $to_date;
                        }
                        $sql .= " ORDER BY emp_no";

                        $stmt = $pdo->prepare($sql);
                        foreach ($params as $key => $val) {
                            $stmt->bindValue($key, $val);
                        }
                        $stmt->execute();

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['emp_no']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['bp']) . "</td>";
                            echo "<td>" . nl2br(htmlspecialchars($row['note'])) . "</td>";
                            echo "<td>" . date('d/m/Y', strtotime($row['created_at'])) . "</td>";
                            echo "</tr>";
                        }
                        ?>
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
    var viLang = {
        "sProcessing":   "Đang xử lý...",
        "sLengthMenu":   "Hiển thị _MENU_ dòng",
        "sZeroRecords":  "Không tìm thấy ghi chú nào trong khoảng này",
        "sInfo":         "Hiển thị _START_ đến _END_ của _TOTAL_ dòng",
        "sInfoEmpty":    "Hiển thị 0 đến 0 của 0 dòng",
        "sInfoFiltered": "(lọc từ _MAX_ dòng)",
        "sSearch":       "Tìm kiếm:",
        "oPaginate": {
            "sFirst":    "Đầu",
            "sPrevious": "Trước",
            "sNext":     "Tiếp",
            "sLast":     "Cuối"
        }
    };

    $('#noteTable').DataTable({
        language: viLang,
        order: [[0, 'asc']],
        pageLength: 25,
        autoWidth: false
    });

    function toggleDateRange() {
        if ($('#filter_type').val() == 'range') {
            $('#date_range, #date_range_to').show();
        } else {
            $('#date_range, #date_range_to').hide();
        }
    }
    toggleDateRange();
    $('#filter_type').change(toggleDateRange);

    $('#exportExcelBtn').click(function() {
        var filter_type = $('#filter_type').val();
        var from_date = $('input[name="from_date"]').val();
        var to_date = $('input[name="to_date"]').val();
        var url = '?export=excel&filter_type=' + encodeURIComponent(filter_type);
        if (filter_type == 'range') {
            if (!from_date || !to_date) {
                alert('Vui lòng chọn đầy đủ ngày bắt đầu và kết thúc.');
                return;
            }
            url += '&from_date=' + encodeURIComponent(from_date) + '&to_date=' + encodeURIComponent(to_date);
        }
        window.location.href = url;
    });
});
</script>
</body>
</html>