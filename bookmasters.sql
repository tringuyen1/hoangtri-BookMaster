-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 28, 2021 lúc 12:24 PM
-- Phiên bản máy phục vụ: 10.4.19-MariaDB
-- Phiên bản PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `mt_book`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookmasters`
--

CREATE TABLE `bookmasters` (
  `id` varchar(4) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `book_title` varchar(40) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `author_name` varchar(40) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `publisher` varchar(40) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `publication_day` date DEFAULT NULL,
  `insert_day` timestamp NULL DEFAULT NULL,
  `update_day` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `bookmasters`
--

INSERT INTO `bookmasters` (`id`, `book_title`, `author_name`, `publisher`, `publication_day`, `insert_day`, `update_day`) VALUES
('B001', 'Sông Hương', 'Tố Hữu', 'Việt Nam', '2002-03-04', '2021-12-27 17:00:00', '2021-12-27 17:00:00'),
('B002', 'Đà Lạt', 'Xuân Quỳnh', 'Việt Nam', '2020-03-04', '2021-12-27 17:00:00', '2021-12-27 17:00:00'),
('B003', 'Đà Lạt', 'Xuân Quỳnh', 'Việt Nam', '2020-03-04', '2021-12-27 17:00:00', NULL),
('B004', 'Vợ Nhặt', 'Tố Hữu', 'Việt Nam', '2002-03-04', '2021-12-27 17:00:00', '2021-12-27 17:00:00');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bookmasters`
--
ALTER TABLE `bookmasters`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
