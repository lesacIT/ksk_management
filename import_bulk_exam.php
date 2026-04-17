<?php
require_once 'config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['csv_file'])) {
    echo json_encode(['error' => 'Không có file upload']);
    exit;
}

$file = $_FILES['csv_file']['tmp_name'];
if (!file_exists($file)) {
    echo json_encode(['error' => 'Lỗi đọc file tạm']);
    exit;
}

$handle = fopen($file, 'r');
if (!$handle) {
    echo json_encode(['error' => 'Không thể mở file']);
    exit;
}

$header = fgetcsv($handle, 0, ',');
if (!$header) {
    echo json_encode(['error' => 'File rỗng hoặc sai định dạng']);
    exit;
}

$empno_col = -1;
foreach ($header as $idx => $col) {
    $col_clean = preg_replace('/[^a-z0-9]/i', '', strtolower($col));
    if ($col_clean == 'empno' || $col_clean == 'emp_no') {
        $empno_col = $idx;
        break;
    }
}
if ($empno_col == -1) {
    echo json_encode(['error' => 'File CSV thiếu cột EmpNo']);
    exit;
}

$updated = 0;
while (($row = fgetcsv($handle, 0, ',')) !== false) {
    $emp_no = trim($row[$empno_col] ?? '');
    if ($emp_no === '') continue;
    $stmt = $pdo->prepare("UPDATE employees SET is_received = 1, received_date = NOW() WHERE emp_no = ? AND is_received = 0");
    $stmt->execute([$emp_no]);
    $updated += $stmt->rowCount();
}
fclose($handle);

echo json_encode(['success' => true, 'updated' => $updated]);
?>