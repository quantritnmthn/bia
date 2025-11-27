-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 26, 2025 lúc 01:15 PM
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
(1, '{\"players\":[{\"name\":\"Hoàng\",\"scores\":[\"3\",\"4\",\"10m\",\"3\",\"4\",\"6\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"],\"bi\":[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]},{\"name\":\"Dương\",\"scores\":[\"1\",\"3u\",\"9u\",\"4\",\"5\",\"4\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"],\"bi\":[\"\",\"\",\"\",\"\",\"\",\"A,3,4,5,6,7,9,10,Q,K\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]},{\"name\":\"Ninh\",\"scores\":[\"4\",\"2\",\"6\",\"5u\",\"6u\",\"8\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"],\"bi\":[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]},{\"name\":\"Bản\",\"scores\":[\"5u\",\"3\",\"1\",\"4\",\"6\",\"10m\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"],\"bi\":[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]},{\"name\":\"Giang\",\"scores\":[\"6\",\"1\",\"6\",\"2\",\"5\",\"4u\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"],\"bi\":[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]}],\"maxGames\":31,\"gameName\":\"Hoàng,Dương,Ninh,Bản,Giang\",\"settings\":{\"money\":\"100000\",\"splitCount\":\"3\",\"gameCount\":31,\"gameTimestamps\":{\"game_1\":{\"start\":\"2025-11-05T01:15:58.177Z\",\"end\":\"2025-11-05T01:17:20.928Z\"},\"game_2\":{\"start\":\"2025-11-05T01:17:20.928Z\",\"end\":\"2025-11-05T01:18:38.015Z\"},\"game_3\":{\"start\":\"2025-11-05T01:18:38.015Z\",\"end\":\"2025-11-05T01:18:54.215Z\"},\"game_4\":{\"start\":\"2025-11-05T01:18:54.215Z\",\"end\":\"2025-11-05T01:19:40.735Z\"},\"game_5\":{\"start\":\"2025-11-05T01:19:40.735Z\",\"end\":\"2025-11-05T01:46:25.553Z\"},\"game_6\":{\"start\":\"2025-11-05T01:46:25.553Z\",\"end\":\"2025-11-12T07:23:50.043Z\"}},\"rankCountsByPlayer\":[],\"soCayMoiNguoi\":\"10\",\"ban\":\"1\"},\"timestamp\":\"2025-11-21T08:00:02.696Z\"}');

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
(1, 'HAND_Hoàng', '4C,6B,7R,8B,9R,10C,10B,JR,KC', 1),
(2, 'HAND_Dương', '4R,4T,5B,6R,7T,8T,9B,10R,JT,QR,KR', 1),
(3, 'HAND_Ninh', '4B,5R,5T,6C,7C,7B,8C', 1),
(4, 'BaiTrenNoc', '5C,6T,8R,9C,9T,10T,JC,JB,QC,QB,QT,KB,KT', 1),
(5, 'ThoiGian', '', 1),
(6, 'NguoiVuaHaBai', 'Dương', 1),
(7, 'ThuTuChoi', 'Giang phá bi > Dương > Hoàng > Ninh > Bản', 1),
(8, 'AN_Hoàng', '', 1),
(9, 'AN_Dương', 'AC,2B,3T', 1),
(10, 'AN_Ninh', '', 1),
(11, 'THOI_Hoàng', '2C', 1),
(12, 'THOI_Dương', '', 1),
(13, 'THOI_Ninh', 'AR,2T,3R', 1),
(14, 'NOC_Hoàng', '', 1),
(15, 'NOC_Dương', '2B,3T,8T,JT', 1),
(16, 'NOC_Ninh', '', 1),
(17, 'ANBI_Hoàng', '', 1),
(18, 'ANBI_Dương', 'A,2,3', 1),
(19, 'ANBI_Ninh', '', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `billiards_users`
--

CREATE TABLE `billiards_users` (
  `id` int(11) NOT NULL,
  `Ten` varchar(1000) NOT NULL,
  `Pass` varchar(1000) DEFAULT NULL,
  `bank` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `billiards_users`
--

INSERT INTO `billiards_users` (`id`, `Ten`, `Pass`, `bank`) VALUES
(1, 'Dương', '26062018', 'https://api.vietqr.io/image/970436-0011001423572-x2hNh6A.jpg?accountName=NGUYEN%20TUAN%20DUONG&amount=SOTIEN&addInfo=Chia%20tien%20Bi%20A'),
(2, 'Hoàng', '111', 'https://api.vietqr.io/image/970418-15110000430704-x2hNh6A.jpg?accountName=NGUYEN%20ANH%20HOANG&amount=SOTIEN&addInfo=Chia%20tien%20Bi%20A'),
(3, 'Ninh', '123', 'https://api.vietqr.io/image/970407-84333333-x2hNh6A.jpg?accountName=NGUYEN%20HUY%20NINH&amount=SOTIEN&addInfo=Chia%20tien%20Bi%20A'),
(4, 'Khánh', '123', 'https://api.vietqr.io/image/970436-0591000274808-x2hNh6A.jpg?accountName=PHAM%20QUANG%20KHANH&amount=SOTIEN&addInfo=Chia%20tien%20Bi%20A'),
(5, 'Minh', '123', 'https://api.vietqr.io/image/970436-0591000392200-x2hNh6A.jpg?accountName=TRUONG%20VAN%20MINH&amount=SOTIEN&addInfo=Chia%20tien%20Bi%20A'),
(6, 'Hoàng Anh', '123654', 'https://api.vietqr.io/image/970422-0912061855-x2hNh6A.jpg?accountName=DO%20HOANG%20ANH&amount=SOTIEN&addInfo=Chia%20tien%20Bi%20A'),
(7, 'Bản', '123', 'https://api.vietqr.io/image/970403-848488888-x2hNh6A.jpg?accountName=NGUYEN%20DANG%20BAN&amount=SOTIEN&addInfo=Chia%20tien%20Bi%20A'),
(8, 'Giang', '123', 'https://api.vietqr.io/image/970436-0591000363267-x2hNh6A.jpg?accountName=PHAM%20HOANG%20GIANG&amount=SOTIEN&addInfo=Chia%20tien%20Bi%20A'),
(9, 'Giáp', '123', 'https://api.vietqr.io/image/970418-2152911705-x2hNh6A.jpg?accountName=NGUYEN%20THE%20HOAN&amount=SOTIEN&addInfo=Chia%20tien%20Bi%20A'),
(10, 'Long', '123', NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `billiards_users`
--
ALTER TABLE `billiards_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
