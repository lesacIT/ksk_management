<?php
require_once 'config.php';
require_once 'SimpleXLSX.php'; // dùng thư viện nhẹ

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excel_file'])) {
    $file = $_FILES['excel_file']['tmp_name'];
    if ($xlsx = SimpleXLSX::parse($file)) {
        $rows = $xlsx->rows();
        $header = array_shift($rows); // dòng tiêu đề

        // Map cột theo tên tiếng Việt trong file mẫu của bạn
        $colMap = [];
        foreach ($header as $idx => $colName) {
            $col = trim($colName);
            if (strpos($col, 'EmpNo') !== false) $colMap['emp_no'] = $idx;
            if (strpos($col, 'Name') !== false) $colMap['name'] = $idx;
            if (strpos($col, 'Factory Location') !== false) $colMap['factory_location'] = $idx;
            if (strpos($col, 'BP') !== false) $colMap['bp'] = $idx;
            if (strpos($col, 'Dept') !== false) $colMap['dept'] = $idx;
            if (strpos($col, 'Gender') !== false) $colMap['gender'] = $idx;
            if (strpos($col, 'National ID') !== false) $colMap['national_id'] = $idx;
            if (strpos($col, 'Res Place') !== false) $colMap['res_place'] = $idx;
            if (strpos($col, 'Position') !== false) $colMap['position'] = $idx;
            if (strpos($col, 'Emp Class') !== false) $colMap['emp_class'] = $idx;
            if (strpos($col, 'Hire Type') !== false) $colMap['hire_type'] = $idx;
            if (strpos($col, 'Emp Status') !== false) $colMap['emp_status'] = $idx;
            if (strpos($col, 'Hire Date') !== false) $colMap['hire_date'] = $idx;
            if (strpos($col, 'Promotion Date') !== false) $colMap['promotion_date'] = $idx;
            if (strpos($col, 'Re-check') !== false && strpos($col, '1.2025') !== false) $colMap['re_check1'] = $idx;
            if (strpos($col, 'Re-check') !== false && strpos($col, '2.2025') !== false) $colMap['re_check2'] = $idx;
            if (strpos($col, 'Remark') !== false) $colMap['remark_original'] = $idx;
        }

        $count = 0;
        foreach ($rows as $row) {
            if (empty($row[$colMap['emp_no']])) continue;
            $data = [
                'emp_no' => $row[$colMap['emp_no']],
                'name' => $row[$colMap['name']] ?? '',
                'factory_location' => $row[$colMap['factory_location']] ?? null,
                'bp' => $row[$colMap['bp']] ?? null,
                'dept' => $row[$colMap['dept']] ?? null,
                'gender' => $row[$colMap['gender']] ?? null,
                'national_id' => $row[$colMap['national_id']] ?? null,
                'res_place' => $row[$colMap['res_place']] ?? null,
                'position' => $row[$colMap['position']] ?? null,
                'emp_class' => $row[$colMap['emp_class']] ?? null,
                'hire_type' => $row[$colMap['hire_type']] ?? null,
                'emp_status' => $row[$colMap['emp_status']] ?? null,
                'hire_date' => !empty($row[$colMap['hire_date']]) ? date('Y-m-d', strtotime($row[$colMap['hire_date']])) : null,
                'promotion_date' => !empty($row[$colMap['promotion_date']]) ? date('Y-m-d', strtotime($row[$colMap['promotion_date']])) : null,
                're_check1' => $row[$colMap['re_check1']] ?? null,
                're_check2' => $row[$colMap['re_check2']] ?? null,
                'remark_original' => $row[$colMap['remark_original']] ?? null,
            ];
            $sql = "INSERT INTO employees SET 
                        emp_no = :emp_no, name = :name, factory_location = :factory_location, bp = :bp, dept = :dept,
                        gender = :gender, national_id = :national_id, res_place = :res_place, position = :position,
                        emp_class = :emp_class, hire_type = :hire_type, emp_status = :emp_status,
                        hire_date = :hire_date, promotion_date = :promotion_date, re_check1 = :re_check1,
                        re_check2 = :re_check2, remark_original = :remark_original
                    ON DUPLICATE KEY UPDATE
                        name = VALUES(name), factory_location = VALUES(factory_location), bp = VALUES(bp),
                        dept = VALUES(dept), gender = VALUES(gender), national_id = VALUES(national_id),
                        res_place = VALUES(res_place), position = VALUES(position), emp_class = VALUES(emp_class),
                        hire_type = VALUES(hire_type), emp_status = VALUES(emp_status), hire_date = VALUES(hire_date),
                        promotion_date = VALUES(promotion_date), re_check1 = VALUES(re_check1), re_check2 = VALUES(re_check2),
                        remark_original = VALUES(remark_original)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
            $count++;
        }
        echo "Import thành công $count nhân viên.";
    } else {
        echo "Lỗi đọc file Excel: " . SimpleXLSX::parseError();
    }
} else {
    http_response_code(400);
    echo "Yêu cầu không hợp lệ";
}
?>