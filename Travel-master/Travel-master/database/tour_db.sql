-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 04, 2022 lúc 04:30 PM
-- Phiên bản máy phục vụ: 10.4.24-MariaDB
-- Phiên bản PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `tour_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_contact` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `admin_name`, `admin_email`, `admin_password`, `admin_contact`, `admin_status`, `date`) VALUES
(2, 'admin', 'Admin', 'admin@gmail.com', '$2y$12$ydxgE3G7aL4FhNOhjxBJqunBZGxiPO60pnBMXpOoQyHRZXU8YIA5W', '', 'approved', '2022-09-01'),
(5, 'admin2', 'Trịnh Tuấn Minh', 'admin2@gmail.com', '$2y$12$AqazJmQOIi9QJ0PPEj2YJe83AF0FvdhQrF0pi.rdjy.uI5iT1qwhm', '', 'approved', '2022-11-22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `agencies`
--

CREATE TABLE `agencies` (
  `agency_id` int(11) NOT NULL,
  `agency_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `agency_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `agency_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover_image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `agency_contact` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `agency_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `agency_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `agencies`
--

INSERT INTO `agencies` (`agency_id`, `agency_name`, `owner_name`, `agency_email`, `agency_password`, `logo_image`, `cover_image`, `agency_contact`, `agency_address`, `agency_status`, `date`) VALUES
(2, 'Holidays', 'Lý Văn Toán', 'vantoan@gmail.com', '$2y$12$xHb7FvRS3jRly6DX9Z/fxesZ.Ox.I7kVkJLrws0HBgMxrJcXTqWEu', 'agency_logo.jpg', 'agency.jpg', '0147863591', '22 Ông Ích Khiêm', 'approved', '2022-10-08'),
(3, 'Ban Mai Xanh', 'Nguyễn Anh Kiều', 'will@gmail.com', '$2y$12$BJrLKYFLn126UqjjcLG/6OgtOFqegZJWk6Hh9XXMFfMs5jmQXS8iG', 'pexels-magda-ehlers-1337380.jpg', 'pexels-francisco-valerio-trujillo-1824392.jpg', '0177863912', '201 Hoàng Diệu', 'approved', '2022-10-10'),
(5, 'Traveloga', 'Thái Anh Khang', 'khang@gmail.com', '$2y$12$Aq7puCCxM5WDvFmiH/nNDeUUUELpSwyelUedy.3/4WD21IXz6LEcy', 'laura-chouette-Zg6UTBHQiI4-unsplash.jpg', 'luca-bravo-SRjZtxsK3Os-unsplash.jpg', '0147863591', '99 Ngô Kiều', 'approved', '2022-10-08'),
(6, 'Summer', 'Nguyễn Gia Khôi', 'mekhoi@gmail.com', '$2y$12$opFrZrLRmhDKeZVarR6lxOqNBCp7fI2K1bqlmpjx8nx8N1NRacaK.', 'alexey-mak-sMZLg77Z2Dk-unsplash.jpg', 'alexander-popov-i0KaMiYdpDM-unsplash.jpg', '0127863591', '36 Phan Châu Trinh', 'approved', '2021-11-01'),
(7, 'Ban Mai', 'Bùi Văn Tiến', 'tienbui@gmail.com', '$2y$12$Yn6g6oanzUvPgjw8cuXMXej/BWyqdmnC6ub0A//YeDe1YT8SSjwlC', 'francesco-ungaro-9UWXNSbEuYw-unsplash.jpg', 'hugo-delauney-feHioLsUj8o-unsplash.jpg', '0127863591', '303 Hoàng Anh', 'approved', '2021-11-09'),
(8, 'Tropical ', 'Lăng Thị Hoa', 'hoanh@gmail.com', '$2y$12$ziF9ELWkDtGEM.rwgv8HQe97QlpLI18hQ6.lOngi1hbCd5Soiamri', 'moritz-mentges-5MlBMYDsGBY-unsplash.jpg', 'riz-mooney-Ep3NPU9Uhkw-unsplash.jpg', '0127863591', '54 Lỗ Giáng', 'approved', '2022-11-20'),
(12, 'Hạnh Phúc', 'Nguyễn Đăng Thịnh', 'liam@gmail.com', '$2y$12$UD6ISyYopu51fC6El45xv.6hqP6JsWmyZdN37TDalxeVwhtqLzT7S', '1agency_logo.jpg', '1agency_cover.jpg', '0125478963', '241 Trường Sơn', 'approved', '2022-11-24'),
(14, 'Sen Vàng', 'Lương Băng Hoa', 'lyyyy@gmail.com', '$2y$12$bLo3MvKpVd8QhfWwAiEMeujwWisXFT.V71ZoEeys6aMIXb1vBUV5O', '1dn.jpg', '', '0123456765', '102 Nguyễn Văn Linh', 'unapproved', '2022-11-25'),
(17, 'Moon', 'Nguyễn Thị Phương Thư', 'phuongthu@gmail.com', '$2y$12$BJrLKYFLn126UqjjcLG/6OgtOFqegZJWk6Hh9XXMFfMs5jmQXS8iG', 'travel-1883060_1280.png', 'pexels-francisco-valerio-trujillo-1824392.jpg', '0956342676', '95 Nguyễn Hữu Thọ, Đà Nẵng', 'unapproved', '2022-11-29'),
(18, 'Sen V&agrave;ng 32', 'Nguyễn Thị Thủy', 'daily@gmail.com', '$2y$12$tbY10PVzu67btG8C0LZO.etdacX4RUP19.piriChVvq1.XZqza1BO', '', '', '0323456765', '95 Nguyễn Hữu Thọ, Đ&agrave; Nẵng', 'approved', '2022-11-29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `agency_employees`
--

CREATE TABLE `agency_employees` (
  `employee_id` int(11) NOT NULL,
  `agency_id` int(11) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `employee_email` varchar(255) NOT NULL,
  `employee_password` varchar(255) NOT NULL,
  `employee_contact` varchar(255) NOT NULL,
  `employee_address` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `agency_employees`
--

INSERT INTO `agency_employees` (`employee_id`, `agency_id`, `employee_name`, `employee_email`, `employee_password`, `employee_contact`, `employee_address`, `role`, `date`) VALUES
(2, 3, 'Anh Dũng', 'nis@gmail.com', '$2y$12$BJrLKYFLn126UqjjcLG/6OgtOFqegZJWk6Hh9XXMFfMs5jmQXS8iG', '0187935963', '30 Lỗ Giáng 22', 'Người quản lý', '2022-10-10'),
(3, 3, 'Nguyễn Anh Khang', 'anhkhang@gmail.com', '$2y$12$Qe7wIzhdH0YsAgDAzC85/O85FKW/uA3TZdGFl9DSqqpqfVuF/G1H.', '0187935963', '', 'Nhân viên', '2022-10-19'),
(4, 2, 'Nguyễn Tuân', 'chatuan@gmail.com', '$2y$12$2NfFKVii4OzBaE8MGuz5qOhpEDu90L0Kgeh7mxfvfaz.6iF6d8IKe', '0178936547', 'Núi Thành', 'Người quản lý', '2022-10-08'),
(5, 3, 'Nguyễn Thị Trúc', 'kathy@gmail.com', '$2y$12$BJrLKYFLn126UqjjcLG/6OgtOFqegZJWk6Hh9XXMFfMs5jmQXS8iG', '0178936577', '21 Đô Đốc', 'Nhân viên', '2022-10-25'),
(6, 5, 'Gia Bảo', 'giabao@gmail.com', '$2y$12$wa.AJAFFQ4DUS.WzThAxI.VrQ7hGClsvvSaHW5GBOr1YTAKwDiMlm', '0879359632', '20 Khải Dung', 'Nhân viên', '2022-10-28'),
(8, 5, 'Hồ Văn Anh', 'hoanh@gmail.com', '$2y$12$fpI4Qz5SW1Bqa9pACSCOa.x7lxaldfDLVTNPBFDSdc6OnGsiOQX9S', '079359632q', '335 Nguyễn Hữu Thọ', 'Người quản lý', '2022-10-08'),
(9, 6, 'Trần Thị Ly', 'lyly@gmail.com', '$2y$12$fZ5dkQsOhvm4ACUOOup/lOkA8L5dWuD1VWeJuivGHeezztNPESt/e', '0935963221', 'Điện Bàn', 'Người quản lý', '2022-11-01'),
(10, 12, 'Đỗ Thị Mỹ Linh', 'dolinh@gmail.com', '$2y$12$YNMtoi5/b9SDrBpJyY8eXeX/PM35/j6qM18TmAu25VomciqLnzMM2', '0358974630', '374 Mẹ Nhu', 'Người quản lý', '2022-11-24'),
(11, 12, 'Nguyễn Anh Thư', 'thuthu@gmail.com', '$2y$12$3lnwMfi9rLOsxYHgWwD7veuOM1nWtDcm0UgNQW4mKg2rjD7RiF9WG', '0358974630', 'Điện Ngọc', 'Nhân viên', '2021-11-26');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `tourist_id` int(11) NOT NULL,
  `agency_id` int(11) NOT NULL,
  `persons` int(2) NOT NULL,
  `travel_style` varchar(255) NOT NULL,
  `tourist_name` varchar(255) NOT NULL,
  `tourist_email` varchar(255) NOT NULL,
  `tourist_contact` varchar(255) NOT NULL,
  `enquiry_msg` text NOT NULL,
  `booking_status` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `bookings`
--

INSERT INTO `bookings` (`booking_id`, `package_id`, `tourist_id`, `agency_id`, `persons`, `travel_style`, `tourist_name`, `tourist_email`, `tourist_contact`, `enquiry_msg`, `booking_status`, `date`) VALUES
(3, 10, 3, 3, 8, 'Tiết kiệm', 'Lương Văn Khánh', 'Khanh12@gmail.com', '', '', 'Xác nhận', '2022-10-10'),
(4, 3, 4, 3, 5, 'Sang trọng', 'Nguyễn Thị Hòa', 'hoa@gmail.com', '', '', 'Xác nhận', '2022-10-26'),
(5, 5, 10, 3, 5, 'Tiết kiệm', 'Nguyễn Thị Ánh Tuyết', 'tuyet@gmail.com', '', '', 'Xác nhận', '2022-10-27'),
(6, 6, 4, 3, 4, 'Tiết kiệm', 'Nguyễn Thị Hòa', 'hoa@gmail.com', '', '', 'Xác nhận', '2022-10-18'),
(7, 12, 4, 2, 30, 'Tiện nghi', 'Nguyễn Thị Hòa', 'hoa@gmail.com', '', '', 'Xác nhận', '2022-11-02'),
(9, 2, 5, 2, 20, 'Tiện nghi', 'Lý Quỳnh Anh', 'liz@gmail.com', '', '', 'Xác nhận', '2022-10-22'),
(16, 2, 9, 2, 12, 'Tiện nghi', 'Trần Thị Lụa', 'khanh@gmail.com', '', '', 'Xác nhận', '2022-10-22'),
(23, 10, 16, 3, 2, 'Tiết kiệm', 'Nguyễn Thị Phương Duy&ecirc;n', 'duyenntp15082003@gmail.com', '0222222222', '', 'Xác nhận', '2022-12-01'),
(24, 10, 16, 3, 2, 'Tiết kiệm', 'Nguyễn Thị Phương Duy&ecirc;n', 'duyenntp15082003@gmail.com', '0222222222', '', 'Từ chối', '2022-12-01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `tourist_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `agency_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `comment_status` varchar(255) NOT NULL,
  `comment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`comment_id`, `tourist_id`, `package_id`, `agency_id`, `content`, `comment_status`, `comment_date`) VALUES
(1, 4, 3, 3, '<p>Mọi thứ ok</p>', 'Đã phê duyệt', '2022-11-23'),
(4, 9, 2, 2, '<p>Mọi thứ ok</p>', 'Đã phê duyệt', '2022-11-17'),
(7, 5, 2, 2, '<p>Mọi thứ ok</p>', 'Đã phê duyệt', '2022-11-24'),
(11, 3, 5, 3, '<p>Mọi thứ ok</p>', 'Đã phê duyệt', '2022-11-29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `packages`
--

CREATE TABLE `packages` (
  `package_id` int(11) NOT NULL,
  `agency_id` int(11) NOT NULL,
  `package_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `place_details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `place_images` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_days` int(11) NOT NULL,
  `num_nights` int(11) NOT NULL,
  `budget_price` int(20) NOT NULL,
  `comfort_price` int(20) NOT NULL,
  `lux_price` int(20) NOT NULL,
  `budget_details` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `comfort_details` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lux_details` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_percentage` int(11) NOT NULL,
  `min_people` int(11) NOT NULL,
  `includes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `excludes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `counsel` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `itinerary` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `packages`
--

INSERT INTO `packages` (`package_id`, `agency_id`, `package_name`, `location`, `place_details`, `place_images`, `num_days`, `num_nights`, `budget_price`, `comfort_price`, `lux_price`, `budget_details`, `comfort_details`, `lux_details`, `booking_percentage`, `min_people`, `includes`, `excludes`, `counsel`, `itinerary`, `package_status`, `package_date`) VALUES
(2, 3, 'Đà Nẵng', 'Đà Nẵng', '<p>Nội thành phố Đà Nẵng</p>', '(\'1dn.jpg\'),(\'2dn.jpg\'),(\'3dn.jpg\')', 2, 1, 3000000, 5000000, 6000000, 'Phương tiện di chuyển và chỗ ở bình thường', 'phương tiện di chuyển tầm trung và chỗ ở 4*', 'Phương tiện di chuyển cao cấp và chỗ ở 5*', 10, 20, '<ul><li>Phương tiện di chuyển</li><li>Bữa sáng</li><li>Khách sạn</li></ul>', '<ul><li>Ăn trưa</li><li>Ăn tối</li></ul>', '', '<p><strong>Ngày 1: </strong>Dạo quanh thành phố<br>Chùa Non Nước <br>Chùa Linh Ứng\r\n</p><p><strong>Day 2:</strong> Bà Nà Hill</p>', 'Có sẵn', '2022-10-08'),
(3, 3, 'Huế-Đà Nẵng', ' Huế<br>\r\nĐà Nẵng', '<p>Nội thành Huế<br>\r\nThành phố Đà Nẵng</p>', '(\'hue.jpg\'),(\'hue1.jpg\'),(\'dn1.jpg\'),(\'dn.jpg\')', 2, 1, 4000000, 6000000, 7500000, 'Di chyển và khách sạn bình thường', 'Di chuyển và khách sạn 4*', 'Di chuyển và khách sạn 5*', 5, 20, '<ul><li>Phương tiện di chuyển</li><li>Giá tàu/xe</li><li>Khách sạn</li><li>Ăn sáng</li><li>Hướng dẫn viên</li></ul>', '<ul><li>Ăn trưa</li><li>Ăn tối</li></ul>', '<ul><li>Quạt cầm tay</li><li>Mũ/nón</li><li>Áo dài</li></ul>', '<p><strong>Ngày 1: </strong>Thăm quan những danh lam thắng cảnh tại Huế</p><p><strong>Tối ngày 1: </strong>Ngắm thành phố Đà Nẵng về đêm\r\nNgày 2: </strong>Thăm quan thành phố Đà Nẵng\r\n</p>', 'Có sẵn', '2022-10-08'),
(5, 2, 'Hà Giang', 'Hà Giang', '<p>Tỉnh Hà Giang</p>', '(\'hagiang.jpg\'),(\'hagiang2.jpg\'),(\'hagiang1.jpg\')', 2, 1, 8000000, 1000000, 13000000, 'Di chyển và khách sạn bình thường', 'Di chuyển và khách sạn 4*', 'Di chuyển và khách sạn 5*', 20, 40, '<ul><li>Phương tiện di chuyển</li><li>Giá tàu/xe</li><li>Khách sạn</li><li>Ăn sáng</li><li>Hướng dẫn viên</li></ul>', '<ul><li>Ăn trưa</li><li> Ăn tối</li></ul>', '<ul><li>Dép bẹt</li><li>Đồ ấm</li></ul>', '<p><strong>Ngày 1: </strong>Thăm quan Hà Giang</p><p><strong>Ngày 2: </strong>Cột cờ Lũng Cú</p>', 'Có sẵn', '2022-10-08'),
(6, 3, 'Hội An', 'Hội An', '<p>Đi bộ dạo phố cổ</p>', '(\'HA.jpg\'),(\'1Hoian.jpg\'),(\'1ha.jpg\')', 1, 1, 800000, 1000000, 1500000, 'Di chuyển v&agrave; chỗ ở b&igrave;nh thường', 'Di chuyển tầm trung v&agrave; chỗ ở 4 *', 'Di chuyển v&agrave; chỗ ở 5*', 15, 15, '<ul><li>Ăn sáng</li><li>Ăn tối</li></ul>', '<ul><li>Ăn trưa</li></ul>', '<ul><li>Quạt cầm tay</li><li>Mũ/Nón</li></ul>', '<p><strong>Ngày: Đạo phố cổ</strong></p><p><strong>Tối: Xem kí ức Hội An</strong></p>', 'Có sẵn', '2020-11-11'),
(10, 3, 'Cù Lao Chàm', 'Đảo Cù Lao Chàm', '<p>Đảo Cù Lao Chàm</p>', '(\'laocham.jpg\'),(\'laocham1.jpg\'),(\'laocham3.jpg\')', 1, 0, 600000, 750000, 900000, 'Di chyển và khách sạn bình thường', 'Di chuyển và khách sạn 4*', 'Di chuyển và khách sạn 5*', 12, 15, '<ul><li>Phương tiện di chuyển</li><li>Giá tàu/xe</li><li>Khách sạn</li><li>Ăn sáng</li><li>Hướng dẫn viên</li></ul>', '<ul><li>Ăn trưa</li><li>Ăn tối</li></ul>', '<ul><li>Kem chống nắng</li><li>Mũ/nón</li></ul>', '<p><strong>Ngày 1: </strong>Trên đảo</p>', 'Có sẵn', '2022-10-08'),
(12, 2, 'Hà Nội', 'Hà Nội', '<p>Thủ đô Hà Nội</p>', '(\'hanoi.jpg\'),(\'hanoi1.jpg\'),(\'hanoi2.jpg\')', 1, 1, 1000000, 3000000, 500000, 'Di chyển và khách sạn bình thường', 'Di chuyển và khách sạn 4*\r\n', 'Di chuyển và khách sạn 5*', 20, 50, '<ul><li>Phương tiện di chuyển</li><li>Giá tàu/xe</li><li>Khách sạn</li><li>Ăn sáng</li><li>Hướng dẫn viên</li></ul>', '<ul><li>Ăn trưa</li><li>Ăn tối</li></ul>', '<ul><li>Quạt cầm tay</li><li>Mũ/nón</li><li>Áo dài</li></ul>', '<p><strong>Ngày 1: </strong>Viếng thăm Lăng Bác <br> Ghé thăm các địa điểm nổi tiếng</p><p><strong>Tối 1: </strong>Loanh quanh Thủ đô</p>', 'có sẳn', '2022-10-08');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `package_dates`
--

CREATE TABLE `package_dates` (
  `date_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `agency_id` int(11) NOT NULL,
  `last_date` date NOT NULL,
  `travel_date` date NOT NULL,
  `status` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `package_dates`
--

INSERT INTO `package_dates` (`date_id`, `package_id`, `agency_id`, `last_date`, `travel_date`, `status`, `date`) VALUES
(10, 10, 3, '2022-10-15', '2021-10-22', 'Đang mở', '2022-10-08'),
(11, 3, 3, '2022-10-22', '2022-10-31', 'Đang mở', '2022-10-08'),
(13, 2, 2, '2022-10-20', '2022-10-24', 'Đang mở', '2022-10-08'),
(14, 5, 3, '2022-10-22', '2022-10-31', 'Kéo dài', '2022-10-14'),
(15, 2, 3, '2022-10-12', '2022-10-27', 'Đang mở', '2022-10-10'),
(17, 12, 2, '2022-11-01', '2022-11-05', 'Đang mở\n', '2022-10-23'),
(24, 6, 3, '2022-10-15', '2022-10-22', 'Đang mở', '2022-11-11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `agency_id` int(11) NOT NULL,
  `tourist_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `txn_id` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `card_name` varchar(255) NOT NULL,
  `tour_status` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`payment_id`, `booking_id`, `package_id`, `agency_id`, `tourist_id`, `amount`, `currency`, `txn_id`, `payment_type`, `payment_status`, `card_name`, `tour_status`, `date`) VALUES
(2, 3, 10, 3, 3, 10000000, 'VND', 'txn_1I3zvdFRq96Mv30aZ9otD9An', 'Đầy đủ', 'Thành công', 'Lương Văn Khánh', 'Hoàn thành', '2022-10-10'),
(3, 4, 3, 3, 4, 5000000, 'VND', 'txn_1I40I8FRq96Mv30aZvGqTNpz', 'Đầy đủ', 'Thành công', 'Nguyễn Thị Hòa', 'Hoàn thành', '2022-10-18'),
(4, 5, 5, 3, 10, 25000000, 'VND', 'txn_1I4ODqFRq96Mv30ajYvsOQCn', 'Đầy đủ', 'Thành công', 'Nguyễn Thị Ánh Tuyết', 'Hoàn thành', '2022-10-27'),
(10, 16, 2, 2, 9, 20000000, 'VND', 'txn_1I8qApFRq96Mv30aeuwiPbbv', 'Đầy đủ', 'Thành công', 'Trần Thị Lụa', 'Hoàn thành', '2022-10-22'),
(11, 7, 12, 2, 4, 30000000, 'VND', 'txn_1I8qBCFRq96Mv30aPjYHHkhR', 'Đầy đủ', 'Thành công', 'Nguyễn Thị Hòa', 'Hoàn thành', '2022-11-02'),
(13, 6, 6, 3, 4, 6000000, 'VND', 'txn_1I8qByFRq96Mv30ayobMrIUf', 'Đầy đủ', 'Thành công', 'Nguyễn Thị Hòa', 'Hoàn thành', '2022-10-18'),
(14, 9, 2, 2, 5, 18000000, 'VND', 'txn_1I8qCHFRq96Mv30aGqQwxOhY', 'Đầy đủ', 'Thành công', 'Trần Thị Lụa', 'Hoàn thành', '2022-10-22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `agency_id` int(11) NOT NULL,
  `tourist_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `review_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `review_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`review_id`, `agency_id`, `tourist_id`, `rating`, `comment`, `review_status`, `review_date`) VALUES
(1, 3, 4, 4, '', 'Chưa phê duyệt', '2022-11-02'),
(2, 3, 3, 3, '', 'Đã phê duyệt', '2022-10-27'),
(3, 5, 10, 4, '<p>Dịch vụ và cách phục vụ tốt</p>', 'Đã phê duyệt', '2022-11-25'),
(4, 7, 10, 3, '<p>Tốt</p>', 'Đã phê duyệt', '2022-11-30'),
(5, 2, 9, 2, '<p> Không hài lòng</p>', 'Đã phê duyệt', '2022-11-10'),
(6, 7, 11, 5, '<p>Cảm thấy tốt</p>', 'Đã phê duyệt', '2022-11-16'),
(7, 8, 9, 5, '<p>Tốt</p>', 'Đã phê duyệt', '2022-11-25'),
(8, 6, 5, 4, '<p>Mọi việc đều ổn</p>', 'Đã phê duyệt', '2022-12-01'),
(9, 2, 5, 4, '<p>Cảm thấy rất hài lòng</p>', 'Đã phê duyệt', '2022-12-01'),
(12, 6, 3, 2, '', 'Đã phê duyệt', '2022-12-02'),
(15, 12, 14, 4, '<p>Cách phục vụ tốt</p>', 'Đã phê duyệt', '2022-12-03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tourists`
--

CREATE TABLE `tourists` (
  `tourist_id` int(11) NOT NULL,
  `tourist_username` varchar(255) NOT NULL,
  `tourist_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tourist_email` varchar(255) NOT NULL,
  `tourist_password` varchar(255) NOT NULL,
  `profile_image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tourist_contact` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tourist_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tourist_status` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `tourists`
--

INSERT INTO `tourists` (`tourist_id`, `tourist_username`, `tourist_name`, `tourist_email`, `tourist_password`, `profile_image`, `tourist_contact`, `tourist_address`, `tourist_status`, `date`) VALUES
(3, 'heyboy', 'Lương Văn Kh&aacute;nh', 'Khanh12@gmail.com', '$2y$12$gPy91XrkITrKHlIxwPMFr.O2/DxAomyC3/BSzG7bypCpLEuPZDXKK', '84e3160902f9f7a7aee8.jpg', '0982736452', '222 Hồ Xu&acirc;n Hương', 'approved', '2022-10-12'),
(4, 'Use122', 'Nguyễn Thị Hòa', 'hoa@gmail.com', '$2y$12$Ty275THcKi.louXDelK5ROabmqJLNEO4.PleoJBbgvw8hvJhN3ybu', 'BLACKPINK.png', '0876234622', '444 29 Tháng 3', 'approved', '2022-10-12'),
(5, 'Lizzy110', 'Lý Quỳnh Anh', 'liz@gmail.com', '$2y$12$kvvZXgRBDNPluv6yu.YktufV01Bfd/BD2X7dE2Kl5f6B.bfCYp79y', '1.jpg', '0823567180', '', 'approved', '2022-10-18'),
(8, 'Rin122', 'Nguyễn Anh Bin', 'bin@gmail.com', '$2y$12$pHdgcRSmxJ0ks1pn2AVdneVoSoDx5e5yHEo2X75JZse1W.aSEwfpS', '2.jpg', '0727654195', '', 'approved', '2021-10-27'),
(9, 'Khanhanh', 'Trần Thị Lụa', 'khanh@gmail.com', '$2y$12$sxCd9cnpcZ.llyhVHYPMIuSjRJd3XhZmQPaEfqdNeJgEoSXSJZOpW', '4.jpg', '0236567621', 'Hòa Cường', 'approved', '2021-10-20'),
(10, 'Anhtuyet112', 'Nguyễn Thị Ánh Tuyết', 'tuyet@gmail.com', '$2y$12$up.rkb13MqBRQUyeoMdDUuKzMjHQHthIKt9tA9P5JuKO/QaoutUoG', '5.jpg', '0876756511', '222 Võ An Ninh', 'approved', '2021-11-09'),
(11, 'Hung876', 'Trần Văn Hùng', 'hung@gmail.com', '$2y$12$58StAtIkNWZGduhhEOyWuumnSgKA6x2SeJYmWot0T1szHAcDmdJSm', '6.jpg', '0868654231', '', 'approved', '2022-11-10'),
(12, 'Lethu86986', 'Lê Thị Thanh', 'thanh@gmail.com', '$2y$12$nPNbKXMRdRLw5HFRnMHMmOf/UpIhnBiRjj6fqowmdByWwqN7ixphO', '7.png', '0786786821', '', 'approved', '2021-11-15'),
(14, 'Duyen76', 'Võ Thị Mỹ Duyên', 'duyen@gmail.com', '$2y$12$ATcijkSNj6WYoiSh3h6Roe2vkVqH59JECRRUyt.HnN6ZzDGZwIF8.', '8.jpg', '0871912651', '', 'approved', '2021-11-24'),
(16, 'duyen123', 'Nguyễn Lệ Thu', 'duyenntp15082003@gmail.com', '$2y$12$HRR4mzCgyhJoxaQE3xLeiOMMP6C42Ih2DAABXIqaSvtCQLEh1r6Gm', '00f0bd320480f5deac91.jpg', '0237676252', '101 Lê Thành Nghị', 'approved', '2022-11-19'),
(22, 'admssin@gmail.com', 'Nguyễn Thị Phương Duyên', 'duyensadsantp15082003@gmail.com', '$2y$12$UnjwTQzzOQxCIDW5AB/qA.p703PXJWUWvkGCbwbFgS6iTGvoBkXsm', '', '84234657444', '30 khải tây', 'approved', '2022-11-28'),
(23, 'hey112', 'Nguyễn Thị Dung', 'hey@gmail.com', '$2y$12$L28y/jSZNkt7/U5r9/tBc.iOo9FBe6M.8AFtjze/bdaid4LkUvKdW', 'Nàng Rosé (BLACKPINK) có bộ ảnh đón nắng hè chuẩn mood du lịch, nhìn vào chỉ muốn bỏ lại tất cả phía sau để đi vi vu luôn!.png', '0222222222', '23 Hòa Xuân', 'approved', '2022-11-28');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Chỉ mục cho bảng `agencies`
--
ALTER TABLE `agencies`
  ADD PRIMARY KEY (`agency_id`);

--
-- Chỉ mục cho bảng `agency_employees`
--
ALTER TABLE `agency_employees`
  ADD PRIMARY KEY (`employee_id`),
  ADD KEY `agency_employees_ibfk_1` (`agency_id`);

--
-- Chỉ mục cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `package_id` (`package_id`),
  ADD KEY `tourist_id` (`tourist_id`),
  ADD KEY `agency_id` (`agency_id`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `tourist_id` (`tourist_id`),
  ADD KEY `package_id` (`package_id`),
  ADD KEY `agency_id` (`agency_id`);

--
-- Chỉ mục cho bảng `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`package_id`),
  ADD KEY `agency_id` (`agency_id`);

--
-- Chỉ mục cho bảng `package_dates`
--
ALTER TABLE `package_dates`
  ADD PRIMARY KEY (`date_id`),
  ADD KEY `package_id` (`package_id`),
  ADD KEY `agency_id` (`agency_id`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `package_id` (`package_id`),
  ADD KEY `agency_id` (`agency_id`),
  ADD KEY `tourist_id` (`tourist_id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `agency_id` (`agency_id`),
  ADD KEY `tourist_id` (`tourist_id`);

--
-- Chỉ mục cho bảng `tourists`
--
ALTER TABLE `tourists`
  ADD PRIMARY KEY (`tourist_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `agencies`
--
ALTER TABLE `agencies`
  MODIFY `agency_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `agency_employees`
--
ALTER TABLE `agency_employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `packages`
--
ALTER TABLE `packages`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `package_dates`
--
ALTER TABLE `package_dates`
  MODIFY `date_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `tourists`
--
ALTER TABLE `tourists`
  MODIFY `tourist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `agency_employees`
--
ALTER TABLE `agency_employees`
  ADD CONSTRAINT `agency_employees_ibfk_1` FOREIGN KEY (`agency_id`) REFERENCES `agencies` (`agency_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `packages` (`package_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`tourist_id`) REFERENCES `tourists` (`tourist_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`agency_id`) REFERENCES `agencies` (`agency_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`tourist_id`) REFERENCES `tourists` (`tourist_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `packages` (`package_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`agency_id`) REFERENCES `agencies` (`agency_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `packages`
--
ALTER TABLE `packages`
  ADD CONSTRAINT `packages_ibfk_1` FOREIGN KEY (`agency_id`) REFERENCES `agencies` (`agency_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `package_dates`
--
ALTER TABLE `package_dates`
  ADD CONSTRAINT `package_dates_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `packages` (`package_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `package_dates_ibfk_2` FOREIGN KEY (`agency_id`) REFERENCES `agencies` (`agency_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `packages` (`package_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_3` FOREIGN KEY (`agency_id`) REFERENCES `agencies` (`agency_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_4` FOREIGN KEY (`tourist_id`) REFERENCES `tourists` (`tourist_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`agency_id`) REFERENCES `agencies` (`agency_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`tourist_id`) REFERENCES `tourists` (`tourist_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
