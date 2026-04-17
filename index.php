<?php
require_once 'config.php';
// Lấy thống kê ban đầu
$stats = [];
$sql = "SELECT 
            COUNT(*) as total,
            SUM(is_received) as received,
            SUM(printed_count > 0) as printed,
            SUM(is_returned) as returned
        FROM employees";
$stmt = $pdo->query($sql);
$stats = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý khám sức khỏe - KSKDV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card-header { background: linear-gradient(135deg, #2c3e50, #1a2632); color: white; font-weight: bold; }
        .stat-card { transition: 0.3s; border-radius: 1rem; }
        .stat-card:hover { transform: translateY(-5px); }
        .btn-action { margin: 2px; }
        .table-responsive { font-size: 0.9rem; }
        .badge-status { font-size: 0.8rem; }
        .search-box { border-radius: 2rem; padding: 0.5rem 1rem; }
        footer { text-align: center; margin-top: 2rem; padding: 1rem; color: #6c757d; }
    </style>
</head>
<body>

<div class="container-fluid px-4 py-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-dark"><i class="bi bi-clipboard2-pulse"></i> Quản lý khám sức khỏe định kỳ</h2>
        <div>
            <a href="admin_stats.php" class="btn btn-info"><i class="bi bi-graph-up"></i> Thống kê</a>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal"><i class="bi bi-upload"></i> Import CSV</button>
            <button class="btn btn-secondary" onclick="location.reload();"><i class="bi bi-arrow-repeat"></i> Tải lại</button>
        </div>
    </div>

    <!-- Thống kê nhanh -->
    <div class="row mb-4 g-3">
        <div class="col-md-3">
            <div class="card stat-card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="text-muted">Tổng NV đăng ký</h5>
                    <h2 class="text-primary"><?= $stats['total'] ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="text-muted">Đã tiếp nhận</h5>
                    <h2 class="text-success"><?= $stats['received'] ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="text-muted">Đã in chỉ định</h5>
                    <h2 class="text-warning"><?= $stats['printed'] ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="text-muted">Đã nhận hồ sơ</h5>
                    <h2 class="text-danger"><?= $stats['returned'] ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Tìm kiếm nhanh theo MSNV -->
    <div class="card shadow-sm mb-4">
        <div class="card-header"><i class="bi bi-search"></i> Tra cứu nhân viên theo MSNV</div>
        <div class="card-body">
            <div class="input-group">
                <input type="text" id="quickSearch" class="form-control search-box" placeholder="Nhập MSNV (EmpNo) hoặc quét thẻ...">
                <button class="btn btn-primary" id="btnQuickSearch"><i class="bi bi-person-badge"></i> Lấy thông tin</button>
            </div>
            <div id="quickResult" class="mt-3"></div>
        </div>
    </div>

    <!-- Bảng danh sách nhân viên -->
    <div class="card shadow-sm">
        <div class="card-header"><i class="bi bi-table"></i> Danh sách nhân viên đã đăng ký</div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="employeeTable" class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Mã NV</th><th>Họ tên</th><th>Bộ phận (BP)</th><th>Giới tính</th>
                            <th>Tiếp nhận</th><th>Số lần in</th><th>Nhận HS</th><th>Ghi chú</th><th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTable sẽ load AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal báo cáo chi tiết "ai còn thiếu" -->
    <div class="modal fade" id="missingModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle"></i> Danh sách chưa hoàn thành</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="missingContent"></div>
            </div>
        </div>
    </div>

    <!-- Modal Import CSV -->
    <div class="modal fade" id="importModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="bi bi-upload"></i> Import danh sách nhân viên từ CSV</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="importForm" enctype="multipart/form-data" action="import_csv.php" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Chọn file CSV (UTF-8, dấu phẩy)</label>
                            <input type="file" name="csv_file" class="form-control" accept=".csv" required>
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> Yêu cầu đúng định dạng cột: EmpNo, Name, BP, Gender, ... 
                                <a href="sample_import.csv" download class="ms-2"><i class="bi bi-download"></i> Tải file mẫu CSV</a>
                            </div>
                        </div>
                        <div id="importMsg"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Import</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal sửa ghi chú -->
    <div class="modal fade" id="noteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cập nhật ghi chú</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="noteEmpNo">
                    <textarea id="noteText" rows="3" class="form-control" placeholder="Nhập ghi chú..."></textarea>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="saveNoteBtn">Lưu</button>
                </div>
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
    // Khởi tạo DataTable
    var table = $('#employeeTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'api.php?action=getEmployees',
            type: 'GET',
            dataSrc: 'data'
        },
        columns: [
            { data: 'emp_no' },
            { data: 'name' },
            { data: 'bp' },
            { data: 'gender' },
            { data: 'received_badge' },
            { data: 'printed_count' },
            { data: 'returned_badge' },
            { data: 'note' },
            { data: 'actions', orderable: false }
        ],
        order: [[0, 'asc']],
        language: { url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json" }
    });

    // Hàm cập nhật trạng thái không reload bảng
    function updateStatus(emp_no, action, callback) {
        $.post('api.php', { action: action, emp_no: emp_no }, function(res) {
            if (res.success) {
                if (callback) callback();
                // Tìm dòng hiện tại trong DataTable
                var $btn = $('button[data-emp="'+emp_no+'"]').first();
                var $row = $btn.closest('tr');
                var rowData = table.row($row).data();
                if (rowData) {
                    if (action === 'receive') {
                        rowData.received_badge = '<span class="badge bg-success">Đã tiếp nhận</span>';
                    } else if (action === 'return') {
                        rowData.returned_badge = '<span class="badge bg-success">Đã nhận</span>';
                    }
                    table.row($row).data(rowData).draw(false);
                }
                // Cập nhật thống kê nhanh
                $.get('api.php?action=getStats', function(stats) {
                    $('.stat-card').eq(0).find('h2').text(stats.total);
                    $('.stat-card').eq(1).find('h2').text(stats.received);
                    $('.stat-card').eq(2).find('h2').text(stats.printed);
                    $('.stat-card').eq(3).find('h2').text(stats.returned);
                }, 'json');
            } else {
                alert('Lỗi: ' + (res.message || 'Không xác định'));
            }
        }, 'json');
    }

    // Sự kiện các nút trên bảng
    $('#employeeTable').on('click', '.btn-receive', function() {
        let emp = $(this).data('emp');
        updateStatus(emp, 'receive');
    });
    $('#employeeTable').on('click', '.btn-return', function() {
        let emp = $(this).data('emp');
        updateStatus(emp, 'return');
    });
    $('#employeeTable').on('click', '.btn-print', function() {
        let emp = $(this).data('emp');
        $.post('api.php', { action: 'increasePrint', emp_no: emp }, function(res) {
            if (res.success) {
                // Cập nhật số lần in trên dòng
                var $btn = $('button[data-emp="'+emp+'"]').first();
                var $row = $btn.closest('tr');
                var rowData = table.row($row).data();
                if (rowData) {
                    rowData.printed_count = (parseInt(rowData.printed_count) || 0) + 1;
                    table.row($row).data(rowData).draw(false);
                }
                window.open('print_prescription.php?emp_no=' + emp, '_blank');
            } else {
                alert(res.message);
            }
        }, 'json');
    });
    $('#employeeTable').on('click', '.btn-note', function() {
        let emp = $(this).data('emp');
        let currentNote = $(this).data('note') || '';
        $('#noteEmpNo').val(emp);
        $('#noteText').val(currentNote);
        $('#noteModal').modal('show');
    });

    $('#saveNoteBtn').click(function() {
        let emp = $('#noteEmpNo').val();
        let note = $('#noteText').val();
        $.post('api.php', { action: 'updateNote', emp_no: emp, note: note }, function(res) {
            if (res.success) {
                $('#noteModal').modal('hide');
                var $btn = $('button[data-emp="'+emp+'"]').first();
                var $row = $btn.closest('tr');
                var rowData = table.row($row).data();
                if (rowData) {
                    rowData.note = note;
                    table.row($row).data(rowData).draw(false);
                }
            } else {
                alert('Lỗi cập nhật ghi chú');
            }
        }, 'json');
    });

    // Tìm kiếm nhanh
    $('#btnQuickSearch').click(function() {
        let emp_no = $('#quickSearch').val().trim();
        if(!emp_no) return;
        $.get('api.php?action=getEmployee&emp_no='+emp_no, function(data) {
            if(data && data.emp_no) {
                let html = `<div class="alert alert-info">
                    <strong>${data.name}</strong> (${data.emp_no}) - BP: ${data.bp}<br>
                    Tiếp nhận: ${data.is_received ? 'Đã' : 'Chưa'} | In: ${data.printed_count} lần | Nhận hồ sơ: ${data.is_returned ? 'Đã' : 'Chưa'}<br>
                    Ghi chú: ${data.note || '--'}<br>
                    <button class="btn btn-sm btn-primary mt-2" onclick="quickReceive('${data.emp_no}')">Tiếp nhận</button>
                    <button class="btn btn-sm btn-warning mt-2" onclick="quickPrint('${data.emp_no}')">In chỉ định</button>
                    <button class="btn btn-sm btn-secondary mt-2" onclick="quickReturn('${data.emp_no}')">Nhận hồ sơ</button>
                </div>`;
                $('#quickResult').html(html);
            } else {
                $('#quickResult').html('<div class="alert alert-danger">Không tìm thấy nhân viên</div>');
            }
        }, 'json');
    });

    window.quickReceive = (emp) => updateStatus(emp, 'receive', () => $('#quickResult').empty());
    window.quickPrint = (emp) => {
        $.post('api.php', { action: 'increasePrint', emp_no: emp }, function(res) {
            if(res.success) window.open('print_prescription.php?emp_no='+emp, '_blank');
        }, 'json');
    };
    window.quickReturn = (emp) => updateStatus(emp, 'return', () => $('#quickResult').empty());

    // Import form
    $('#importForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: 'import_csv.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                $('#importMsg').html('<div class="alert alert-success">'+res+'</div>');
                setTimeout(() => location.reload(), 1500);
            },
            error: function(xhr) {
                $('#importMsg').html('<div class="alert alert-danger">Lỗi: '+xhr.responseText+'</div>');
            }
        });
    });

    // Modal báo cáo thiếu
    $('#missingModal').on('show.bs.modal', function() {
        $.get('api.php?action=getMissing', function(data) {
            let html = '<table class="table table-sm"><thead><tr><th>MSNV</th><th>Họ tên</th><th>Thiếu</th><th>Ghi chú</th></tr></thead><tbody>';
            data.forEach(row => {
                let missing = [];
                if(!row.is_received) missing.push('Chưa tiếp nhận');
                if(row.printed_count == 0) missing.push('Chưa in chỉ định');
                if(!row.is_returned) missing.push('Chưa nhận hồ sơ');
                html += `<tr><td>${row.emp_no}</td><td>${row.name}</td><td>${missing.join(', ')}</td><td>${row.note || ''}</td></tr>`;
            });
            html += '</tbody></table>';
            $('#missingContent').html(html || 'Không có ai thiếu');
        }, 'json');
    });
});
</script>
<footer>Hệ thống quản lý khám sức khỏe - Hỗ trợ in chỉ định, tiếp nhận, trả hồ sơ</footer>
</body>
</html>