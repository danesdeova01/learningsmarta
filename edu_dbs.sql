-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Waktu pembuatan: 21 Bulan Mei 2025 pada 08.41
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `edu_dbs`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `forums`
--

CREATE TABLE `forums` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `konten` text NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `forums`
--

INSERT INTO `forums` (`id`, `judul`, `konten`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 'Belajar Informatika Dasar', 'Silakan berdiskusi bersama mengenai materi Informatika Dasar. Gunakan kesempatan ini untuk :\r\n✅ Saling berbagi pemahaman,\r\n✅ Bertanya jika ada hal yang kurang jelas, dan\r\n✅ Mendengarkan pendapat teman agar sama-sama bisa memahami materi dengan lebih baik.\r\n\r\nIngat, tujuan kita adalah belajar bersama, bukan mencari siapa yang paling benar. Jadi, mari ciptakan suasana diskusi yang aktif, terbuka, dan saling menghargai.\r\n\r\nSelamat berdiskusi! 🌟', 1, '2025-05-10 01:54:26', '2025-05-10 01:54:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `forum_replies`
--

CREATE TABLE `forum_replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `forum_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `konten` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `forum_replies`
--

INSERT INTO `forum_replies` (`id`, `forum_id`, `user_id`, `konten`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 'Ada yang paham nggak ya tentang apa itu algoritma?', '2025-05-10 02:43:17', '2025-05-10 02:43:17'),
(2, 2, 2, 'gapaham sy', '2025-05-11 05:49:40', '2025-05-11 05:49:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_ujian`
--

CREATE TABLE `hasil_ujian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `matapelajaran_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jenis_ujian` varchar(255) DEFAULT NULL,
  `jumlah_soal` int(11) NOT NULL DEFAULT 0,
  `jawaban_benar` int(11) NOT NULL DEFAULT 0,
  `nilai` int(11) NOT NULL DEFAULT 0,
  `tanggal_ujian` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `hasil_ujian`
--

INSERT INTO `hasil_ujian` (`id`, `user_id`, `matapelajaran_id`, `jenis_ujian`, `jumlah_soal`, `jawaban_benar`, `nilai`, `tanggal_ujian`, `created_at`, `updated_at`) VALUES
(1, 2, 9, 'UAS', 4, 1, 25, '2025-05-19 03:36:45', '2025-05-19 03:36:45', '2025-05-19 03:36:45'),
(4, 8, 9, 'UAS', 4, 2, 50, '2025-05-21 06:12:23', '2025-05-19 04:17:57', '2025-05-21 06:12:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jawabans`
--

CREATE TABLE `jawabans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tugas_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `no_induk` varchar(255) NOT NULL,
  `file_jawab` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jawabans`
--

INSERT INTO `jawabans` (`id`, `tugas_id`, `nama`, `no_induk`, `file_jawab`, `user_id`, `created_at`, `updated_at`) VALUES
(16, 5, 'Indah Astuti', '11', '1746869204_7384-17923-1-PB.pdf', 2, '2025-05-10 09:26:44', '2025-05-10 09:26:44'),
(17, 4, 'Indah Astuti', '11', '1746870457_48508-126052-1-PB.pdf', 2, '2025-05-10 09:47:37', '2025-05-10 09:47:37'),
(18, 9, 'Danes Deova Redina', '13', '1747573275_1747567265_Jurnal_SCOPUS_Internasional.pdf', 8, '2025-05-18 13:01:15', '2025-05-18 13:01:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jawaban_review`
--

CREATE TABLE `jawaban_review` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `review` varchar(255) DEFAULT NULL,
  `nilai` int(11) DEFAULT NULL,
  `file_feedback` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `jawaban_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jawaban_review`
--

INSERT INTO `jawaban_review` (`id`, `review`, `nilai`, `file_feedback`, `created_at`, `updated_at`, `jawaban_id`) VALUES
(4, 'Masih banyak bagian yang belum lengkap atau kurang tepat jawabannya, coba baca lagi materinya dan jangan ragu untuk bertanya kalau ada yang bingung. Semangat terus ya 💪✨', 45, NULL, '2025-05-10 09:51:47', '2025-05-10 09:51:47', 16);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_ujian`
--

CREATE TABLE `jenis_ujian` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `timer` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jenis_ujian`
--

INSERT INTO `jenis_ujian` (`id`, `nama`, `timer`, `created_at`, `updated_at`) VALUES
(1, 'UAS', 90, '2025-05-16 02:49:08', '2025-05-19 02:38:33'),
(2, 'UTS', 90, '2025-05-16 02:49:08', '2025-05-19 02:38:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(2) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id`, `nama`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'A', 'a', '2025-04-29 05:45:13', '2025-04-29 05:45:13'),
(2, 'B', 'b', '2025-04-29 05:45:13', '2025-04-29 05:45:13'),
(3, 'C', 'c', '2025-04-29 05:45:13', '2025-04-29 05:45:13'),
(4, 'D', 'd', '2025-04-29 05:45:13', '2025-04-29 05:45:13'),
(5, 'E', 'e', '2025-04-29 05:45:13', '2025-04-29 05:45:13'),
(6, 'F', 'f', '2025-04-29 05:45:13', '2025-04-29 05:45:13'),
(7, 'G', 'g', '2025-04-29 05:45:13', '2025-04-29 05:45:13'),
(8, 'H', 'h', '2025-04-29 05:45:13', '2025-04-29 05:45:13'),
(9, 'I', 'i', '2025-04-29 05:45:13', '2025-04-29 05:45:13'),
(10, 'J', 'j', '2025-04-29 05:45:13', '2025-04-29 05:45:13'),
(11, 'K', 'k', '2025-04-29 05:45:13', '2025-04-29 05:45:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas_matapelajaran`
--

CREATE TABLE `kelas_matapelajaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `matapelajaran_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kelas_matapelajaran`
--

INSERT INTO `kelas_matapelajaran` (`id`, `kelas_id`, `matapelajaran_id`, `created_at`, `updated_at`) VALUES
(1, 1, 9, NULL, NULL),
(2, 2, 9, NULL, NULL),
(3, 3, 9, NULL, NULL),
(4, 4, 9, NULL, NULL),
(5, 5, 9, NULL, NULL),
(6, 6, 9, NULL, NULL),
(7, 7, 9, NULL, NULL),
(8, 8, 9, NULL, NULL),
(9, 9, 9, NULL, NULL),
(10, 10, 9, NULL, NULL),
(11, 11, 9, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kompetensis`
--

CREATE TABLE `kompetensis` (
  `judul` varchar(255) NOT NULL,
  `deskripsi` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kompetensis`
--

INSERT INTO `kompetensis` (`judul`, `deskripsi`) VALUES
('Halaman Kompetensi', '<div>Tujuan kurikulum mencakup empat kompetensi, yaitu (1) kompetensi sikap spiritual, (2) sikap sosial, (3) pengetahuan, dan (4) keterampilan. Kompetensi</div><div>tersebut dicapai melalui proses pembelajaran intrakurikuler, kokurikuler, dan/atau ekstrakurikuler.</div><div><br>Rumusan Kompetensi Sikap Spiritual yaitu, “Menghayati dan mengamalkan ajaran agama yang dianutnya”. Adapun rumusan Kompetensi Sikap Sosial yaitu, “Menunjukkan perilaku jujur, disiplin, tanggung jawab, peduli (gotong royong, kerja sama, toleran, damai), santun, responsif, dan pro-aktif sebagai bagian dari solusi atas berbagai permasalahan dalam berinteraksi secara efektif dengan lingkungan sosial dan alam serta menempatkan diri sebagai cerminan bangsa dalam pergaulan dunia”. Kedua kompetensi tersebut dicapai melalui pembelajaran tidak langsung (indirect teaching), yaitu keteladanan, pembiasaan, dan budaya sekolah dengan memperhatikan karakteristik mata pelajaran, serta kebutuhan dan kondisi peserta didik.</div><div><br></div><div>Penumbuhan dan pengembangan kompetensi sikap dilakukan sepanjang</div><div>proses pembelajaran berlangsung, dan dapat digunakan sebagai pertimbangan</div><div>guru dalam mengembangkan karakter peserta didik lebih lanjut.</div>'),
('Halaman Kompetensi', '<div>Tujuan kurikulum mencakup empat kompetensi, yaitu (1) kompetensi sikap spiritual, (2) sikap sosial, (3) pengetahuan, dan (4) keterampilan. Kompetensi</div><div>tersebut dicapai melalui proses pembelajaran intrakurikuler, kokurikuler, dan/atau ekstrakurikuler.</div><div><br>Rumusan Kompetensi Sikap Spiritual yaitu, “Menghayati dan mengamalkan ajaran agama yang dianutnya”. Adapun rumusan Kompetensi Sikap Sosial yaitu, “Menunjukkan perilaku jujur, disiplin, tanggung jawab, peduli (gotong royong, kerja sama, toleran, damai), santun, responsif, dan pro-aktif sebagai bagian dari solusi atas berbagai permasalahan dalam berinteraksi secara efektif dengan lingkungan sosial dan alam serta menempatkan diri sebagai cerminan bangsa dalam pergaulan dunia”. Kedua kompetensi tersebut dicapai melalui pembelajaran tidak langsung (indirect teaching), yaitu keteladanan, pembiasaan, dan budaya sekolah dengan memperhatikan karakteristik mata pelajaran, serta kebutuhan dan kondisi peserta didik.</div><div><br></div><div>Penumbuhan dan pengembangan kompetensi sikap dilakukan sepanjang</div><div>proses pembelajaran berlangsung, dan dapat digunakan sebagai pertimbangan</div><div>guru dalam mengembangkan karakter peserta didik lebih lanjut.</div>');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mata_pelajarans`
--

CREATE TABLE `mata_pelajarans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `matapelajaran_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama` varchar(225) NOT NULL,
  `slug` varchar(250) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mata_pelajarans`
--

INSERT INTO `mata_pelajarans` (`id`, `matapelajaran_id`, `nama`, `slug`, `created_at`, `updated_at`) VALUES
(9, NULL, 'Informatika', 'informatika', '2025-05-09 07:14:44', '2025-05-09 07:14:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_09_27_112011_create_mata_pelajarans_table', 1),
(6, '2022_09_27_112029_create_materis_table', 1),
(7, '2022_09_28_005119_create_soals_table', 1),
(8, '2022_09_28_060306_create_tugas_table', 1),
(9, '2022_09_28_062700_create_jawabans_table', 1),
(10, '2022_09_28_135953_create_penelitis_table', 1),
(11, '2022_12_14_024429_create_kompetensis_table', 1),
(12, '2025_04_15_145837_create_forums_table', 1),
(13, '2025_04_15_145902_create_forum_replies_table', 1),
(14, '2025_04_24_075435_create_kelas_table', 1),
(15, '2025_04_24_075543_add_kelas_id_to_materis_table', 1),
(16, '2025_04_25_095344_add_kelas_id_to_users_table', 1),
(17, '2025_04_27_072730_create_topiks_table', 1),
(18, '2025_04_29_032444_create_jawaban_review_table', 1),
(19, '2025_04_29_032551_add_jawaban_id_to_jawaban_review_table', 1),
(20, '2025_05_07_030417_add_due_date_to_tugas_table', 2),
(21, '2025_05_09_135935_create_kelas_matapelajaran_table', 3),
(22, '2025_05_09_201453_add_kelas_id_to_tugas_table', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `soals`
--

CREATE TABLE `soals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pertanyaan` longtext NOT NULL,
  `pilihan_a` varchar(255) DEFAULT NULL,
  `pilihan_b` varchar(255) DEFAULT NULL,
  `pilihan_c` varchar(255) DEFAULT NULL,
  `pilihan_d` varchar(255) DEFAULT NULL,
  `pilihan_e` varchar(255) DEFAULT NULL,
  `kunci_jawaban` varchar(255) DEFAULT NULL,
  `matapelajaran_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `jenis_soal` varchar(255) DEFAULT NULL,
  `uraian` text DEFAULT NULL,
  `pencocokan` text DEFAULT NULL,
  `jenis_ujian` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `soals`
--

INSERT INTO `soals` (`id`, `pertanyaan`, `pilihan_a`, `pilihan_b`, `pilihan_c`, `pilihan_d`, `pilihan_e`, `kunci_jawaban`, `matapelajaran_id`, `created_at`, `updated_at`, `jenis_soal`, `uraian`, `pencocokan`, `jenis_ujian`) VALUES
(51, 'Perangkat yang berfungsi untuk memproses data dalam komputer disebut …', 'Monitor', 'CPU', 'Keyboard', 'Printer', 'Mouse', 'b', 9, '2025-05-18 15:02:25', '2025-05-18 15:02:25', 'pilihan_ganda', NULL, NULL, 'UAS'),
(52, 'BENAR atau SALAH\r\nWindows adalah perangkat keras komputer', NULL, NULL, NULL, NULL, NULL, NULL, 9, '2025-05-18 15:04:34', '2025-05-21 05:23:54', 'uraian_singkat', 'SALAH', NULL, 'UAS'),
(53, 'Pilih semua pernyataan yang BENAR!', 'Mouse digunakan untuk mengarahkan kursor', 'Monitor merupakan perangkat input', 'Keyboard termasuk perangkat input', 'CPU berfungsi mencetak dokumen', 'Windows menyimpan data secara permanen', '[\"a\",\"c\"]', 9, '2025-05-18 23:07:26', '2025-05-18 23:07:26', 'pilihan_ganda_kompleks', NULL, NULL, 'UAS'),
(55, 'Kolom A\r\nA. LAN\r\nB. MAN\r\nC. WAN\r\n\r\nKolom B\r\n1. Jaringan dalam satu gedung\r\n2. Jaringan antar kota\r\n3. Jaringan antar negara', NULL, NULL, NULL, NULL, NULL, NULL, 9, '2025-05-18 23:26:33', '2025-05-18 23:26:33', 'menjodohkan', NULL, '{\"A\":\"1\",\"B\":\"2\",\"C\":\"3\"}', 'UAS');

-- --------------------------------------------------------

--
-- Struktur dari tabel `topiks`
--

CREATE TABLE `topiks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `matapelajaran_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `konten` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `topiks`
--

INSERT INTO `topiks` (`id`, `matapelajaran_id`, `nama`, `kelas_id`, `konten`, `file`, `created_at`, `updated_at`) VALUES
(10, 9, 'Teknologi Informasi dan Komunikasi (TIK)', 1, '<p data-start=\"79\" data-end=\"789\" class=\"\"><strong data-start=\"79\" data-end=\"142\">Teknologi Informasi dan Komunikasi (TIK)</strong>&nbsp;adalah mata pelajaran yang membekali siswa dengan pemahaman dasar tentang penggunaan teknologi digital dalam kehidupan sehari-hari dan dunia kerja. Siswa diperkenalkan pada konsep perangkat keras dan lunak komputer, jaringan komputer, internet, serta aplikasi-aplikasi penting seperti pengolah kata, lembar kerja, dan presentasi. Selain aspek teknis, pelajaran ini juga menekankan pentingnya etika digital, keamanan data, serta pemanfaatan TIK untuk mendukung pembelajaran, komunikasi, dan bisnis. Tujuannya agar siswa memiliki keterampilan dasar yang relevan dengan kebutuhan zaman digital serta mampu menggunakan TIK secara bertanggung jawab.</p><hr data-start=\"791\" data-end=\"794\" class=\"\"><p data-start=\"796\" data-end=\"834\" class=\"\">✅ <strong data-start=\"798\" data-end=\"832\">Materi Utama TIK SMK Kelas 10 :</strong></p><p>\r\n\r\n\r\n</p><ul data-start=\"835\" data-end=\"1326\">\r\n<li data-start=\"835\" data-end=\"883\" class=\"\">\r\n<p data-start=\"837\" data-end=\"883\" class=\"\">Pengenalan TIK: pengertian, sejarah, manfaat</p>\r\n</li>\r\n<li data-start=\"884\" data-end=\"945\" class=\"\">\r\n<p data-start=\"886\" data-end=\"945\" class=\"\">Perangkat Keras (Hardware): jenis, fungsi, dan cara kerja</p>\r\n</li>\r\n<li data-start=\"946\" data-end=\"1031\" class=\"\">\r\n<p data-start=\"948\" data-end=\"1031\" class=\"\">Perangkat Lunak (Software): sistem operasi, aplikasi perkantoran, software grafis</p>\r\n</li>\r\n<li data-start=\"1032\" data-end=\"1069\" class=\"\">\r\n<p data-start=\"1034\" data-end=\"1069\" class=\"\">Sistem Operasi dan Manajemen File</p>\r\n</li>\r\n<li data-start=\"1070\" data-end=\"1135\" class=\"\">\r\n<p data-start=\"1072\" data-end=\"1135\" class=\"\">Jaringan Komputer: konsep dasar, topologi, perangkat jaringan</p>\r\n</li>\r\n<li data-start=\"1136\" data-end=\"1203\" class=\"\">\r\n<p data-start=\"1138\" data-end=\"1203\" class=\"\">Internet dan Pemanfaatannya: browsing, email, komunikasi daring</p>\r\n</li>\r\n<li data-start=\"1204\" data-end=\"1271\" class=\"\">\r\n<p data-start=\"1206\" data-end=\"1271\" class=\"\">Etika dan Keamanan Informasi: hak cipta, privasi, keamanan data</p>\r\n</li>\r\n<li data-start=\"1272\" data-end=\"1326\" class=\"\">\r\n<p data-start=\"1274\" data-end=\"1326\" class=\"\">Pemanfaatan TIK dalam Pembelajaran dan Dunia Usaha</p></li></ul>', '', '2025-05-09 10:22:48', '2025-05-11 05:56:54'),
(17, 9, 'Algoritma', 1, '<p>Coba pelajari video berikut ini</p>', 'belajar-jadi-lebih-mudah-ruangguru-animasi-indonesia-ytshorts.savetube.me.mp4', '2025-05-11 09:52:35', '2025-05-11 09:52:35'),
(18, 9, 'Logika Fuzzy', 1, '<p>Pelajari materi dibawah ini&nbsp;</p>', 'TKA-02 Public Cloud Platforms (AWS) 2024-2025.pdf', '2025-05-11 09:53:32', '2025-05-11 09:53:32'),
(19, 9, 'Komputasi Awan', 2, '<p>Pelajari materi berikut</p>', 'Tesis Dody Sumardi BAB II.pdf', '2025-05-11 09:57:42', '2025-05-11 09:57:42'),
(26, 9, 'Mari Bermain Teka Teki Silang!', 1, '<p>Klik pada link berikut!<br><br><span style=\"font-weight: bolder;\">https://www.educaplay.com/learning-resources/23880733-hardware_ko.html</span></p>', NULL, '2025-05-20 08:55:07', '2025-05-20 08:55:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas`
--

CREATE TABLE `tugas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `matapelajaran_id` bigint(20) UNSIGNED NOT NULL,
  `konten` longtext NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `due_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tugas`
--

INSERT INTO `tugas` (`id`, `kelas_id`, `matapelajaran_id`, `konten`, `file`, `due_date`, `created_at`, `updated_at`) VALUES
(4, 1, 10, '<p>Coba anda buat resume dari materi berikut!</p>', '1746841088_Matematika-BS-KLS-X.pdf', '2025-05-14 17:00:00', '2025-05-10 01:38:08', '2025-05-10 01:38:08'),
(5, 1, 9, '<p>Kerjakan tugas berikut!</p>', '1746841374_Informatika-KLS-X-Sem-1.pdf', '2025-05-15 01:42:00', '2025-05-10 01:42:54', '2025-05-10 01:42:54'),
(6, 1, 9, '<p>Kerjakan tugas berikut dengan teliti! Mohon diperhatikan tenggat waktu hanya 30 menit!</p>', NULL, '2025-05-10 10:25:00', '2025-05-10 10:23:17', '2025-05-10 10:23:17'),
(7, 2, 9, '<p>Buatlah resume dari jurnal tentang phyton berikut</p>', '1746943218_Pertemuan_04_-_Penyusunan_Instrumen_dan_Skala_Pengukuran.pdf', '2025-05-17 09:02:00', '2025-05-11 06:00:18', '2025-05-11 06:00:18'),
(9, 1, 11, '<p>Kerjakan tugas berikut!</p>', '1747573233_1747570989_Sejarah-BS-KLS-X.pdf', '2025-06-28 13:00:00', '2025-05-18 13:00:33', '2025-05-18 13:00:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL DEFAULT 'mahasiswa',
  `kelas_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `level`, `kelas_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$10$UAWjlNCOZhnMkmpAtTjzBO9qUUoIGNxFMzgby1kbnVSjeUPWuA30.', 'admin', NULL, 'sRuWlyKYogpq9GIv47JyBTqtr3dztyDD7p4svLHRAfnGhASrIdXU5EXjEVC7', '2025-04-29 05:45:13', '2025-05-21 04:13:19'),
(2, 'Indah', 'indah@gmail.com', NULL, '$2y$10$5YYqvW9VYqYxiDrexXIMRu5F6n0.yNeyUJIiWe4Psp2p/GnBgnY8S', 'mahasiswa', 1, 'I4m1kbhthnsqgo43qZhjFYjzuLy2lzGLN8Sl3bvx0o0ZKOXNNjfrf1vCbLIN', '2025-04-29 05:45:13', '2025-04-29 05:45:13'),
(6, 'hilwa', 'hilwaabror@gmail.com', NULL, '$2y$10$10wB32fdg4/n5doAx25C2edbw1uMja59sdQ7T5/v1F8V3QKOFKxou', 'mahasiswa', 2, NULL, '2025-05-11 05:52:11', '2025-05-11 05:52:19'),
(7, 'Rahma Sekti Femiliyana K', 'rahmafemi863@gmail.com', NULL, '$2y$10$MzvI2q7mZ7BWP85oJrS88uvqhbGppPfrHbr7aIUyJzXIp0o0AvvWa', 'mahasiswa', 2, NULL, '2025-05-11 13:06:47', '2025-05-11 13:06:57'),
(8, 'danes', 'danes@gmail.com', NULL, '$2y$10$.NOpFn33UAbb1/FJZryNJuiif63yRAhPkwiC5KPt.j9V9d43wpMfe', 'mahasiswa', 11, NULL, '2025-05-16 11:03:09', '2025-05-21 04:14:32');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `forums`
--
ALTER TABLE `forums`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `forum_replies`
--
ALTER TABLE `forum_replies`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `hasil_ujian`
--
ALTER TABLE `hasil_ujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hasil_ujian_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `jawabans`
--
ALTER TABLE `jawabans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jawabans_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `jawaban_review`
--
ALTER TABLE `jawaban_review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jawaban_review_jawaban_id_foreign` (`jawaban_id`);

--
-- Indeks untuk tabel `jenis_ujian`
--
ALTER TABLE `jenis_ujian`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kelas_nama_unique` (`nama`),
  ADD UNIQUE KEY `kelas_slug_unique` (`slug`);

--
-- Indeks untuk tabel `kelas_matapelajaran`
--
ALTER TABLE `kelas_matapelajaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kelas_matapelajaran_kelas_id_matapelajaran_id_unique` (`kelas_id`,`matapelajaran_id`),
  ADD KEY `kelas_matapelajaran_matapelajaran_id_foreign` (`matapelajaran_id`);

--
-- Indeks untuk tabel `mata_pelajarans`
--
ALTER TABLE `mata_pelajarans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `soals`
--
ALTER TABLE `soals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `soals_materi_id_foreign` (`matapelajaran_id`);

--
-- Indeks untuk tabel `topiks`
--
ALTER TABLE `topiks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topiks_kelas_id_foreign` (`kelas_id`);

--
-- Indeks untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_kelas_id_foreign` (`kelas_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `forums`
--
ALTER TABLE `forums`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `forum_replies`
--
ALTER TABLE `forum_replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `hasil_ujian`
--
ALTER TABLE `hasil_ujian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `jawabans`
--
ALTER TABLE `jawabans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `jawaban_review`
--
ALTER TABLE `jawaban_review`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `jenis_ujian`
--
ALTER TABLE `jenis_ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `kelas_matapelajaran`
--
ALTER TABLE `kelas_matapelajaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT untuk tabel `mata_pelajarans`
--
ALTER TABLE `mata_pelajarans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `soals`
--
ALTER TABLE `soals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT untuk tabel `topiks`
--
ALTER TABLE `topiks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `hasil_ujian`
--
ALTER TABLE `hasil_ujian`
  ADD CONSTRAINT `hasil_ujian_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jawabans`
--
ALTER TABLE `jawabans`
  ADD CONSTRAINT `jawabans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jawaban_review`
--
ALTER TABLE `jawaban_review`
  ADD CONSTRAINT `jawaban_review_jawaban_id_foreign` FOREIGN KEY (`jawaban_id`) REFERENCES `jawabans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kelas_matapelajaran`
--
ALTER TABLE `kelas_matapelajaran`
  ADD CONSTRAINT `kelas_matapelajaran_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kelas_matapelajaran_matapelajaran_id_foreign` FOREIGN KEY (`matapelajaran_id`) REFERENCES `mata_pelajarans` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `topiks`
--
ALTER TABLE `topiks`
  ADD CONSTRAINT `topiks_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
