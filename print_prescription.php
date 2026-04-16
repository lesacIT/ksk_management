<?php
require_once 'config.php';
$emp_no = $_GET['emp_no'] ?? '';
if (!$emp_no) die('Thiếu mã nhân viên');
$stmt = $pdo->prepare("SELECT * FROM employees WHERE emp_no = ?");
$stmt->execute([$emp_no]);
$emp = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$emp) die('Không tìm thấy nhân viên');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Phiếu chỉ định khám sức khỏe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print { .no-print { display: none; } body { margin: 0; padding: 0; } }
        .prescription-card { border: 1px solid #000; padding: 20px; margin: 10px; border-radius: 10px; background: white; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 22px; font-weight: bold; }
        .info-row { margin-bottom: 10px; }
    </style>
</head>
<body>
<div class="container mt-3">
    <div class="prescription-card">
        <div class="header">
            <div class="title">PHIẾU CHỈ ĐỊNH KHÁM SỨC KHỎE ĐỊNH KỲ</div>
            <div>(Dành cho nhân viên công ty)</div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Mã nhân viên:</strong> <?= htmlspecialchars($emp['emp_no']) ?></p>
                <p><strong>Họ và tên:</strong> <?= htmlspecialchars($emp['name']) ?></p>
                <p><strong>Bộ phận:</strong> <?= htmlspecialchars($emp['bp']) ?></p>
                <p><strong>Giới tính:</strong> <?= htmlspecialchars($emp['gender']) ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Ngày sinh:</strong> ___________________</p>
                <p><strong>Số CMND/CCCD:</strong> <?= htmlspecialchars($emp['national_id']) ?></p>
                <p><strong>Nơi cư trú:</strong> <?= htmlspecialchars($emp['res_place']) ?></p>
            </div>
        </div>
        <hr>
        <h5>Danh mục khám chỉ định:</h5>
        <ul>
            <li>Khám lâm sàng tổng quát</li>
            <li>Xét nghiệm máu (công thức máu, đường huyết, mỡ máu)</li>
            <li>Xét nghiệm nước tiểu</li>
            <li>Siêu âm ổ bụng</li>
            <li>Điện tim</li>
            <li>Đo thị lực, đo nhãn áp</li>
            <li>Khám chuyên khoa: Tai - Mũi - Họng, Răng - Hàm - Mặt</li>
        </ul>
        <p><em>(Danh mục chỉ định có thể thay đổi theo yêu cầu chuyên môn của bác sĩ)</em></p>
        <div class="row mt-4">
            <div class="col-md-6">
                <p>Ngày .... tháng .... năm 2026<br><strong>Người bệnh</strong><br>(Ký, ghi rõ họ tên)</p>
            </div>
            <div class="col-md-6 text-end">
                <p><strong>Bác sĩ chỉ định</strong><br>(Ký, đóng dấu)</p>
            </div>
        </div>
    </div>
    <div class="text-center no-print mt-3">
        <button class="btn btn-primary" onclick="window.print();">In phiếu</button>
        <button class="btn btn-secondary" onclick="window.close();">Đóng</button>
    </div>
</div>
</body>
</html>