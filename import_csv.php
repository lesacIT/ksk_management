<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
    $file = $_FILES['csv_file']['tmp_name'];
    if (($handle = fopen($file, 'r')) !== false) {
        // Đọc dòng tiêu đề
        $header = fgetcsv($handle, 0, ',');
        if (!$header) {
            echo "File CSV không có dữ liệu hoặc sai định dạng.";
            exit;
        }

        // Tìm vị trí các cột dựa trên tên tiêu đề (không phân biệt hoa thường, loại bỏ khoảng trắng)
        $colMap = [];
        $expected = ['empno', 'name', 'bp', 'gender', 'factorylocation', 'dept', 'nationalid', 'resplace', 'position', 'empclass', 'hiretype', 'empstatus', 'hiredate', 'promotiondate', 'recheck1', 'recheck2', 'remarkoriginal'];
        foreach ($header as $idx => $colName) {
            $clean = preg_replace('/[^a-z0-9]/i', '', strtolower($colName));
            if ($clean == 'empno' || $clean == 'emp_no') $colMap['emp_no'] = $idx;
            if ($clean == 'name') $colMap['name'] = $idx;
            if ($clean == 'bp') $colMap['bp'] = $idx;
            if ($clean == 'gender') $colMap['gender'] = $idx;
            if ($clean == 'factorylocation') $colMap['factory_location'] = $idx;
            if ($clean == 'dept') $colMap['dept'] = $idx;
            if ($clean == 'nationalid') $colMap['national_id'] = $idx;
            if ($clean == 'resplace') $colMap['res_place'] = $idx;
            if ($clean == 'position') $colMap['position'] = $idx;
            if ($clean == 'empclass') $colMap['emp_class'] = $idx;
            if ($clean == 'hiretype') $colMap['hire_type'] = $idx;
            if ($clean == 'empstatus') $colMap['emp_status'] = $idx;
            if ($clean == 'hiredate') $colMap['hire_date'] = $idx;
            if ($clean == 'promotiondate') $colMap['promotion_date'] = $idx;
            if ($clean == 'recheck1') $colMap['re_check1'] = $idx;
            if ($clean == 'recheck2') $colMap['re_check2'] = $idx;
            if ($clean == 'remarkoriginal') $colMap['remark_original'] = $idx;
        }

        // Kiểm tra có ít nhất các cột bắt buộc
        if (!isset($colMap['emp_no']) || !isset($colMap['name'])) {
            echo "File CSV thiếu cột bắt buộc: EmpNo hoặc Name.";
            exit;
        }

        $count = 0;
        $errors = [];
        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            // Bỏ qua dòng rỗng
            if (empty($row[$colMap['emp_no']])) continue;

            $emp_no = trim($row[$colMap['emp_no']]);
            $name = trim($row[$colMap['name']] ?? '');
            $bp = isset($colMap['bp']) ? trim($row[$colMap['bp']] ?? '') : null;
            $gender = isset($colMap['gender']) ? trim($row[$colMap['gender']] ?? '') : null;
            $factory_location = isset($colMap['factory_location']) ? trim($row[$colMap['factory_location']] ?? '') : null;
            $dept = isset($colMap['dept']) ? trim($row[$colMap['dept']] ?? '') : null;
            $national_id = isset($colMap['national_id']) ? trim($row[$colMap['national_id']] ?? '') : null;
            $res_place = isset($colMap['res_place']) ? trim($row[$colMap['res_place']] ?? '') : null;
            $position = isset($colMap['position']) ? trim($row[$colMap['position']] ?? '') : null;
            $emp_class = isset($colMap['emp_class']) ? trim($row[$colMap['emp_class']] ?? '') : null;
            $hire_type = isset($colMap['hire_type']) ? trim($row[$colMap['hire_type']] ?? '') : null;
            $emp_status = isset($colMap['emp_status']) ? trim($row[$colMap['emp_status']] ?? '') : null;
            
            // Xử lý ngày tháng
            $hire_date = null;
            if (isset($colMap['hire_date']) && !empty($row[$colMap['hire_date']])) {
                $hire_date = date('Y-m-d', strtotime($row[$colMap['hire_date']]));
            }
            $promotion_date = null;
            if (isset($colMap['promotion_date']) && !empty($row[$colMap['promotion_date']])) {
                $promotion_date = date('Y-m-d', strtotime($row[$colMap['promotion_date']]));
            }
            $re_check1 = isset($colMap['re_check1']) ? trim($row[$colMap['re_check1']] ?? '') : null;
            $re_check2 = isset($colMap['re_check2']) ? trim($row[$colMap['re_check2']] ?? '') : null;
            $remark_original = isset($colMap['remark_original']) ? trim($row[$colMap['remark_original']] ?? '') : null;

            // Câu lệnh INSERT với ON DUPLICATE KEY UPDATE
            $sql = "INSERT INTO employees SET 
                        emp_no = :emp_no,
                        name = :name,
                        factory_location = :factory_location,
                        bp = :bp,
                        dept = :dept,
                        gender = :gender,
                        national_id = :national_id,
                        res_place = :res_place,
                        position = :position,
                        emp_class = :emp_class,
                        hire_type = :hire_type,
                        emp_status = :emp_status,
                        hire_date = :hire_date,
                        promotion_date = :promotion_date,
                        re_check1 = :re_check1,
                        re_check2 = :re_check2,
                        remark_original = :remark_original
                    ON DUPLICATE KEY UPDATE
                        name = VALUES(name),
                        factory_location = VALUES(factory_location),
                        bp = VALUES(bp),
                        dept = VALUES(dept),
                        gender = VALUES(gender),
                        national_id = VALUES(national_id),
                        res_place = VALUES(res_place),
                        position = VALUES(position),
                        emp_class = VALUES(emp_class),
                        hire_type = VALUES(hire_type),
                        emp_status = VALUES(emp_status),
                        hire_date = VALUES(hire_date),
                        promotion_date = VALUES(promotion_date),
                        re_check1 = VALUES(re_check1),
                        re_check2 = VALUES(re_check2),
                        remark_original = VALUES(remark_original)";
            
            $stmt = $pdo->prepare($sql);
            try {
                $stmt->execute([
                    ':emp_no' => $emp_no,
                    ':name' => $name,
                    ':factory_location' => $factory_location,
                    ':bp' => $bp,
                    ':dept' => $dept,
                    ':gender' => $gender,
                    ':national_id' => $national_id,
                    ':res_place' => $res_place,
                    ':position' => $position,
                    ':emp_class' => $emp_class,
                    ':hire_type' => $hire_type,
                    ':emp_status' => $emp_status,
                    ':hire_date' => $hire_date,
                    ':promotion_date' => $promotion_date,
                    ':re_check1' => $re_check1,
                    ':re_check2' => $re_check2,
                    ':remark_original' => $remark_original
                ]);
                $count++;
            } catch (PDOException $e) {
                $errors[] = "Lỗi với mã NV $emp_no: " . $e->getMessage();
            }
        }
        fclose($handle);

        if (count($errors) > 0) {
            echo "Import thành công $count nhân viên, nhưng có lỗi:<br>" . implode('<br>', $errors);
        } else {
            echo "Import thành công $count nhân viên từ CSV.";
        }
    } else {
        echo "Không thể mở file CSV.";
    }
} else {
    http_response_code(400);
    echo "Yêu cầu không hợp lệ. Hãy upload file CSV.";
}
?>