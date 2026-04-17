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

// Nếu không có PDF, kiểm tra file HTML
$htmlPath = $storageDir . '/' . $emp_no . '.html';
if (file_exists($htmlPath)) {
    $html = file_get_contents($htmlPath);
    // Thêm script tự động in
    $html = str_replace('</body>', 
        '<script>
            window.onload = function() { window.print(); };
        </script></body>', $html);
    echo $html;
    exit;
}

// Không tìm thấy file nào
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Không tìm thấy phiếu chỉ định</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .error-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 550px;
            width: 100%;
            text-align: center;
            animation: fadeInUp 0.6s ease-out;
        }
        .error-header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            padding: 30px 20px;
            color: white;
        }
        .error-header i {
            font-size: 72px;
            margin-bottom: 15px;
            display: inline-block;
            animation: shake 0.5s ease-in-out;
        }
        .error-header h3 {
            font-weight: 700;
            margin: 0;
            font-size: 28px;
        }
        .error-body {
            padding: 40px 30px 30px;
        }
        .emp-code {
            background: #f8f9fc;
            padding: 12px;
            border-radius: 50px;
            font-family: monospace;
            font-size: 22px;
            font-weight: bold;
            color: #e74a3b;
            letter-spacing: 1px;
            display: inline-block;
            margin: 15px 0;
            border: 1px dashed #e74a3b;
        }
        .message-text {
            color: #5a5c69;
            font-size: 16px;
            margin-bottom: 25px;
            line-height: 1.6;
        }
        .btn-close-window {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            padding: 12px 32px;
            border-radius: 50px;
            font-weight: 600;
            color: white;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-close-window:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            color: white;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-8px); }
            75% { transform: translateX(8px); }
        }
        .footer-note {
            margin-top: 20px;
            font-size: 12px;
            color: #b7b9cc;
        }
    </style>
</head>
<body>
<div class="error-card">
    <div class="error-header">
        <i class="bi bi-file-earmark-x-fill"></i>
        <h3>Không tìm thấy phiếu chỉ định</h3>
    </div>
    <div class="error-body">
        <div class="emp-code">
            <i class="bi bi-upc-scan"></i> <?= htmlspecialchars($emp_no) ?>
        </div>
        <div class="message-text">
            <i class="bi bi-info-circle-fill text-warning"></i> Hiện chưa có phiếu chỉ định nào được lưu cho nhân viên này.<br>
            Vui lòng liên hệ quản trị viên để được hỗ trợ.
        </div>
        <button class="btn btn-close-window" onclick="window.close();">
            <i class="bi bi-x-circle"></i> Đóng cửa sổ
        </button>
        <div class="footer-note">
            <i class="bi bi-printer"></i> Hệ thống quản lý phiếu chỉ định
        </div>
    </div>
</div>
</body>
</html>
<?php
exit;
?>