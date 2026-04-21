-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 21, 2026 lúc 09:30 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `ksk_management`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `emp_no` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `factory_location` varchar(100) DEFAULT NULL,
  `bp` varchar(100) DEFAULT NULL,
  `dept` varchar(255) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `national_id` varchar(50) DEFAULT NULL,
  `res_place` varchar(255) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `emp_class` varchar(100) DEFAULT NULL,
  `hire_type` varchar(50) DEFAULT NULL,
  `emp_status` varchar(50) DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `promotion_date` date DEFAULT NULL,
  `re_check1` varchar(50) DEFAULT NULL,
  `re_check2` varchar(50) DEFAULT NULL,
  `remark_original` text DEFAULT NULL,
  `is_received` tinyint(1) DEFAULT 0,
  `received_date` datetime DEFAULT NULL,
  `printed_count` int(11) DEFAULT 0,
  `last_print_date` datetime DEFAULT NULL,
  `is_returned` tinyint(1) DEFAULT 0,
  `returned_date` datetime DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `note_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `employees`
--

INSERT INTO `employees` (`id`, `emp_no`, `name`, `factory_location`, `bp`, `dept`, `gender`, `national_id`, `res_place`, `position`, `emp_class`, `hire_type`, `emp_status`, `hire_date`, `promotion_date`, `re_check1`, `re_check2`, `remark_original`, `is_received`, `received_date`, `printed_count`, `last_print_date`, `is_returned`, `returned_date`, `note`, `created_at`, `note_date`) VALUES
(11, '25250489', 'TRẦN THANH LÝ', 'VCT_3P', 'OUTSOLE', 'VCT 3P-2 Dept._Outsole Plant_Outsole Part 1_Shift C_Group C1_O/S Line 3', 'Male', '094206005906', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2025-02-19', '2025-02-19', NULL, NULL, NULL, 1, '2026-04-17 05:18:45', 5, '2026-04-21 03:03:00', 1, '2026-04-17 05:18:53', NULL, '2026-04-17 00:13:38', NULL),
(12, '23193431', 'NGUYỄN THỊ LAN ANH', 'VCT_OSP', 'STOCKFIT', 'VCT Plant Management Dept._Stockfit Plant_VSM B_Group B1_Team 22', 'Female', '092302002679', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2023-12-04', '2023-12-04', NULL, NULL, NULL, 1, '2026-04-17 03:37:16', 1, '2026-04-17 03:37:18', 1, '2026-04-17 03:37:21', NULL, '2026-04-17 00:13:38', NULL),
(15, '23190937', 'NGUYỄN THỊ DIỄM MY', 'VCT_OSP', 'STT', 'VCT Stitching Dept._Stitching Plant_Stitching VSM_Stitching Group 1_Stitching Team 2', 'Female', '094305003001', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2023-09-25', '2023-09-25', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(16, '23192568', 'THẠCH THỊ HƯA', 'VCT_OSP', 'SPRAY', 'VCT 3P-1 Dept._SPRAY Plant_Spray Part 2_Shift B_Group B3_Spray Team C9', 'Female', '084193006144', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2023-11-10', '2023-11-10', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(17, '17002328', 'NGUYỄN THỊ TÚ', 'VCT_3P', 'CMP', 'VCT 3P-2 Dept._CMPPHYLON Plant_CMP Part_Support Group_Sup. Prod Team', 'Female', '093190013512', 'Cục Cảnh sát QLHC về TTXH', 'TL C', 'Production worker', 'Permanent', 'Incumbent', '2018-04-02', NULL, NULL, NULL, NULL, 1, '2026-04-21 02:57:26', 5, '2026-04-17 08:49:48', 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(18, '25250296', 'BÙI TẤN THẠNH', 'VCT_3P', 'PU', 'VCT 3P-1 Dept._PU Plant_PU Part_Shift A_Group A2_Manual Team 10', 'Male', '094091014009', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2025-01-08', '2025-01-08', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(19, '22192101', 'NGUYỄN ANH THƯ', 'VCT_OSP', 'STOCKFIT', 'VCT Plant Management Dept._Stockfit Plant_VSM A_Group A1_Team 5', 'Female', '092197007261', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2022-02-24', '2022-02-24', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(20, '21203166', 'TRẦN HỌA MY', 'VCT_3P', 'OUTSOLE', 'VCT 3P-2 Dept._Outsole Plant_Sub Group', 'Female', '092186001965', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Permanent', 'Incumbent', '2021-11-10', '2021-11-10', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(21, '21196778', 'HUỲNH THỊ BÍCH NGÂN', 'VCT_3P', 'OUTSOLE', 'VCT 3P-2 Dept._Outsole Plant_Sub Group', 'Female', '086189008757', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Permanent', 'Incumbent', '2021-05-18', '2021-05-18', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(22, '19214903', 'VÕ THỊ ÚT MƯỜI', 'VCT_3P', 'QM', 'VCT Development Dept._QM Head Part_Outsole Part', 'Female', '094188016757', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Permanent', 'Incumbent', '2019-11-19', '2019-11-19', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(23, '17001659', 'NGUYỄN THỊ NHUNG', 'VCT_3P', 'QM', 'VCT Development Dept._QM Head Part_IP Part', 'Female', '093191004043', 'Cục Cảnh sát QLHC về TTXH', 'TL C', 'Production worker', 'Permanent', 'Incumbent', '2018-03-02', '2020-08-01', NULL, NULL, NULL, 1, '2026-04-20 05:23:38', 2, '2026-04-20 10:58:39', 1, '2026-04-20 05:23:40', NULL, '2026-04-17 02:30:12', NULL),
(24, '23191810', 'LÊ THỊ MỸ HẰNG', 'VCT_3P', 'PU', 'VCT 3P-1 Dept._PU Plant_PU Part_Shift B_Group B1_Trimming Team 4', 'Female', '093196002995', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2023-10-18', '2023-10-18', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(25, '24248184', 'TRẦN THỊ THANH NHI', 'VCT_OSP', 'STT-C', 'VCT Stitching Dept._Stitching Plant_Stitching Comp  VSM_Shift A_Nosew Group A1_Nosew Team 5', 'Female', '094304006089', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2024-05-03', '2024-05-03', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(26, '17000087', 'NGUYỄN ANH ĐÀO', 'VCT_3P', 'PRO.PLANNING', 'VCT Production Planning Dept._Prod.planning Headpart_Office Planning Group', 'Female', '093189001762', 'Cục Cảnh sát QLHC về TTXH', 'GL B', 'Management', 'Permanent', 'Incumbent', '2016-12-22', '2022-01-01', NULL, NULL, NULL, 1, '2026-04-20 05:23:37', 2, '2026-04-17 08:49:18', 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(27, '22189615', 'HUỲNH THỊ CẨM THU', 'VCT_OSP', 'STOCKFIT', 'VCT Plant Management Dept._Stockfit Plant_VSM A_Group A1_Team 2', 'Female', '091301000111', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2022-02-15', '2022-02-15', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(28, '25250469', 'TRẦN XUÂN QUỲNH', 'VCT_3P', 'Business Planning', 'VCT Management Dept._Business Planning Head Part_BizPlanning/Costing Part', 'Female', '092198002782', 'Cục Cảnh sát QLHC về TTXH', 'Staff', 'Management', 'Contract', 'Incumbent', '2025-02-19', '2025-02-19', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(29, '24249176', 'NGUYỄN THỊ HỒNG GẤM', 'VCT_3P', 'OUTSOLE', 'VCT 3P-2 Dept._Outsole Plant_Sub Group', 'Female', '095303007311', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2024-05-13', '2024-05-13', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(30, '24247968', 'DƯ HỒNG THẢO LINH', 'VCT_OSP', 'STOCKFIT', 'VCT Plant Management Dept._Stockfit Plant_VSM A_Group A2_Team 9', 'Female', '093305006138', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2024-04-25', '2024-04-25', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(31, '22196455', 'NGUYỄN THANH KIỀU', 'VCT_3P', 'QM', 'VCT Development Dept._QM Head Part_UV Part', 'Female', '093190010173', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2022-04-22', '2022-04-22', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(32, '22189298', 'ĐINH THỊ TUYỀN', 'VCT_OSP', 'STOCKFIT', 'VCT Plant Management Dept._Stockfit Plant_VSM B_Group B2_Team 27', 'Female', '093195002629', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2022-02-14', '2022-02-14', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(33, '23190766', 'THỊ LỆ', 'VCT_OSP', 'STT', 'VCT Stitching Dept._Stitching Plant_Stitching VSM_Stitching Group 8_Stitching Team A2', 'Female', '095197006338', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2023-09-20', '2023-09-20', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(34, '21193097', 'BÙI THỊ BÍCH THẢO', 'VCT_3P', 'OUTSOLE', 'VCT 3P-2 Dept._Outsole Plant_Sub Group', 'Female', '093199006104', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Permanent', 'Incumbent', '2021-03-27', '2021-03-27', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(35, '24249360', 'VÕ THỊ KIM NGÂN', 'VCT_OSP', 'STOCKFIT', 'VCT Plant Management Dept._Stockfit Plant_VSM A_Group A3_Team 16', 'Female', '084303003189', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2024-05-15', '2024-05-15', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(36, '19207004', 'TRẦN NGỌC CHÂU', 'VCT_OSP', 'STT', 'VCT Stitching Dept._Stitching Plant_Stitching VSM_Stitching Group 6_Stitching Team 23', 'Female', '093199007129', 'Cục Cảnh sát QLHC về TTXH', 'TL C', 'Production worker', 'Permanent', 'Incumbent', '2019-07-08', '2024-07-01', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(37, '20186639', 'PHAN THỊ KIM THÚY', 'VCT_3P', 'QM', 'VCT Development Dept._QM Head Part_Outsole Part', 'Female', '092197009192', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Permanent', 'Incumbent', '2020-11-09', '2020-11-09', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(38, '22188758', 'NGÔ THỊ NGỌC HÂN', 'VCT_3P', 'OUTSOLE', 'VCT 3P-2 Dept._Outsole Plant_Sub Group', 'Female', '094192004405', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2022-02-11', '2022-02-11', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(39, '24249156', 'LÒ THỊ MAI', 'VCT_3P', 'OUTSOLE', 'VCT 3P-2 Dept._Outsole Plant_Sub Group', 'Female', '084198000503', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2024-05-13', '2024-05-13', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(40, '24256444', 'NGUYỄN THỊ SON', 'VCT_OSP', 'STOCKFIT', 'VCT Plant Management Dept._Stockfit Plant_VSM A_Group A1_Team 5', 'Female', '093188005849', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2024-07-31', '2024-07-31', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(41, '24256137', 'TRẦN THỊ THÚY', 'VCT_OSP', 'STT-C', 'VCT Stitching Dept._Stitching Plant_Stitching Comp  VSM_Shift B_Nosew Group B2_Nosew Team 12', 'Female', '091196009521', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2024-07-26', '2024-07-26', NULL, NULL, NULL, 0, NULL, 1, '2026-04-17 05:45:02', 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(42, '24262010', 'TRẦN THỊ TRÚC PHƯƠNG', 'VCT_OSP', 'STOCKFIT', 'VCT Plant Management Dept._Stockfit Plant_VSM B_Group B2_Team 27', 'Female', '092195010860', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2024-10-16', '2024-10-16', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(43, '22189330', 'NGUYỄN THỊ BÉ MY', 'VCT_3P', 'QM', 'VCT Development Dept._QM Head Part_Spray Part', 'Female', '094301004381', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2022-02-14', '2022-02-14', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(44, '23187650', 'TRẦN THỊ KIM ANH', 'VCT_OSP', 'SPRAY', 'VCT 3P-1 Dept._SPRAY Plant_Spray Part 1_Shift A_Group A1_PUSpray Team  B4', 'Female', '093303000970', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2023-02-21', '2023-02-21', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(45, '24256110', 'NGUYỄN THỊ SEN', 'VCT_OSP', 'SPRAY', 'VCT 3P-1 Dept._SPRAY Plant_Spray Part 1_Shift C_Group C1_PUSpray Team B4', 'Female', '086304009472', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2024-07-26', '2024-07-26', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(46, '23190172', 'TRẦN NGỌC MUỘI', 'VCT_OSP', 'UV', 'VCT 3P-1 Dept._UV Plant_UV Part_Shift B_Group B1_Team B1', 'Female', '094300000564', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2023-09-06', '2023-09-06', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(47, '20186913', 'TRẦN THỊ YẾN', 'VCT_3P', 'OUTSOLE', 'VCT 3P-2 Dept._Outsole Plant_Sub Group', 'Female', '092198003191', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Permanent', 'Incumbent', '2020-11-19', '2020-11-19', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(48, '24241264', 'VÕ THỊ MỘNG THU', 'VCT_OSP', 'UV', 'VCT 3P-1 Dept._UV Plant_UV Part_Shift A_Group A2_Team B8', 'Female', '094193007600', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2024-01-15', '2024-01-15', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(49, '19193946', 'TRƯƠNG THỊ BÉ', 'VCT_OSP', 'STT', 'VCT Stitching Dept._Stitching Plant_Stitching VSM_Stitching Group 2_Stitching Team 5', 'Female', '096194011472', 'Cục Cảnh sát QLHC về TTXH', 'TL C', 'Production worker', 'Permanent', 'Incumbent', '2019-01-22', '2024-07-01', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(50, '23192335', 'NGUYỄN THỊ NGÂM', 'VCT_3P', 'PU', 'VCT 3P-1 Dept._PU Plant_PU Part_Shift B_Group B1_Trimming Team 4', 'Female', '094198011411', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2023-11-06', '2023-11-06', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(51, '21203838', 'ĐẶNG THANH NGÂN', 'VCT_3P', 'OUTSOLE', 'VCT 3P-2 Dept._Outsole Plant_Sub Group', 'Female', '093302000504', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Permanent', 'Incumbent', '2021-11-16', '2021-11-16', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(52, '18193135', 'NGUYỄN THỊ KIM NGỌC', 'VCT_3P', 'C&B Headpart', 'VCT Management Dept._C&B Headpart_Payroll Part', 'Female', '092195002484', 'Cục Cảnh sát QLHC về TTXH', 'Staff', 'Management', 'Permanent', 'Incumbent', '2018-12-13', '2019-10-01', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(53, '19205521', 'TRẦN THỊ CẨM HUYỀN', 'VCT_3P', 'PU', 'VCT 3P-1 Dept._PU Plant_PU Part_NIKE ID Group_ID Team B', 'Female', '093192000341', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Permanent', 'Incumbent', '2019-06-19', '2019-06-19', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(54, '19209015', 'TỪ THỊ BÍCH MAI', 'VCT_3P', 'MATERIAL', 'VCT Material Dept._Supply Headpart', 'Female', '093197004918', 'Cục Cảnh sát QLHC về TTXH', 'TL B', 'Production worker', 'Permanent', 'Incumbent', '2019-08-01', '2023-03-01', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(55, '18192933', 'THẠCH THỊ HOÀNG', 'VCT_OSP', 'STOCKFIT', 'VCT Plant Management Dept._Stockfit Plant_VSM A_Group A1_Team 1', 'Female', '084193004240', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Permanent', 'Incumbent', '2018-12-06', '2018-12-06', NULL, NULL, NULL, 1, '2026-04-21 08:45:36', 2, '2026-04-17 08:32:32', 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(56, '17002025', 'VÕ THỊ THANH ĐOAN', 'VCT_3P', 'IP', 'VCT 3P-2 Dept._IP Plant_IP Part 1_Shift B_Group B1_Team 2', 'Female', '092195011426', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Permanent', 'Incumbent', '2018-03-14', NULL, NULL, NULL, NULL, 1, '2026-04-20 05:23:39', 1, '2026-04-20 05:17:38', 0, '2026-04-20 02:11:50', '17855555', '2026-04-17 02:30:12', NULL),
(57, '19193869', 'BÙI THỊ TÀI LINH', 'VCT_3P', 'HRAD', 'VCT Management Dept._HRAD Headpart_HRP Part', 'Female', '093192004048', 'Tỉnh Hậu Giang', 'Staff', 'Management', 'Permanent', 'Incumbent', '2019-01-17', '2019-06-01', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(58, '17002749', 'PHẠM THỊ MỸ LINH', 'VCT_3P', 'COMPOUND IP', 'VCT 3P-2 Dept._Compound IP Plant_IP Part_Shift C_Group C1_Trimming  Team 1', 'Female', '092194008194', 'Cục Cảnh sát QLHC về TTXH', 'TL C', 'Production worker', 'Permanent', 'Incumbent', '2018-06-05', '2024-11-01', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(59, '22196080', 'NGUYỄN THẢO MY', 'VCT_3P', 'CE-LAB', 'VCT Development Dept._CE Lab Head Part_MQAA Part', 'Female', '092196011443', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2022-04-16', '2022-04-16', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(60, '24247807', 'NGUYỄN THỊ KIM XUYẾN', 'VCT_OSP', 'STOCKFIT', 'VCT Plant Management Dept._Stockfit Plant_VSM A_Group A3_Team 13', 'Female', '093305000387', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2024-04-24', '2024-04-24', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(61, '22195613', 'NGÔ THỊ THANH THÚY', 'VCT_OSP', 'STOCKFIT', 'VCT Plant Management Dept._Stockfit Plant_VSM D_Support Group_Plant Office Team', 'Female', '093198003380', 'Cục Cảnh sát QLHC về TTXH', 'Staff', 'Management', 'Contract', 'Incumbent', '2022-04-08', '2023-11-01', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(62, '24245613', 'NGUYỄN THỊ HUỲNH NHƯ', 'VCT_OSP', 'STT-C', 'VCT Stitching Dept._Stitching Plant_Stitching Comp  VSM_Shift B_Nosew Group B2_Nosew Team 11', 'Female', '093304009998', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2024-04-01', '2024-04-01', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(63, '21188920', 'NGUYỄN THỊ THÚY KIỀU', 'VCT_3P', 'IP', 'VCT 3P-2 Dept._IP Plant_IP Part 1_Shift A_Group A2_Team 6', 'Female', '093191001374', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Permanent', 'Incumbent', '2021-02-22', '2021-02-22', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(64, '21197383', 'PHAN THỊ CẨM GIANG', 'VCT_3P', 'OUTSOLE', 'VCT 3P-2 Dept._Outsole Plant_Sub Group', 'Female', '093197001231', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Permanent', 'Incumbent', '2021-05-25', '2021-05-25', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(65, '17000007', 'PHẠM THỊ HỒNG NHƯ', 'VCT_3P', 'QM', 'VCT Development Dept._QM Head Part', 'Female', '094189004059', 'Cục Cảnh sát QLHC về TTXH', 'GL A', 'Management', 'Permanent', 'Incumbent', '2016-08-01', '2024-01-01', NULL, NULL, NULL, 1, '2026-04-20 05:25:59', 10, '2026-04-17 08:50:58', 1, '2026-04-21 08:44:46', '17000000', '2026-04-17 02:30:12', NULL),
(66, '24257759', 'PHẠM THỊ THÚY DUYÊN', 'VCT_3P', 'COMPOUND IP', 'VCT 3P-2 Dept._Compound IP Plant_IP Part_Shift B_Group B2_Team 7', 'Female', '094197002436', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2024-08-14', '2024-08-14', NULL, NULL, NULL, 1, '2026-04-21 08:45:39', 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(67, '24244544', 'LÊ THỊ NGỌC GIÀU', 'VCT_OSP', 'STT-C', 'VCT Stitching Dept._Stitching Plant_Stitching Comp  VSM_Shift B_Nosew Group B2_Nosew Team 16', 'Female', '091305012534', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2024-03-20', '2024-03-20', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(68, '24253544', 'NGUYỄN THỊ ANH THƯ', 'VCT_OSP', 'SPRAY', 'VCT 3P-1 Dept._SPRAY Plant_Spray Part 1_Shift A_Group A1_PUSpray Team  B4', 'Female', '093306004939', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2024-07-03', '2024-07-03', NULL, NULL, NULL, 0, NULL, 1, '2026-04-17 05:20:41', 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(69, '22189380', 'PHẠM THỊ Ý NHI', 'VCT_3P', 'PU', 'VCT 3P-1 Dept._PU Plant_PU Part_NIKE ID Group_ID Team A', 'Female', '093198002275', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2022-02-14', '2022-02-14', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(70, '19214664', 'NGUYỄN THỊ MỶ THO', 'VCT_3P', 'OUTSOLE', 'VCT 3P-2 Dept._Outsole Plant_Sub Group', 'Female', '094187012331', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Permanent', 'Incumbent', '2019-11-13', '2019-11-13', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(71, '17003299', 'NGUYỄN THỊ NHUNG', 'VCT_OSP', 'STT-C', 'VCT Stitching Dept._Stitching Plant_Stitching Comp  VSM_Shift A_EMB Group A_EMB Team 1', 'Female', '094190016274', 'Cục Cảnh sát QLHC về TTXH', 'TL C', 'Production worker', 'Permanent', 'Incumbent', '2018-07-10', '2019-01-01', NULL, NULL, NULL, 1, '2026-04-17 08:53:41', 2, '2026-04-17 08:53:42', 1, '2026-04-17 08:53:40', NULL, '2026-04-17 02:30:12', NULL),
(72, '24249067', 'ĐẶNG THỊ QUỲNH HƯƠNG', 'VCT_3P', 'OUTSOLE', 'VCT 3P-2 Dept._Outsole Plant_Sub Group', 'Female', '072300004296', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2024-05-10', '2024-05-10', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(73, '23191561', 'LÊ THỊ HỒNG HOA', 'VCT_3P', 'IP', 'VCT 3P-2 Dept._IP Plant_IP Part 1_Shift B_Group B1_Team 1', 'Female', '077305000637', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2023-10-06', '2023-10-06', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(74, '24251924', 'VÕ THỊ DUY', 'VCT_OSP', 'SPRAY', 'VCT 3P-1 Dept._SPRAY Plant_Spray Part 2_Shift C_Group C1_Spray Team C2', 'Female', '094305002103', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2024-06-15', '2024-06-15', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(75, '17001384', 'TRẦN THỊ KIM NGỌC', 'VCT_3P', 'OUTSOLE', 'VCT 3P-2 Dept._Outsole Plant_Sub Group', 'Female', '094190007438', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Permanent', 'Incumbent', '2018-01-20', NULL, NULL, NULL, NULL, 1, '2026-04-20 05:23:38', 2, '2026-04-17 08:31:45', 1, '2026-04-20 05:23:40', '121732376', '2026-04-17 02:30:12', NULL),
(76, '23187564', 'PHÙNG NGỌC ÁNH', 'VCT_OSP', 'SPRAY', 'VCT 3P-1 Dept._SPRAY Plant_Spray Part 1_Shift A_Group A1_PUSpray Team  B4', 'Female', '093192000680', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2023-02-15', '2023-02-15', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(77, '17004197', 'NGUYỄN THỊ BÍCH TRÂM', 'VCT_3P', 'PU', 'VCT 3P-1 Dept._PU Plant_PU Part_Shift B_Group B1_Trimming Team 4', 'Female', '092199002298', 'Thành phố Cần Thơ', 'Worker', 'Production worker', 'Permanent', 'Incumbent', '2018-08-28', NULL, NULL, NULL, NULL, 1, '2026-04-17 05:28:44', 2, '2026-04-17 05:28:46', 1, '2026-04-17 05:29:02', '123432425', '2026-04-17 02:30:12', NULL),
(78, '24254068', 'LỮ KIM NGÂN', 'VCT_OSP', 'SPRAY', 'VCT 3P-1 Dept._SPRAY Plant_Spray Part 2_Shift A_Group A1_Spray Team C1', 'Female', '092305001728', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2024-07-08', '2024-07-08', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(79, '23191539', 'TRẦN THỊ KIỀU NY', 'VCT_OSP', 'UV', 'VCT 3P-1 Dept._UV Plant_UV Part_Shift B_Group B1_Team B3', 'Female', '093188006892', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2023-10-04', '2023-10-04', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(80, '21202387', 'NGUYỄN THỊ HOÀNG PHƯỢNG', 'VCT_3P', 'QM', 'VCT Development Dept._QM Head Part_Spray Part', 'Female', '092184002483', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Permanent', 'Incumbent', '2021-11-05', '2021-11-05', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL),
(81, '24245578', 'TRẦN TRIỆU VĨ', 'VCT_OSP', 'STT-C', 'VCT Stitching Dept._Stitching Plant_Stitching Comp  VSM_Shift B_Nosew Group B1_Nosew Team 6', 'Female', '093196000515', 'Cục Cảnh sát QLHC về TTXH', 'Worker', 'Production worker', 'Contract', 'Incumbent', '2024-04-01', '2024-04-01', NULL, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, '2026-04-17 02:30:12', NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emp_no` (`emp_no`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
