<?php
require_once 'config.php';
header('Content-Type: application/json');

$action = $_REQUEST['action'] ?? '';

if ($action == 'getEmployees') {
    // Server-side cho DataTable
    $draw = intval($_GET['draw']);
    $start = intval($_GET['start']);
    $length = intval($_GET['length']);
    $search = $_GET['search']['value'] ?? '';

    $where = "";
    if (!empty($search)) {
        $where = "WHERE emp_no LIKE :search OR name LIKE :search OR bp LIKE :search";
    }
    $sql = "SELECT * FROM employees $where ORDER BY emp_no LIMIT $start, $length";
    $stmt = $pdo->prepare($sql);
    if (!empty($search)) {
        $searchParam = "%$search%";
        $stmt->bindParam(':search', $searchParam);
    }
    $stmt->execute();
    $data = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $received_badge = $row['is_received'] ? '<span class="badge bg-success">Đã tiếp nhận</span>' : '<span class="badge bg-secondary">Chưa</span>';
    $returned_badge = $row['is_returned'] ? '<span class="badge bg-success">Đã nhận</span>' : '<span class="badge bg-danger">Chưa</span>';
    $actions = '<button class="btn btn-sm btn-primary btn-receive" data-emp="'.$row['emp_no'].'">Tiếp nhận</button> ';
    $actions .= '<button class="btn btn-sm btn-warning btn-print" data-emp="'.$row['emp_no'].'">In chỉ định</button> ';
    $actions .= '<button class="btn btn-sm btn-secondary btn-return" data-emp="'.$row['emp_no'].'">Nhận hồ sơ</button> ';
    $actions .= '<button class="btn btn-sm btn-info btn-note" data-emp="'.$row['emp_no'].'" data-note="'.htmlspecialchars($row['note']).'">Ghi chú</button>';
    $data[] = [
        'emp_no' => $row['emp_no'],
        'name' => $row['name'],
        'bp' => $row['bp'],
        'gender' => $row['gender'],
        'is_received' => (int)$row['is_received'],   // Ép kiểu int
        'is_returned' => (int)$row['is_returned'],   // Ép kiểu int
        'received_badge' => $received_badge,
        'printed_count' => $row['printed_count'],
        'returned_badge' => $returned_badge,
        'note' => htmlspecialchars($row['note']),
        'actions' => $actions
    ];
}
    $total = $pdo->query("SELECT COUNT(*) FROM employees")->fetchColumn();
    echo json_encode(['draw' => $draw, 'recordsTotal' => $total, 'recordsFiltered' => $total, 'data' => $data]);
    exit;
}

if ($action == 'receive') {
    $emp_no = $_POST['emp_no'];
    $now = date('Y-m-d H:i:s');
    $stmt = $pdo->prepare("UPDATE employees SET is_received=1, received_date=? WHERE emp_no=?");
    $success = $stmt->execute([$now, $emp_no]);
    echo json_encode(['success' => $success]);
    exit;
}
if ($action == 'return') {
    $emp_no = $_POST['emp_no'];
    $now = date('Y-m-d H:i:s');
    $stmt = $pdo->prepare("UPDATE employees SET is_returned=1, returned_date=? WHERE emp_no=?");
    $success = $stmt->execute([$now, $emp_no]);
    echo json_encode(['success' => $success]);
    exit;
}
if ($action == 'cancel_receive') {
    $emp_no = $_POST['emp_no'];
    $stmt = $pdo->prepare("UPDATE employees SET is_received = 0 WHERE emp_no = ?");
    $success = $stmt->execute([$emp_no]);
    echo json_encode(['success' => $success]);
    exit;
}
if ($action == 'cancel_return') {
    $emp_no = $_POST['emp_no'];
    $stmt = $pdo->prepare("UPDATE employees SET is_returned = 0 WHERE emp_no = ?");
    $success = $stmt->execute([$emp_no]);
    echo json_encode(['success' => $success]);
    exit;
}
if ($action == 'increasePrint') {
    $emp_no = $_POST['emp_no'];
    $now = date('Y-m-d H:i:s');
    $stmt = $pdo->prepare("UPDATE employees SET printed_count = printed_count + 1, last_print_date = ? WHERE emp_no=?");
    $success = $stmt->execute([$now, $emp_no]);
    echo json_encode(['success' => $success]);
    exit;
}
if ($action == 'updateNote') {
    $emp_no = $_POST['emp_no'];
    $note = $_POST['note'];
    $stmt = $pdo->prepare("UPDATE employees SET note = ? WHERE emp_no = ?");
    $success = $stmt->execute([$note, $emp_no]);
    echo json_encode(['success' => $success]);
    exit;
}
if ($action == 'getStats') {
    $sql = "SELECT COUNT(*) as total, SUM(is_received) as received, SUM(printed_count > 0) as printed, SUM(is_returned) as returned FROM employees";
    $stmt = $pdo->query($sql);
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    exit;
}
if ($action == 'getEmployee') {
    $emp_no = $_GET['emp_no'];
    $stmt = $pdo->prepare("SELECT * FROM employees WHERE emp_no = ?");
    $stmt->execute([$emp_no]);
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    exit;
}
if ($action == 'getMissing') {
    $stmt = $pdo->query("SELECT emp_no, name, is_received, printed_count, is_returned, note FROM employees WHERE is_received=0 OR printed_count=0 OR is_returned=0");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}
if ($action == 'statsByDateRange') {
    $from = $_GET['from'] . ' 00:00:00';
    $to = $_GET['to'] . ' 23:59:59';
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM employees WHERE is_received = 1 AND received_date BETWEEN ? AND ?");
    $stmt->execute([$from, $to]);
    $total = $stmt->fetchColumn();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM employees WHERE is_received = 1 AND is_returned = 1 AND received_date BETWEEN ? AND ?");
    $stmt->execute([$from, $to]);
    $returned = $stmt->fetchColumn();
    $not_returned = $total - $returned;
    $stmt = $pdo->prepare("SELECT DATE(received_date) as date, COUNT(*) as count FROM employees WHERE is_received = 1 AND received_date BETWEEN ? AND ? GROUP BY DATE(received_date) ORDER BY date");
    $stmt->execute([$from, $to]);
    $daily = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'total' => $total, 'returned' => $returned, 'not_returned' => $not_returned, 'daily' => $daily]);
    exit;
}

if ($action == 'employeesByDateRange') {
    $from = $_GET['from'] . ' 00:00:00';
    $to = $_GET['to'] . ' 23:59:59';
    $stmt = $pdo->prepare("SELECT emp_no, name, bp, gender, received_date, is_returned FROM employees WHERE is_received = 1 AND received_date BETWEEN ? AND ? ORDER BY received_date DESC");
    $stmt->execute([$from, $to]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'data' => $data]);
    exit;
}
echo json_encode(['error' => 'Invalid action']);
?>