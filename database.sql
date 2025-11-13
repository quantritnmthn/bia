-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 12, 2025 lúc 07:54 AM
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
(1, '{\"players\":[{\"name\":\"Hoàng\",\"scores\":[\"10m\",\"4\",\"10m\",\"3\",\"4\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"],\"bi\":[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]},{\"name\":\"Dương\",\"scores\":[\"1\",\"3u\",\"9u\",\"4\",\"5\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"],\"bi\":[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]},{\"name\":\"Ninh\",\"scores\":[\"10m\",\"5\",\"10m\",\"5u\",\"6u\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"],\"bi\":[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]}],\"maxGames\":30,\"gameName\":\"Hoàng,Dương,Ninh\",\"settings\":{\"money\":\"0\",\"splitCount\":\"2\",\"gameCount\":30,\"gameTimestamps\":{\"game_1\":{\"start\":\"2025-11-05T01:15:58.177Z\",\"end\":\"2025-11-05T01:17:20.928Z\"},\"game_2\":{\"start\":\"2025-11-05T01:17:20.928Z\",\"end\":\"2025-11-05T01:18:38.015Z\"},\"game_3\":{\"start\":\"2025-11-05T01:18:38.015Z\",\"end\":\"2025-11-05T01:18:54.215Z\"},\"game_4\":{\"start\":\"2025-11-05T01:18:54.215Z\",\"end\":\"2025-11-05T01:19:40.735Z\"},\"game_5\":{\"start\":\"2025-11-05T01:19:40.735Z\",\"end\":\"2025-11-05T01:46:25.553Z\"}},\"rankCountsByPlayer\":[],\"soCayMoiNguoi\":\"10\",\"ban\":\"1\"},\"timestamp\":\"2025-11-12T06:42:35.672Z\"}');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `billiards_deals`
--

CREATE TABLE `billiards_deals` (
  `id` int(11) NOT NULL,
  `player_name` varchar(255) NOT NULL,
  `cards` text NOT NULL,
  `ban` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `billiards_deals`
--

INSERT INTO `billiards_deals` (`id`, `player_name`, `cards`, `ban`) VALUES
(1, 'HAND_Hoàng', 'AC,2C,5C,8R,JR,JB,JT,QC', NULL),
(2, 'HAND_Dương', '2B,2T,4C,QR', NULL),
(3, 'HAND_Ninh', '3T,5B,5T,JC,QB', NULL),
(4, 'BaiTrenNoc', 'AR,AB,AT,2R,3R,3C,3B,4R,4B,4T,5R,8C,8B,8T,QT', NULL),
(5, 'ThoiGian', '', NULL),
(6, 'NguoiVuaHaBai', 'Dương', NULL),
(7, 'ThuTuChoi', 'Ninh phá bi > Hoàng > Dương', NULL),
(8, 'AN_Hoàng', '', NULL),
(9, 'AN_Dương', '6B,7B,7T,9R,10B,KR', NULL),
(10, 'AN_Ninh', '', NULL),
(11, 'THOI_Hoàng', '6T,9T', NULL),
(12, 'THOI_Dương', '', NULL),
(13, 'THOI_Ninh', '6R,9B,10R,10C,KT', NULL),
(14, 'NOC_Hoàng', '', NULL),
(15, 'NOC_Dương', '', NULL),
(16, 'NOC_Ninh', '', NULL),
(17, 'ANBI_Hoàng', '', NULL),
(18, 'ANBI_Dương', '6,7,9,10,K', NULL),
(19, 'ANBI_Ninh', '', NULL),
(58, 'HAND_Hoàng', '5R,6R,8B,9R,9C,10C,JB,JT,KR,KB', 1),
(59, 'HAND_Dương', 'AR,2R,4B,5C,5B,8R,8C,9T,10T,QT', 1),
(60, 'HAND_Ninh', '2T,4R,5T,6B,7R,7B,7T,8T,9B,10R', 1),
(61, 'BaiTrenNoc', 'QR,4T,10B,AB,6T,JC,2C,3B,6C,AT,QC,KC,AC,3T,QB,3C,2B,KT,4C,3R,JR,7C', 1),
(62, 'ThoiGian', '0', 1),
(63, 'NguoiVuaHaBai', '', 1),
(64, 'ThuTuChoi', '', 1),
(65, 'AN_Hoàng', '', 1),
(66, 'AN_Dương', '', 1),
(67, 'AN_Ninh', '', 1),
(68, 'THOI_Hoàng', '', 1),
(69, 'THOI_Dương', '', 1),
(70, 'THOI_Ninh', '', 1),
(71, 'NOC_Hoàng', '', 1),
(72, 'NOC_Dương', '', 1),
(73, 'NOC_Ninh', '', 1),
(74, 'ANBI_Hoàng', '', 1),
(75, 'ANBI_Dương', '', 1),
(76, 'ANBI_Ninh', '', 1);

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
(5, 'Hoàng Anh', '123'),
(6, 'Minh', '123'),
(7, 'Giang', '123'),
(8, 'Giáp', '123'),
(9, 'Bản', '123'),
(10, 'Long', '123');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT cho bảng `billiards_users`
--
ALTER TABLE `billiards_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
