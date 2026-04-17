<?php
require_once 'config.php';

$emp_no = $_GET['emp_no'] ?? '';
$force = isset($_GET['force']) && $_GET['force'] == 1; // nếu muốn tạo lại
if (!$emp_no) die('Thiếu mã nhân viên');

$storageDir = __DIR__ . '/prescriptions';
if (!is_dir($storageDir)) {
    mkdir($storageDir, 0777, true);
}

$filePath = $storageDir . '/' . $emp_no . '.html';

// Nếu file đã tồn tại và không yêu cầu force thì đọc nội dung file cũ
if (file_exists($filePath) && !$force) {
    $html = file_get_contents($filePath);
} else {
    // Nếu chưa có hoặc force, tạo mới
    $stmt = $pdo->prepare("SELECT * FROM employees WHERE emp_no = ?");
    $stmt->execute([$emp_no]);
    $emp = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$emp) die('Không tìm thấy nhân viên');

    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <title>Phiếu chỉ định - <?= htmlspecialchars($emp['emp_no']) ?></title>
        <style>
            @media print { .no-print { display: none; } body { margin: 0; padding: 0; } }
            body { font-family: 'Times New Roman', Arial, sans-serif; margin: 20px; }
            .prescription-card { max-width: 800px; margin: auto; border: 1px solid #000; padding: 20px; border-radius: 10px; background: white; }
            .header { text-align: center; margin-bottom: 20px; }
            .title { font-size: 22px; font-weight: bold; }
            .info-row { margin-bottom: 8px; }
            .danh-muc { margin-top: 20px; }
            .danh-muc ul { list-style-type: square; }
            .signature { margin-top: 40px; display: flex; justify-content: space-between; }
            .footer { text-align: center; margin-top: 30px; font-size: 12px; color: #555; }
        </style>
    </head>
    <body>
    <div class="prescription-card">
        <div class="header">
            <div class="title">PHIẾU CHỈ ĐỊNH KHÁM SỨC KHỎE ĐỊNH KỲ</div>
            <div>(Dành cho nhân viên công ty)</div>
        </div>
        <div class="info-row"><strong>Mã nhân viên:</strong> <?= htmlspecialchars($emp['emp_no']) ?></div>
        <div class="info-row"><strong>Họ và tên:</strong> <?= htmlspecialchars($emp['name']) ?></div>
        <div class="info-row"><strong>Bộ phận:</strong> <?= htmlspecialchars($emp['bp']) ?></div>
        <div class="info-row"><strong>Giới tính:</strong> <?= htmlspecialchars($emp['gender']) ?></div>
        <div class="info-row"><strong>Số CMND/CCCD:</strong> <?= htmlspecialchars($emp['national_id']) ?></div>
        <div class="info-row"><strong>Nơi cư trú:</strong> <?= htmlspecialchars($emp['res_place']) ?></div>
        <hr>
        <div class="danh-muc">
            <strong>Danh mục khám chỉ định:</strong>
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
        </div>
        <div class="signature">
            <div>Ngày .... tháng .... năm 2026<br><strong>Người bệnh</strong><br>(Ký, ghi rõ họ tên)</div>
            <div><strong>Bác sĩ chỉ định</strong><br>(Ký, đóng dấu)</div>
        </div>
        <div class="footer">(Phiếu này được lưu tại kho lưu trữ của công ty)</div>
    </div>
    <div class="no-print text-center" style="margin-top: 20px;">
        <button class="btn btn-primary" onclick="window.print();">🖨️ In phiếu</button>
        <button class="btn btn-secondary" onclick="window.close();">❌ Đóng</button>
    </div>
    </body>
    </html>
    <?php
    $html = ob_get_clean();
    file_put_contents($filePath, $html);
}

// Hiển thị nội dung HTML (có thể là file cũ hoặc mới)
echo $html;
?>