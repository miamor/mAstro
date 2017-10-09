-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 21, 2016 at 05:12 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mcode`
--

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE `forum` (
  `id` int(11) NOT NULL,
  `show` int(1) NOT NULL DEFAULT '1',
  `pos` int(10) NOT NULL,
  `title` varchar(256) NOT NULL,
  `link` varchar(1000) NOT NULL,
  `icon` varchar(1000) NOT NULL,
  `content` longtext NOT NULL,
  `fid` int(255) NOT NULL COMMENT 'Parent forum id',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `forum`
--

INSERT INTO `forum` (`id`, `show`, `pos`, `title`, `link`, `icon`, `content`, `fid`, `created`, `modified`) VALUES
(1, 1, 0, 'Thông báo', 'thong-bao', 'http://localhost/mCode/assets/dist/img/forum/announce.png', 'Cập nhật những Thông Báo mới nhất từ BQT diễn đàn.', 3, '2014-06-01 00:35:07', '2014-05-31 13:34:33'),
(2, 1, 0, 'Cuộc thi', 'cuoc-thi', 'http://localhost/mCode/assets/dist/img/forum/feedback.png', 'Nơi đón nhận tất cả các ý kiến đóng góp và trả lời mọi thắc mắc, yêu cầu trong khả năng có thể, kiêm luôn nhiệm vụ hoà giải hay xử lý xích mích nhỏ to liên quan đến hoạt động của thành viên trong diễn đàn.', 3, '2014-06-01 00:35:07', '2014-05-31 13:34:33'),
(3, 1, 0, 'Thông tin chung', 'thong-tin-chung', '', '', 0, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(4, 0, 2, 'Lập trình C/C++', 'lap-trinh-c-c++', '', '', 0, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(5, 0, 0, 'Hướng dẫn, thủ thuật, giải thuật', 'huong-dan-thu-thuat-giai-thuat', '', 'Thủ thuật, kinh nghiệm, các bài viết về thuật toán và thuật giải !', 4, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(6, 0, 0, 'Thắc mắc lập trình C/C++', 'thac-mac-c-c++', '', 'Diễn đàn để bạn chia sẻ và thảo luận về Lập trình C, Lập trình C++, Lập trình C++0x. Các vấn đề và rắc rối của Lập trình C, Lập trình C++, Lập trình C++0x nói chung.', 4, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(7, 0, 0, 'Tài liệu C/C++', 'tai-lieu-ebook-c-c++', '', '', 44, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(8, 0, 0, 'Lập trình Java', 'lap-trinh-java', '', '', 47, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(9, 0, 0, 'Hướng dẫn, thủ thuật', 'huong-dan-thu-thuat-java', '', '', 8, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(10, 0, 0, 'Thắc mắc lập trình Java', 'thac-mac-java', '', '', 8, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(11, 0, 0, 'Java', 'du-an-source-code-java', '', '', 48, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(12, 0, 0, 'Tài liệu Java', 'tai-lieu-ebook-java', '', '', 44, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(13, 0, 4, 'Lập trình Web', 'lap-trinh-web', '', '', 0, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(14, 0, 0, 'Lập trình Php', 'lap-trinh-php', '', '', 13, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(15, 0, 0, 'Hướng dẫn, thủ thuật', 'huong-dan-thu-thuat-php', '', '', 14, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(16, 0, 0, 'Thắc mắc lập trình php', 'thac-mac-php', '', '', 14, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(17, 0, 0, 'Php', 'du-an-source-code-php', '', '', 48, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(18, 0, 0, 'Tài liệu Php', 'tai-lieu-ebook-php', '', '', 44, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(19, 0, 0, 'Lập trình NodeJS', 'lap-trinh-nodejs', '', '', 13, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(20, 0, 0, 'Hướng dẫn, thủ thuật', 'huong-dan-thu-thuat-nodejs', '', '', 19, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(21, 0, 0, 'Thắc mắc lập trình NodeJS', 'thac-mac-nodejs', '', '', 19, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(22, 0, 0, 'NodeJS', 'du-an-source-code-nodejs', '', '', 48, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(23, 0, 0, 'Tài liệu NodeJS', 'tai-lieu-ebook-nodejs', '', '', 44, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(24, 0, 0, 'Khác', 'lap-trinh-web-khac', '', '', 13, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(25, 0, 0, 'Javascript', 'javascript', '', '', 24, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(26, 0, 0, 'HTML&CSS', 'html-css', '', '', 24, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(27, 0, 5, 'Lập trình Game', 'lap-trinh-game', '', '', 0, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(28, 0, 0, 'Engine', 'engine', '', '', 27, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(29, 0, 0, 'Construct 2', 'construct-2', '', '', 28, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(30, 0, 0, 'Framework', 'framework', '', '', 27, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(31, 0, 0, 'Phaser', 'phaser', '', '', 30, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(32, 0, 0, 'Lập trình ứng dụng di động', 'lap-trinh-ung-dung-di-dong', '', '', 47, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(33, 0, 0, 'Android', 'android', '', '', 32, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(34, 0, 0, 'Windows Phone', 'windows-phone', '', '', 32, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(35, 0, 0, 'iOS', 'ios', '', '', 32, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(36, 0, 8, 'Mạng máy tính', 'mang-may-tinh', '', '', 0, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(37, 0, 0, 'Mạng căn bản', 'mang-can-ban', '', '', 36, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(38, 0, 0, 'Quản trị mạng Linux', 'quan-tri-mang-linux', '', '', 36, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(39, 0, 0, 'Quản trị mạng Windows', 'quan-tri-mang-windows', '', '', 36, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(40, 0, 0, 'Hacking - Bảo mật', 'hacking-bao-mat', '', '', 36, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(41, 0, 0, 'Hacking', 'hacking', '', '', 40, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(42, 0, 0, 'Bảo mật', 'bao-mat', '', '', 40, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(43, 0, 1, 'Tài nguyên', 'tai-nguyen', '', '', 0, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(44, 0, 0, 'Tài liệu, ebook', 'tai-lieu-ebook', '', 'Thư viện tài liệu, ebook, giáo trình, bài giảng về nghành CNTT', 43, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(45, 0, 0, 'Tài liệu mạng máy tính', 'tai-lieu-mang-may-tinh', '', '', 44, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(46, 0, 0, 'Hacking, bảo mật', 'tai-lieu-hacking-bao-mat', '', '', 44, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(47, 0, 3, 'Lập trình ứng dụng', 'lap-trinh-ung-dung', '', '', 0, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(48, 0, 0, 'Dự án, source code', 'du-an-source-code', 'Nơi chia sẻ các bộ mã nguồn đã được xây dựng hoàn chỉnh hoặc chưa hoàn chỉnh nhưng có thể tạm sử dụng được.', '', 43, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(49, 0, 0, 'Đồ án, luận văn, seminar', 'do-an-luan-van-seminar', '', 'Chỉ post những đồ án, bài tập lớn, tiểu luận, luận văn về công nghệ thông tin đã có file báo cáo hoặc Slide Seminar về CNTT.', 43, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(50, 0, 0, 'Game', 'du-an-source-code-game', '', '', 48, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(51, 0, 8, 'Câu lạc bộ, hội nhóm', 'cau-lac-bo-hoi-nhom', '', '', 0, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(52, 1, 0, 'Đề thi, đáp án', 'de-thi-dap-an', '', '', 43, '2014-06-01 00:35:07', '2014-05-31 13:34:54'),
(53, 1, 10, 'Web programming', 'w', '', '', 0, '2014-06-01 00:35:07', '2016-09-19 15:56:31'),
(54, 1, 10, 'C++', 'c', '', '', 0, '2014-06-01 00:35:07', '2016-09-19 15:56:49'),
(55, 1, 10, 'Java', 'j', '', '', 0, '2014-06-01 00:35:07', '2016-09-19 15:57:03'),
(56, 1, 10, 'Hacking - Security', 'h', '', '', 0, '2014-06-01 00:35:07', '2016-09-19 15:57:19'),
(57, 1, 18, 'Capture the flag', 'ctf', '', '', 0, '2014-06-01 00:35:07', '2016-09-19 15:57:19'),
(58, 1, 20, 'Web exploit', 'ctf-web', '', '', 57, '2014-06-01 00:35:07', '2016-09-19 15:57:19'),
(59, 1, 200, 'Crypto', 'ctf-crypto', '', '', 57, '2014-06-01 00:35:07', '2016-09-19 15:57:19'),
(60, 1, 20, 'Reverse Engineering', 'ctf-re', '', '', 57, '2014-06-01 00:35:07', '2016-09-19 15:57:19'),
(61, 1, 20, 'Forensic', 'ctf-forensic', '', '', 57, '2014-06-01 00:35:07', '2016-09-19 15:57:19'),
(62, 1, 20, 'Softcon', 'softcon', '', '', 0, '2014-06-01 00:35:07', '2016-09-19 15:57:19'),
(63, 1, 19, '[Write up] CTF', 'write-up-ctf', '', '', 0, '2016-09-19 22:57:19', '2016-09-19 15:57:19'),
(64, 1, 19, 'ringzer0', 'ringzer0', '', '', 63, '2016-09-19 22:57:19', '2016-09-19 15:57:19'),
(65, 1, 19, 'pico', 'pico', '', '', 63, '2016-09-19 22:57:19', '2016-09-19 15:57:19'),
(66, 1, 19, 'natas', 'natas', '', '', 63, '2016-09-19 22:57:19', '2016-09-19 15:57:19'),
(67, 1, 19, 'root-me', 'root-me', '', '', 63, '2016-09-19 22:57:19', '2016-09-19 15:57:19'),
(68, 1, 19, 'ctftime', 'ctftime', '', '', 63, '2016-09-19 22:57:19', '2016-09-19 15:57:19'),
(69, 1, 19, 'defcon', 'defcon', '', '', 63, '2016-09-19 22:57:19', '2016-09-19 15:57:19'),
(70, 1, 10, 'Machine learning', 'ml', '', '', 0, '2016-09-19 22:56:31', '2016-09-19 15:56:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `forum`
--
ALTER TABLE `forum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
