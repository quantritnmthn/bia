-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 22, 2025 lúc 12:45 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `bia`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `billiards_data`
--

CREATE TABLE `billiards_data` (
  `id` int(11) NOT NULL,
  `data_json` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `billiards_data`
--

INSERT INTO `billiards_data` (`id`, `data_json`) VALUES
(1, '{\"players\":[{\"name\":\"Hoàng\",\"scores\":[\"5\",\"6\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]},{\"name\":\"Dương\",\"scores\":[\"3u\",\"3\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]},{\"name\":\"Minh\",\"scores\":[\"4\",\"3u\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]}],\"settings\":{\"money\":\"0\",\"splitCount\":\"2\",\"gameCount\":20,\"gameTimestamps\":{\"game_1\":{\"start\":\"2025-10-20T10:07:11.984Z\",\"end\":\"2025-10-20T10:07:15.899Z\"},\"game_2\":{\"start\":\"2025-10-20T10:07:15.899Z\",\"end\":\"2025-10-20T10:10:48.450Z\"},\"game_3\":{\"start\":\"2025-10-20T10:10:48.450Z\"}}}}');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `billiards_deals`
--

CREATE TABLE `billiards_deals` (
  `id` int(11) NOT NULL,
  `player_name` varchar(255) NOT NULL,
  `cards` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `billiards_deals`
--

INSERT INTO `billiards_deals` (`id`, `player_name`, `cards`) VALUES
(1, 'HAND_Hoàng', ''),
(2, 'HAND_Dương', ''),
(3, 'HAND_Minh', ''),
(4, 'BaiTrenNoc', ''),
(5, 'AN_Hoàng', 'AT,2B,5C,5T,KC,KB'),
(6, 'AN_Dương', '3C,7R,JC,JB,JT,QR,QB'),
(7, 'AN_Minh', '4R,6C,6T,8R,8C,9B,9T,10C'),
(8, 'THOI_Hoàng', '6B,7C,8B,QC'),
(9, 'THOI_Dương', '4C,4T,9C'),
(10, 'THOI_Minh', '3T,QT'),
(11, 'NOC_Hoàng', ''),
(12, 'NOC_Dương', ''),
(13, 'NOC_Minh', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `billiards_users`
--

CREATE TABLE `billiards_users` (
  `id` int(11) NOT NULL,
  `Ten` varchar(1000) NOT NULL,
  `Pass` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `billiards_users`
--

INSERT INTO `billiards_users` (`id`, `Ten`, `Pass`) VALUES
(1, 'Dương', '123'),
(2, 'Hoàng', '123'),
(3, 'Ninh', '123'),
(4, 'Khánh', '123'),
(5, 'Bản', '123'),
(6, 'Giáp', '123'),
(7, 'Hoàng Anh', '123'),
(8, 'Giang', '123'),
(9, 'Long', '123'),
(10, 'Minh', '123');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `billiards_deals`
--
ALTER TABLE `billiards_deals`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `billiards_users`
--
ALTER TABLE `billiards_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `billiards_deals`
--
ALTER TABLE `billiards_deals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `billiards_users`
--
ALTER TABLE `billiards_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
