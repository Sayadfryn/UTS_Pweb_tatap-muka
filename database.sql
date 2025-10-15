-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for peternakan_db
DROP DATABASE IF EXISTS `peternakan_db`;
CREATE DATABASE IF NOT EXISTS `peternakan_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `peternakan_db`;

-- Dumping structure for table peternakan_db.hewan
DROP TABLE IF EXISTS `hewan`;
CREATE TABLE IF NOT EXISTS `hewan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_hewan` varchar(50) NOT NULL,
  `nama_hewan` varchar(100) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `id_pakan` int NOT NULL,
  `id_obat` int NOT NULL,
  `keterangan` text NOT NULL,
  `gambar_link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pakan` (`id_pakan`),
  KEY `id_obat` (`id_obat`),
  CONSTRAINT `hewan_ibfk_1` FOREIGN KEY (`id_pakan`) REFERENCES `pakan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `hewan_ibfk_2` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table peternakan_db.obat
DROP TABLE IF EXISTS `obat`;
CREATE TABLE IF NOT EXISTS `obat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_obat` varchar(100) NOT NULL,
  `jenis` varchar(50) DEFAULT NULL,
  `dosis` varchar(100) DEFAULT NULL,
  `deskripsi` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table peternakan_db.pakan
DROP TABLE IF EXISTS `pakan`;
CREATE TABLE IF NOT EXISTS `pakan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_pakan` varchar(100) NOT NULL,
  `jenis` varchar(50) NOT NULL,
  `stok` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table peternakan_db.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
