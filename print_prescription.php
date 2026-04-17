<?php
require_once 'config.php';

$emp_no = $_GET['emp_no'] ?? '';
if (!$emp_no) die('Thiếu mã nhân viên');

$storageDir = __DIR__ . '/prescriptions';

// Kiểm tra file PDF trước
$pdfPath = $storageDir . '/' . $emp_no . '.pdf';
if (file_exists($pdfPath)) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="' . $emp_no . '.pdf"');
    readfile($pdfPath);
    exit;
}

// Kiểm tra file HTML
$htmlPath = $storageDir . '/' . $emp_no . '.html';
if (file_exists($htmlPath)) {
    $html = file_get_contents($htmlPath);
    $html = str_replace('</body>', 
        '<script>window.onload = function() { window.print(); };</script></body>', $html);
    echo $html;
    exit;
}

// Không tìm thấy file nào -> hiển thị thông báo đẹp
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Không tìm thấy phiếu chỉ định</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .error-card { border-radius: 20px; overflow: hidden; box-shadow: 0 20px 35px rgba(0,0,0,0.2); animation: fadeIn 0.5s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        .btn-close-custom { background: #6c5ce7; border: none; padding: 10px 25px; border-radius: 30px; color: white; font-weight: 600; transition: 0.3s; }
        .btn-close-custom:hover { background: #5a4ac7; transform: scale(1.02); }
    </style>
</head>
<body>
<div class="container">
    <div class="card error-card border-0">
        <div class="card-header bg-danger text-white text-center py-3">
            <i class="bi bi-file-earmark-x fs-1"></i>
            <h3 class="mb-0">Không tìm thấy phiếu chỉ định</h3>
        </div>
        <div class="card-body text-center p-4">
            <div class="mb-3">
                <i class="bi bi-person-square fs-1 text-secondary"></i>
                <h5 class="mt-2">Mã nhân viên: <strong class="text-danger"><?= htmlspecialchars($emp_no) ?></strong></h5>
            </div>
            <div class="alert alert-warning">
                <i class="bi bi-info-circle"></i> Hiện chưa có phiếu chỉ định nào được lưu cho nhân viên này.
            </div>
            <p>Vui lòng liên hệ quản trị viên để tạo phiếu trước khi in.</p>
            <button class="btn-close-custom" onclick="window.close();">
                <i class="bi bi-x-circle"></i> Đóng cửa sổ
            </button>
        </div>
    </div>
</div>
</body>
</html>