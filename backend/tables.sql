SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stockfish`
--

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `submit_id` bigint(20) NOT NULL,
  `submit_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `test_id` text NOT NULL,
  `llr` double NOT NULL,
  `total` bigint(20) NOT NULL,
  `wins` bigint(20) NOT NULL,
  `losses` bigint(20) NOT NULL,
  `draws` bigint(20) NOT NULL,
  `elo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `test_unique`
--

CREATE TABLE `test_unique` (
  `test_id` varchar(32) NOT NULL,
  `submit_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `test_start_date` text NOT NULL,
  `test_user` text NOT NULL,
  `test_branch` text NOT NULL,
  `test_diff` text NOT NULL,
  `test_elo_text` text NOT NULL,
  `test_type_text` text NOT NULL,
  `test_descr_test` text NOT NULL,
  `llr` double NOT NULL,
  `total` bigint(20) NOT NULL,
  `wins` bigint(20) NOT NULL,
  `losses` bigint(20) NOT NULL,
  `draws` bigint(20) NOT NULL,
  `elo` double NOT NULL,
  `test_type` int(11) NOT NULL,
  `elo0` double NOT NULL,
  `elo1` double NOT NULL,
  `alpha` double NOT NULL,
  `beta` double NOT NULL,
  `result` int(11) NOT NULL,
  `test_site` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;