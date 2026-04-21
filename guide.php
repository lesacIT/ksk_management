<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hướng dẫn sử dụng - Hệ thống quản lý khám sức khỏe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/jpeg" href="https://cdn-healthcare.hellohealthgroup.com/2022/11/1669708514_6385bae2942755.91630106.jpg">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="icon" type="image/jpeg" href="https://cdn-healthcare.hellohealthgroup.com/2022/11/1669708514_6385bae2942755.91630106.jpg">
    <style>
        body { background: #f0f7ff; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .header { background: linear-gradient(135deg, #0b5ed7, #0a58ca); color: white; padding: 2rem 0; margin-bottom: 2rem; }
        .step-card { border-left: 5px solid #0d6efd; transition: 0.3s; background: white; border-radius: 1rem; margin-bottom: 1.5rem; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .step-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
        .step-number { font-size: 2.5rem; font-weight: bold; color: #0d6efd; opacity: 0.3; position: absolute; right: 20px; top: 10px; }
        .faq-item { background: #f8f9fa; border-radius: 1rem; padding: 1rem; margin-bottom: 1rem; }
        .footer { background: #e9ecef; padding: 1.5rem; text-align: center; margin-top: 3rem; }
        .btn-home { background: #0d6efd; color: white; border-radius: 2rem; padding: 0.5rem 1.5rem; }
        .btn-home:hover { background: #0b5ed7; color: white; }
    </style>
</head>
<body>

<!-- Header -->
<div class="header text-center">
    <div class="container">
        <i class="bi bi-clipboard2-pulse fs-1"></i>
        <h1 class="display-5 fw-bold">Hướng dẫn sử dụng</h1>
        <p class="lead">Hệ thống quản lý khám sức khỏe định kỳ – Dành cho nhân viên y tế</p>
        <a href="index.php" class="btn btn-light btn-home mt-2"><i class="bi bi-house-door"></i> Vào trang chủ</a>
    </div>
</div>

<div class="container mb-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold"><i class="bi bi-calendar-check"></i> Quy trình làm việc hàng ngày</h2>
        <p class="text-muted">Thực hiện lần lượt các bước sau cho mỗi nhân viên đến khám</p>
    </div>

    <!-- Bước 1: Tiếp nhận -->
    <div class="step-card position-relative p-4">
        <div class="step-number">01</div>
        <div class="row align-items-center">
            <div class="col-md-2 text-center">
                <i class="bi bi-person-badge fs-1 text-primary"></i>
            </div>
            <div class="col-md-10">
                <h4><i class="bi bi-check-circle-fill text-success"></i> Tiếp nhận nhân viên</h4>
                <p><strong>Thao tác:</strong> Nhập mã nhân viên (MSNV) vào ô <strong>"Tra cứu nhanh MSNV"</strong> → bấm <strong>"Lấy thông tin"</strong> → trong khung kết quả, bấm nút <strong class="text-primary">"Tiếp nhận"</strong>.</p>
                <p class="text-muted small"><i class="bi bi-info-circle"></i> Hoặc tìm dòng nhân viên trong bảng và bấm nút <span class="badge bg-primary">Tiếp nhận</span>. Trạng thái sẽ chuyển thành "Đã tiếp nhận".</p>
            </div>
        </div>
    </div>

    <!-- Bước 2: In chỉ định -->
    <div class="step-card position-relative p-4">
        <div class="step-number">02</div>
        <div class="row align-items-center">
            <div class="col-md-2 text-center">
                <i class="bi bi-printer fs-1 text-warning"></i>
            </div>
            <div class="col-md-10">
                <h4><i class="bi bi-printer-fill text-warning"></i> In chỉ định khám</h4>
                <p><strong>Thao tác:</strong> Tại dòng nhân viên (hoặc trong kết quả tra cứu), bấm nút <strong class="text-warning">"In chỉ định"</strong>.</p>
                <p><strong>Kết quả:</strong> Một cửa sổ mới hiện ra, tự động mở hộp thoại in. Chọn máy in, số bản → bấm <strong>In</strong>.</p>
                <p class="text-muted small"><i class="bi bi-exclamation-triangle"></i> Nếu thông báo <strong>"Không tìm thấy phiếu chỉ định"</strong>, hãy báo quản trị viên để tạo file phiếu cho nhân viên đó.</p>
            </div>
        </div>
    </div>

    <!-- Bước 3: Nhận hồ sơ -->
    <div class="step-card position-relative p-4">
        <div class="step-number">03</div>
        <div class="row align-items-center">
            <div class="col-md-2 text-center">
                <i class="bi bi-folder-symlink fs-1 text-success"></i>
            </div>
            <div class="col-md-10">
                <h4><i class="bi bi-archive-fill text-success"></i> Nhận lại hồ sơ sau khám</h4>
                <p><strong>Thao tác:</strong> Khi nhân viên đã khám xong và nộp lại hồ sơ, bấm nút <strong class="text-success">"Nhận hồ sơ"</strong>.</p>
                <p>Cột "Nhận HS" chuyển thành <span class="badge bg-success">Đã nhận</span>.</p>
            </div>
        </div>
    </div>

    <!-- Bước 4: Ghi chú bất thường -->
    <div class="step-card position-relative p-4">
        <div class="step-number">04</div>
        <div class="row align-items-center">
            <div class="col-md-2 text-center">
                <i class="bi bi-pencil-square fs-1 text-info"></i>
            </div>
            <div class="col-md-10">
                <h4><i class="bi bi-chat-text-fill text-info"></i> Ghi chú bất thường (nếu có)</h4>
                <p><strong>Thao tác:</strong> Bấm nút <strong class="text-info">"Ghi chú"</strong> → nhập nội dung (ví dụ: "Chưa làm chỉ định", "Nhập Mã Xét Nghiệm", "Không Chịu Khám") → Lưu.</p>
                <p>Ghi chú hiển thị trong cột "Ghi chú" để theo dõi. Ngoài ra, bạn có thể xem báo cáo ghi chú tại trang <strong>Thống kê ghi chú</strong>.</p>
            </div>
        </div>
    </div>

    <!-- Bước 5: Thống kê cuối ngày -->
    <div class="step-card position-relative p-4">
        <div class="step-number">05</div>
        <div class="row align-items-center">
            <div class="col-md-2 text-center">
                <i class="bi bi-graph-up fs-1 text-danger"></i>
            </div>
            <div class="col-md-10">
                <h4><i class="bi bi-bar-chart-steps"></i> Cuối ngày – Kiểm tra thống kê</h4>
                <p><strong>Thao tác:</strong> Sử dụng các nút thống kê trên thanh công cụ:</p>
                <ul>
                    <li><strong>Thống kê khám:</strong> Bấm <span class="badge bg-info">Thống kê khám</span> → chọn khoảng thời gian (hôm nay, tuần này, tháng này, hoặc khoảng ngày) → xem tổng số đã tiếp nhận, đã nhận hồ sơ, chưa nhận.</li>
                    <li><strong>Thống kê ghi chú:</strong> Bấm <span class="badge bg-info">Báo cáo MSXN</span> → lọc theo ngày, xem danh sách nhân viên có ghi chú, xuất Excel.</li>
                    <li><strong>Thống kê bệnh nhân chưa khám:</strong> Bấm <span class="badge bg-dark">Thống kê chưa khám</span> → xem biểu đồ theo bộ phận, danh sách chi tiết những người chưa khám, có thể lọc theo bộ phận và xuất Excel.</li>
                </ul>
                <p class="text-muted small"><i class="bi bi-download"></i> Mọi báo cáo đều có nút <strong>"Xuất CSV"</strong> để tải về máy.</p>
            </div>
        </div>
    </div>

    <!-- Mẹo nhanh -->
    <div class="alert alert-primary mt-4" role="alert">
        <i class="bi bi-lightbulb"></i> <strong>Mẹo nhanh:</strong> 
        - Bạn có thể quét thẻ nhân viên (mã NV) vào ô tra cứu, hệ thống sẽ tự động tìm và hiển thị thông tin – giúp thao tác cực kỳ nhanh!<br>
        - Sau khi tiếp nhận, bạn có thể bấm ngay "In chỉ định" mà không cần tìm lại nhân viên.
    </div>

    <!-- FAQ / Lưu ý -->
    <div class="mt-5">
        <h3 class="text-center fw-bold"><i class="bi bi-question-circle"></i> Một số lưu ý khi sử dụng</h3>
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="faq-item">
                    <i class="bi bi-check-circle text-success"></i>
                    <strong>Tiếp nhận không làm reload bảng?</strong>
                    <p class="mb-0">Đã được tối ưu: sau khi tiếp nhận, bạn vẫn giữ nguyên kết quả tìm kiếm và có thể bấm ngay "In chỉ định" mà không cần tìm lại.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="faq-item">
                    <i class="bi bi-exclamation-triangle text-warning"></i>
                    <strong>Lỡ bấm "Nhận hồ sơ" khi chưa nhận?</strong>
                    <p class="mb-0">Chức năng chỉ cập nhật một lần. Nếu sai, cần quản trị viên sửa trong cơ sở dữ liệu.</p>
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="faq-item">
                    <i class="bi bi-file-earmark-text"></i>
                    <strong>Không tìm thấy phiếu chỉ định?</strong>
                    <p class="mb-0">Hệ thống chưa tạo phiếu cho nhân viên đó. Báo quản trị viên để bổ sung file PDF/HTML vào thư mục <code>prescriptions/</code>.</p>
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="faq-item">
                    <i class="bi bi-database"></i> <strong>Nhập danh sách nhân viên mới?</strong>
                    <p class="mb-0">Chỉ quản trị viên mới có quyền import file CSV. Nhân viên y tế không cần làm thao tác này.</p>
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="faq-item">
                    <i class="bi bi-calendar-range"></i> <strong>Lọc theo khoảng ngày trong thống kê?</strong>
                    <p class="mb-0">Các trang thống kê đều hỗ trợ chọn "Khoảng ngày" (từ – đến) để xem dữ liệu chính xác.</p>
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="faq-item">
                    <i class="bi bi-bar-chart"></i> <strong>Biểu đồ bệnh nhân chưa khám?</strong>
                    <p class="mb-0">Tại trang "Thống kê chưa khám", bạn sẽ thấy biểu đồ trực quan số lượng chưa khám theo từng bộ phận.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer">
    <p class="mb-0"><i class="bi bi-heart-fill text-danger"></i> Hệ thống quản lý khám sức khỏe – Bệnh Viện Quân Y 121</p>
    <p class="small text-muted">Nếu cần hỗ trợ, hãy liên hệ quản trị viên</p>
    <p>NGUYỄN LÊ SẮC IT - 0707971402</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>