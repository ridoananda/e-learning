-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2020 at 08:52 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yapim_marelan`
--

-- --------------------------------------------------------

--
-- Table structure for table `absen`
--

CREATE TABLE `absen` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `mapel_id` int(100) NOT NULL,
  `mapel` varchar(100) NOT NULL,
  `expired` int(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `kategori_id` int(255) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `aktif` int(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_absen`
--

CREATE TABLE `data_absen` (
  `id` int(255) NOT NULL,
  `absen_id` int(255) NOT NULL,
  `user_id` int(155) NOT NULL,
  `mapel` varchar(100) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `alasan` text NOT NULL,
  `is_absen` int(1) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_tugas`
--

CREATE TABLE `data_tugas` (
  `id` int(255) NOT NULL,
  `tugas_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `is_kumpul` int(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `file_tugas`
--

CREATE TABLE `file_tugas` (
  `id` int(255) NOT NULL,
  `tugas_id` int(255) DEFAULT NULL,
  `data_tugas_id` int(255) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `ext` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hubungi`
--

CREATE TABLE `hubungi` (
  `id` int(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pesan` text NOT NULL,
  `ip_address` int(100) NOT NULL,
  `user_agent` varchar(100) NOT NULL,
  `created_at` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_artikel`
--

CREATE TABLE `kategori_artikel` (
  `id` int(25) NOT NULL,
  `user_id` int(255) NOT NULL,
  `kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `komentar_artikel`
--

CREATE TABLE `komentar_artikel` (
  `id` int(255) NOT NULL,
  `artikel_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `text` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `komentar_tugas`
--

CREATE TABLE `komentar_tugas` (
  `id` int(255) NOT NULL,
  `tugas_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `komentar` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `user_lapor_id` int(255) NOT NULL,
  `alasan` text NOT NULL,
  `created_at` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `url` varchar(100) NOT NULL,
  `text` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `is_cek` int(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tugas`
--

CREATE TABLE `tugas` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `mapel_id` int(255) NOT NULL,
  `mapel` varchar(100) NOT NULL,
  `kelas` varchar(255) NOT NULL,
  `jurusan` varchar(255) NOT NULL,
  `judul` text NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `ditugaskan` int(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `cookie` varchar(100) NOT NULL,
  `role_id` int(100) NOT NULL,
  `mapel_id` int(100) NOT NULL,
  `is_active` int(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama_lengkap`, `slug`, `alamat`, `foto`, `email`, `password`, `cookie`, `role_id`, `mapel_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', 'admin', 'default.jpg', 'admin@gmail.com', '$2y$10$YjQLZPqQHMaaveDdGuMFxec9NFqkUxUYPNE8IFazsnDx1XtxO6MKS', '73e46191910d94b3407fd3ccd1ebd1067fb327f63120314887744da95cdd3439', 1, 0, 1, '2020-12-18 07:46:11', '2020-12-18 07:22:22'),
(2, 'Rido Ananda', 'rido-ananda', 'Jln marelan 1 pasar 4 barat gg.biarkan', 'default.jpg', 'ridoananda123@gmail.com', '$2y$10$1CKY00eu6NKOG/qUs0JVSOXLXvIroEZ3bdavJD1YM8EOm9duXuoIC', 'c2c25c8d5819f481f15ea43ca0dffbc218577a6f7b2d3f451cb8751ffcf4193f', 3, 2, 1, '2020-12-18 07:46:45', '2020-12-18 07:46:45'),
(3, 'Rido Ananda', 'rido-ananda', 'Jalan Marelan 1 pasar 4 barat Gg. biarkan', 'default.jpg', 'guru@gmail.com', '$2y$10$wzscg4fZid8fNkR3u2ivMOJW7wP1FDJ/sp2byPMhAwkJOUlIsxCbi', 'e2979fa6cc0069be68136033a0fec629cf64166156f0e9b9347e4f01dfbabcde', 2, 1, 1, '2020-12-18 07:48:22', '2020-12-18 07:48:22');

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(100) NOT NULL,
  `role_id` int(100) NOT NULL,
  `menu_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(2, 2, 2),
(3, 3, 3),
(5, 1, 1),
(6, 1, 4),
(7, 1, 5),
(10, 1, 6),
(11, 3, 6),
(12, 2, 6),
(13, 1, 7),
(14, 2, 7),
(15, 3, 7);

-- --------------------------------------------------------

--
-- Table structure for table `user_mapel`
--

CREATE TABLE `user_mapel` (
  `id` int(255) NOT NULL,
  `user_role` int(100) NOT NULL,
  `mapel` varchar(100) DEFAULT NULL,
  `kelas` varchar(100) DEFAULT NULL,
  `jurusan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_mapel`
--

INSERT INTO `user_mapel` (`id`, `user_role`, `mapel`, `kelas`, `jurusan`) VALUES
(1, 2, 'Kimia', NULL, NULL),
(2, 3, NULL, 'XII', 'SMA'),
(3, 2, 'Bahasa Inggris', NULL, NULL),
(4, 3, NULL, 'XI', 'SMA'),
(5, 3, NULL, 'X', 'SMA'),
(6, 3, NULL, 'X', 'TKJ-1'),
(7, 3, NULL, 'X', 'TKJ-2'),
(8, 2, 'Matematika', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(100) NOT NULL,
  `menu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Admin'),
(2, 'Guru'),
(3, 'Siswa'),
(4, 'Menu'),
(5, 'Data'),
(6, 'Profil');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'Guru'),
(3, 'Siswa'),
(4, 'Tata Usaha');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(255) NOT NULL,
  `menu_id` int(255) NOT NULL,
  `title` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'Dashboard', 'admin', 'fas fa-fw fa-tachometer-alt', 1),
(2, 4, 'Menu Management', 'menu', 'fas fa-fw fa-folder', 1),
(3, 4, 'Sub Menu Management', 'menu/submenu', 'far fa-fw fa-folder-open', 1),
(4, 1, 'Role', 'admin/role', 'fas fa-fw fa-user-tie', 1),
(5, 2, 'Halaman Utama', 'guru', 'fas fa-fw fa-home', 1),
(6, 2, 'Tugas Kelas', 'guru/tugas', 'fas fa-fw fa-clipboard-list', 1),
(8, 3, 'Halaman Utama', 'siswa', 'fas fa-fw fa-home', 1),
(9, 3, 'Forum Tugas', 'siswa/forum-tugas', 'fas fa-fw fa-comments', 1),
(10, 6, 'Profil Saya', 'profil', 'fas fa-fw fa-user', 1),
(11, 6, 'Edit Profil', 'profil/edit', 'fas fa-fw fa-user-edit', 1),
(12, 6, 'Ubah Password', 'profil/ubah-password', 'fas fa-fw fa-user-lock', 1),
(13, 6, 'Log Aktivitas', 'profil/log-aktivitas', 'fas fa-fw fa-user-clock', 1),
(14, 3, 'Absen Kelas', 'siswa/absen', 'fas fa-fw fa-calendar-check', 1),
(15, 2, 'Absen Kelas', 'guru/absen', 'fas fa-fw fa-calendar-check', 1),
(16, 1, 'User Mapel', 'admin/mapel', 'fas fa-fw fa-user-graduate', 1),
(17, 5, 'Guru', 'data', 'fas fa-fw fa-user-graduate', 1),
(18, 5, 'Siswa', 'data/siswa', 'fas fa-fw fa-user', 1),
(19, 2, 'Artikel', 'guru/artikel', 'far fa-fw fa-list-alt', 1),
(21, 5, 'Artikel', 'data/artikel', 'far fa-fw fa-list-alt', 1),
(22, 1, 'Laporan', 'admin/laporan', 'fas fa-exclamation fa-fw', 1),
(23, 1, 'Hubungi', 'admin/hubungi', 'fas fa-fw fa-phone', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absen`
--
ALTER TABLE `absen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_absen`
--
ALTER TABLE `data_absen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_tugas`
--
ALTER TABLE `data_tugas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `file_tugas`
--
ALTER TABLE `file_tugas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hubungi`
--
ALTER TABLE `hubungi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_artikel`
--
ALTER TABLE `kategori_artikel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `komentar_artikel`
--
ALTER TABLE `komentar_artikel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `komentar_tugas`
--
ALTER TABLE `komentar_tugas`
  ADD PRIMARY KEY (`id`,`tugas_id`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_mapel`
--
ALTER TABLE `user_mapel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absen`
--
ALTER TABLE `absen`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_absen`
--
ALTER TABLE `data_absen`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_tugas`
--
ALTER TABLE `data_tugas`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file_tugas`
--
ALTER TABLE `file_tugas`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hubungi`
--
ALTER TABLE `hubungi`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori_artikel`
--
ALTER TABLE `kategori_artikel`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `komentar_artikel`
--
ALTER TABLE `komentar_artikel`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `komentar_tugas`
--
ALTER TABLE `komentar_tugas`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_mapel`
--
ALTER TABLE `user_mapel`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
