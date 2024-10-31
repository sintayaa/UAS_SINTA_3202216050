-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 31 Okt 2024 pada 02.18
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uas_sinta`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `artikel`
--

CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `penulis` varchar(45) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `read_count` int(11) DEFAULT NULL,
  `kategori_id` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `artikel`
--

INSERT INTO `artikel` (`id`, `judul`, `deskripsi`, `penulis`, `tanggal`, `foto`, `read_count`, `kategori_id`) VALUES
(14, 'Here are a few tips that will help you to get started about lifestyle', 'Lorem ipsum dolor sit amet consectetur ipsum adipisicing elit. Qui eligendi vitae sit.', 'Johnson smith', '2024-10-31 00:00:00', 'p2.jpg', 0, '3'),
(15, 'Before you start writing first blog post, you should make a content plan.', 'Lorem ipsum dolor sit amet consectetur ipsum adipisicing elit. Qui eligendi vitae sit.', 'Johnson smith', '2024-10-31 00:00:00', 'p1.jpg', 0, '4'),
(16, 'Guidelines to help you decide what your blog post should be about.', 'Lorem ipsum dolor sit amet consectetur ipsum adipisicing elit. Qui eligendi vitae sit.', 'Johnson smith', '2024-10-31 00:00:00', 'p4.jpg', 1, '4'),
(17, 'Now, Make money from blogging in easy steps', 'Lorem ipsum dolor sit amet consectetur ipsum adipisicing elit. Qui eligendi vitae sit.', 'Johnson smith', '2024-10-31 00:00:00', 'p3.jpg', 0, '4'),
(18, 'Many ways by which your blog can earn passive income for you.', 'Lorem ipsum dolor sit amet consectetur ipsum adipisicing elit. Qui eligendi vitae sit.', 'Johnson smith', '2024-10-31 00:00:00', 'p7.jpg', 6, '4'),
(19, 'Keyword research for dummies using the Google Keyword tool', 'Lorem ipsum dolor sit amet consectetur ipsum adipisicing elit. Qui eligendi vitae sit.', 'Johnson smith', '2024-10-31 00:00:00', 'p8.jpg', 0, '4'),
(22, 'How To Be The First to Post A Comment on a Blog-Post?', 'Lorem ipsum dolor sit amet consectetur ipsum adipisicing elit. Qui eligendi vitae sit.', 'Johnson smith', '2024-10-31 00:00:00', 'blog.jpg', 0, '3'),
(23, 'How to Start a Blog and make money every Month from it', 'Lorem ipsum dolor sit amet consectetur ipsum adipisicing elit. Qui eligendi vitae sit.', 'Johnson smith', '2024-10-31 00:00:00', 'p1.jpg', 0, '3'),
(24, 'What’s better than following your passion and making income', 'Lorem ipsum dolor sit amet consectetur ipsum adipisicing elit. Qui eligendi vitae sit.', 'Johnson smith', '2024-10-31 00:00:00', 'p4.jpg', 0, '3'),
(25, 'Without further delay, let’s learn how you can start a blog today.', 'Lorem ipsum dolor sit amet consectetur ipsum adipisicing elit. Qui eligendi vitae sit.', 'Johnson smith', '2024-10-31 00:00:00', 'p3.jpg', 0, '3'),
(26, 'Either way, Blogging could help you achieve your goal.', 'Lorem ipsum dolor sit amet consectetur ipsum adipisicing elit. Qui eligendi vitae sit.', 'Johnson smith', '2024-10-31 00:00:00', 'p7.jpg', 0, '3'),
(27, 'Curated Collection Post : 8 Examples of Evolution in Action', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt tenetur accusamus voluptas. Mollitia, natus ipsam maiores placeat elit.', 'Johnson smith', '2024-10-31 00:00:00', '8.jpg', 6, '3'),
(28, 'The Key Benefits of Studying Online [Infographic]', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt tenetur accusamus voluptas. Mollitia, natus ipsam maiores beatae elit.', 'Johnson smith', '2024-10-31 00:00:00', '9.jpg', 4, '4'),
(29, 'How to Write a Blog Post: A Step-by-Step Guide', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt tenetur accusamus voluptas. Mollitia, natus ipsam maiores beatae elit.', 'Johnson smith', '2024-10-31 00:00:00', '16.jpg', 0, '4'),
(30, 'Ivy Goes Mobile With New App for Designers', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt tenetur accusamus voluptas. Mollitia, natus ipsam maiores beatae elit.', 'Johnson smith', '2024-10-31 00:00:00', '14.jpg', 0, '3'),
(32, 'What I Wish I Had Known Before Writing My First Book', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt tenetur accusamus voluptas. Mollitia, natus ipsam maiores beatae elit.', 'Johnson smith', '2024-10-31 00:00:00', '15.jpg', 0, '4');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id`, `nama`) VALUES
(3, 'Technology'),
(4, 'Lifestyle');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
