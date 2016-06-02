SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


TRUNCATE TABLE `competition`;
INSERT INTO `competition` (`id`, `title`, `sportif_id`, `date_begin`, `date_end`, `published`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'La Classique Genevoise', 10, '2016-06-19', '2016-06-19', 3, 2, '2016-06-02 08:36:40', 2, '2016-06-02 08:37:39'),
(2, 'Sweden Tour (vélo)', 10, '2016-06-23', '2016-07-04', 3, 2, '2016-06-02 08:37:24', 2, '2016-06-02 08:37:24'),
(3, '5,4,3,2,1 Genève -> Nice', 10, '2016-07-24', '2016-07-26', 3, 2, '2016-06-02 08:38:37', 2, '2016-06-02 08:38:37'),
(4, 'Tortour', 10, '2016-08-18', '2016-08-19', 3, 2, '2016-06-02 08:39:22', 2, '2016-06-02 08:39:22');

TRUNCATE TABLE `day`;
INSERT INTO `day` (`id`, `training_city`, `sportif_id`, `week_id`, `date`, `time_dispo`, `comment`, `published`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'Gland', 11, 1, '2016-05-25', NULL, NULL, 3, 2, '2016-05-24 19:16:34', 2, '2016-05-24 23:00:30'),
(2, 'Gland', 11, 1, '2016-05-26', NULL, NULL, 3, 2, '2016-05-24 19:33:31', 2, '2016-05-24 23:00:30'),
(3, 'Gland', 12, 2, '2016-05-25', NULL, NULL, 3, 2, '2016-05-24 21:51:35', 2, '2016-05-24 23:00:16'),
(4, 'Gland', 12, 2, '2016-05-26', NULL, NULL, 3, 2, '2016-05-24 21:58:35', 2, '2016-05-24 23:00:16'),
(5, 'Gland', 11, 1, '2016-05-27', NULL, '', 3, 11, '2016-05-24 22:46:41', 11, '2016-05-26 10:55:59'),
(6, 'Gland', 12, 2, '2016-05-27', NULL, '', 3, 12, '2016-05-24 22:46:44', 2, '2016-05-24 23:00:16'),
(7, 'Gland', 11, 1, '2016-05-28', NULL, 'Petit footing à jeun ?\r\njour du spectacle flying yoga', 3, 11, '2016-05-24 22:48:06', 11, '2016-05-26 10:56:35'),
(8, 'Gland', 12, 2, '2016-05-28', NULL, 'J\'ai pas 1h30 samedi. Je travaille toute la journée jusqu\'à 18:45. Mais je peux aller courir le matin sans problème ', 3, 12, '2016-05-24 22:48:07', 2, '2016-05-28 11:07:08'),
(9, 'Gland', 11, 1, '2016-05-29', NULL, NULL, 3, 11, '2016-05-24 22:48:07', 2, '2016-05-24 23:00:30'),
(10, 'Gland', 12, 2, '2016-05-29', NULL, '', 3, 12, '2016-05-24 22:54:51', 2, '2016-05-28 11:07:02'),
(11, 'Gland', 12, 2, '2016-05-23', NULL, NULL, 3, 12, '2016-05-24 22:55:42', 2, '2016-05-24 23:00:16'),
(12, 'Gland', 12, 2, '2016-05-24', NULL, NULL, 3, 12, '2016-05-24 22:55:44', 2, '2016-05-24 23:00:16'),
(13, 'Palma', 10, 3, '2016-05-23', NULL, '', 3, 10, '2016-05-24 23:01:35', 2, '2016-05-26 16:10:35'),
(14, 'Palma', 10, 3, '2016-05-24', NULL, '', 3, 10, '2016-05-24 23:01:43', 2, '2016-05-26 16:10:35'),
(15, 'Palma', 10, 3, '2016-05-25', NULL, '', 3, 10, '2016-05-24 23:01:51', 2, '2016-05-25 22:59:15'),
(16, 'Palma', 10, 3, '2016-05-26', NULL, '', 3, 10, '2016-05-24 23:01:59', 2, '2016-05-25 22:59:15'),
(17, 'Palma', 10, 3, '2016-05-27', NULL, '', 3, 10, '2016-05-24 23:02:06', 2, '2016-05-26 16:09:00'),
(18, 'Gland', 11, 4, '2016-05-30', NULL, NULL, 3, 11, '2016-05-24 23:25:52', 2, '2016-05-29 22:02:47'),
(19, 'Gland', 11, 4, '2016-05-31', NULL, NULL, 3, 11, '2016-05-26 10:56:46', 2, '2016-05-29 22:02:47'),
(20, 'Gland', 11, 4, '2016-06-01', NULL, NULL, 3, 11, '2016-05-26 18:32:09', 2, '2016-05-30 15:48:52'),
(21, 'Gland', 11, 4, '2016-06-02', NULL, NULL, 3, 11, '2016-05-26 18:32:13', 2, '2016-05-30 15:48:52'),
(22, 'Gland', 11, 4, '2016-06-03', NULL, NULL, 3, 11, '2016-05-26 18:32:14', 2, '2016-06-01 21:44:17'),
(23, 'Gland', 11, 4, '2016-06-05', NULL, NULL, 3, 11, '2016-05-26 18:32:19', 2, '2016-06-01 21:44:17'),
(24, 'Gland', 11, 4, '2016-06-04', NULL, NULL, 3, 11, '2016-05-26 18:32:19', 2, '2016-06-01 21:44:17'),
(25, 'Palma', 10, 5, '2016-05-22', NULL, '', 1, 2, '2016-05-28 10:49:52', 2, '2016-05-28 10:49:52'),
(26, 'Gland', 10, 3, '2016-05-28', NULL, NULL, 3, 2, '2016-05-28 11:03:17', 2, '2016-05-28 12:08:50'),
(27, 'Gland', 10, 3, '2016-05-29', NULL, NULL, 3, 2, '2016-05-28 11:03:19', 2, '2016-05-28 12:08:50'),
(28, 'Gland', 10, 6, '2016-05-30', NULL, NULL, 3, 2, '2016-05-28 11:03:58', 2, '2016-05-29 21:59:51'),
(29, 'Gland', 10, 6, '2016-05-31', NULL, NULL, 3, 2, '2016-05-28 11:04:05', 2, '2016-05-29 21:59:51'),
(30, 'Gland', 10, 6, '2016-06-01', NULL, NULL, 3, 2, '2016-05-28 11:04:11', 2, '2016-05-29 21:59:51'),
(31, 'Gland', 10, 6, '2016-06-02', NULL, NULL, 3, 2, '2016-05-28 11:04:23', 2, '2016-05-31 09:42:23'),
(32, 'Gland', 10, 6, '2016-06-03', NULL, NULL, 3, 2, '2016-05-28 11:04:26', 2, '2016-05-31 09:42:23'),
(33, 'Gland', 10, 6, '2016-06-04', NULL, NULL, 3, 2, '2016-05-28 11:04:31', 2, '2016-06-01 21:07:52'),
(34, 'Gland', 10, 6, '2016-06-05', NULL, NULL, 3, 2, '2016-05-28 11:04:34', 2, '2016-06-01 21:07:52'),
(35, 'Gland', 10, 7, '2016-06-06', NULL, NULL, 1, 2, '2016-05-29 21:47:14', 2, '2016-05-29 21:47:14'),
(36, 'Gland', 12, 8, '2016-05-30', NULL, NULL, 3, 2, '2016-05-29 22:04:14', 2, '2016-05-29 22:11:51'),
(37, 'Gland', 12, 8, '2016-05-31', NULL, NULL, 3, 2, '2016-05-29 22:07:49', 2, '2016-05-29 22:11:51'),
(38, 'Gland', 12, 8, '2016-06-01', NULL, NULL, 3, 12, '2016-05-29 22:46:33', 2, '2016-05-31 15:14:18'),
(39, 'Gland', 12, 8, '2016-06-02', NULL, NULL, 3, 12, '2016-05-29 22:46:35', 2, '2016-05-31 15:14:19'),
(40, 'Gland', 12, 8, '2016-06-03', NULL, NULL, 3, 12, '2016-05-29 22:46:36', 2, '2016-05-31 15:14:20'),
(41, 'Gland', 12, 8, '2016-06-04', NULL, NULL, 3, 12, '2016-05-29 22:46:37', 2, '2016-06-01 21:20:01'),
(42, 'Gland', 12, 8, '2016-06-05', NULL, NULL, 3, 12, '2016-05-29 22:46:43', 2, '2016-06-01 21:20:01'),
(43, 'Gland', 10, 7, '2016-06-09', NULL, NULL, 1, 2, '2016-05-31 14:23:52', 2, '2016-05-31 14:23:52'),
(44, 'Gland', 10, 7, '2016-06-07', NULL, NULL, 1, 10, '2016-05-31 14:27:18', 10, '2016-05-31 14:27:18'),
(45, 'Gland', 10, 7, '2016-06-08', NULL, NULL, 1, 10, '2016-05-31 14:27:20', 10, '2016-05-31 14:27:20'),
(46, 'Gland', 12, 10, '2016-06-06', NULL, NULL, 1, 2, '2016-06-01 21:21:00', 2, '2016-06-01 21:21:00'),
(47, 'Gland', 11, 9, '2016-06-06', NULL, NULL, 1, 2, '2016-06-01 21:43:52', 2, '2016-06-01 21:43:52'),
(48, 'Gland', 11, 9, '2016-06-07', NULL, NULL, 1, 2, '2016-06-01 21:44:09', 2, '2016-06-01 21:44:09'),
(49, 'Gland', 11, 9, '2016-06-08', NULL, NULL, 1, 11, '2016-06-01 22:17:53', 11, '2016-06-01 22:17:53'),
(50, 'Gland', 11, 9, '2016-06-09', NULL, NULL, 1, 11, '2016-06-01 22:17:54', 11, '2016-06-01 22:17:54'),
(51, 'Gland', 11, 9, '2016-06-10', NULL, NULL, 1, 11, '2016-06-01 22:17:56', 11, '2016-06-01 22:17:56'),
(52, 'Gland', 11, 9, '2016-06-11', NULL, NULL, 1, 11, '2016-06-01 22:17:58', 11, '2016-06-01 22:17:58'),
(53, 'Gland', 11, 9, '2016-06-12', NULL, NULL, 1, 11, '2016-06-01 22:17:59', 11, '2016-06-01 22:17:59'),
(54, 'Jaun', 10, 7, '2016-06-10', NULL, 'Tournage de la partie VTT du clip Mulaff', 1, 2, '2016-06-02 08:32:23', 2, '2016-06-02 08:32:23'),
(55, 'Santorin (GRE)', 10, 11, '2016-06-13', NULL, '', 1, 2, '2016-06-02 08:34:24', 2, '2016-06-02 08:34:24'),
(56, 'Santorin (GRE)', 10, 11, '2016-06-14', NULL, '', 1, 2, '2016-06-02 08:34:29', 2, '2016-06-02 08:34:29'),
(57, 'Santorin (GRE)', 10, 11, '2016-06-15', NULL, '', 1, 2, '2016-06-02 08:34:34', 2, '2016-06-02 08:34:34'),
(58, 'Santorin (GRE)', 10, 11, '2016-06-16', NULL, '', 1, 2, '2016-06-02 08:34:38', 2, '2016-06-02 08:34:38'),
(59, 'Gland', 10, 7, '2016-06-11', NULL, NULL, 1, 2, '2016-06-02 08:40:20', 2, '2016-06-02 08:40:20'),
(60, 'Gland', 10, 7, '2016-06-12', NULL, NULL, 1, 2, '2016-06-02 08:40:20', 2, '2016-06-02 08:40:20');

TRUNCATE TABLE `reporting`;
INSERT INTO `reporting` (`id`, `training_id`, `feedback`, `date`, `week_id`, `day_id`, `sport_id`, `km`, `done`, `time_done`, `time`, `feeled_rpe`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 3, '', '2016-05-25', 2, 3, 23, 1.73, 1, NULL, '00:15:00', 1, 12, '2016-05-25 06:52:46', 12, '2016-05-25 06:52:46'),
(2, 1, 'J\'adore le vélo !!! \r\nJ\'ai pas trop respecté I2\r\nOups !\r\nMais j\'ai besoin de me dépenser !!! \r\nBisou', '2016-05-25', 1, 1, 29, 56, 1, NULL, '02:13:00', 2, 11, '2016-05-25 15:27:11', 11, '2016-05-25 16:59:28'),
(3, 7, 'Super tour avec le coach himself....\r\nBon il reste plus qu\'à travailler la stabilité du haut du corps dans l\'immédiat et ensuite tous le reste évidemment.... :-)\r\nFaudrait que je puisse réagir à ton feedback - parfois de manière individuelle (jour par jour)', '2016-05-25', 3, 15, 29, 114, 1, NULL, '05:00:00', 2, 2, '2016-05-25 23:20:44', 2, '2016-05-25 23:26:15'),
(4, 4, 'Je me suis reveillée en retard pour l\'école, j\'ai pas eu le temps de le faire. Desolé', '2016-05-26', 2, 4, 23, NULL, 0, NULL, '00:30:00', NULL, 12, '2016-05-26 06:50:52', 12, '2016-05-26 06:50:52'),
(5, 8, 'Magnifique sortie de récupération :-)\r\nJ\'ai bien aimé les changements de rythme, et très beau parcours coach.\r\nMerci pour tout', '2016-05-26', 3, 16, 29, 100, 1, NULL, '03:45:00', 1, 10, '2016-05-26 15:16:13', 2, '2016-05-28 10:56:23'),
(6, 2, '', '2016-05-26', 1, 2, 43, 0.5, 1, NULL, '01:30:00', 1, 11, '2016-05-26 16:36:23', 11, '2016-05-26 16:36:23'),
(7, 16, '', '2016-05-27', 2, 6, 23, 4.04, 1, NULL, '00:28:30', 2, 12, '2016-05-27 06:16:41', 12, '2016-05-27 06:16:41'),
(8, 9, 'Fantastique sortie, la locomotive a été excellente et meme permis d\'aller chercher un kom.....\r\n \r\nBon Iwan, sinon c\'est quand qu\'on va commencer à rouler vite ? :-) :-)', '2016-05-27', 3, 17, 29, 103, 1, NULL, '03:00:00', 4, 2, '2016-05-27 14:19:57', 2, '2016-05-27 14:24:01'),
(9, 14, 'Changement de sport, j\'ai pris l\'option Vélo ;-) trop bien.', '2016-05-27', 1, 5, 23, 37.6, 1, NULL, '01:31:00', 3, 11, '2016-05-28 03:31:17', 2, '2016-05-28 11:06:06'),
(10, 22, '', '2016-05-28', 2, 8, 23, 4.05, 1, NULL, '00:28:45', 2, 12, '2016-05-28 08:54:11', 12, '2016-05-28 08:54:11'),
(11, 11, 'Je me rappelle pas de mon feedback, je te donne juste indication prise depuis mon compte Strava :-)', '2016-05-23', 3, 13, 29, 108, 1, NULL, '03:45:00', 3, 2, '2016-05-28 10:53:09', 2, '2016-05-28 10:59:05'),
(12, 10, 'Première sorite avec nos amis Suédois, ', '2016-05-24', 3, 14, 29, 105, 1, NULL, '03:50:00', 1, 2, '2016-05-28 10:54:39', 2, '2016-05-28 10:54:39'),
(13, 24, 'Hello coach\r\nPas possible de prévoir aujourd\'hui l\'entraînement, je le repousse à demain.\r\nOk ? Et bec', '2016-05-28', 3, 26, 29, NULL, 0, NULL, '01:20:00', NULL, 10, '2016-05-28 12:52:23', 10, '2016-05-28 12:52:23'),
(14, 13, '', '2016-05-28', 1, 7, 43, 1, 1, NULL, '00:30:00', 2, 11, '2016-05-29 08:17:01', 11, '2016-05-29 08:17:01'),
(15, 15, '', '2016-05-28', 1, 7, 23, NULL, 0, NULL, '00:30:00', NULL, 11, '2016-05-29 08:17:16', 11, '2016-05-29 08:17:16'),
(16, 25, 'Sortie tranquille à vélo puis natation 2km piscine de nyon.\r\nLes jambes sont extra en ce moment, par contre la natation c\'est pas du tout ca....\r\n\r\nPetit bogue je ne peux pas mettre 1 au RPE, j\'ai du mettre 2....\r\n', '2016-05-29', 3, 27, 47, 61, 1, NULL, '02:00:00', 1, 10, '2016-05-29 16:08:47', 10, '2016-05-29 16:08:47'),
(17, 33, '', '2016-05-30', 8, 36, 43, 0, 1, NULL, '00:30:00', 1, 12, '2016-05-30 17:51:01', 12, '2016-05-30 17:51:01'),
(18, 28, 'Gainages- développer coucher - TRX- dos- traction - biceps - et dos\r\nJ\'ai eu de la peine à mettre en marche et ensuite le dernier tour assez dur.\r\nVivement le vélo mercredi !!!', '2016-05-30', 6, 28, 42, 0, 1, NULL, '01:15:00', 4, 10, '2016-05-30 22:24:16', 2, '2016-05-31 14:32:55'),
(19, 34, '', '2016-05-31', 8, 37, 23, 4.14, 1, NULL, '00:30:00', 2, 12, '2016-05-31 06:17:32', 12, '2016-05-31 06:17:32'),
(20, 35, 'Merci, oui je pense que tu peux écrire un livre pour le yoga ;-)', '2016-05-30', 4, 18, 46, 1, 1, NULL, '00:45:00', 1, 11, '2016-05-31 07:43:51', 11, '2016-05-31 07:43:51'),
(21, 29, 'Eau trop froide pour faire plus que une heure \r\nSorry', '2016-05-31', 6, 29, 35, 2.4, 1, NULL, '01:00:00', 1, 10, '2016-05-31 13:19:47', 2, '2016-05-31 14:20:19'),
(22, 36, 'C\'était dur, j\'avais mal au pied, un point dans le dos ( toujours le même... Celui qui traverse vers ma vésicule)\r\nÇa soufflait pas mal ....\r\nMais contente d\'avoir fait mon entraînement quand même :-)', '2016-05-31', 4, 19, 23, 9.44, 1, NULL, '01:07:00', 5, 11, '2016-05-31 17:51:09', 11, '2016-05-31 17:51:09'),
(23, 46, 'J\'ai permuté le programme entre mercredi et jeudi, vu que jeudi matin je serais chez ma mère et je n\'aurais donc pas la salle de gym à disposition. Je ferais la course à pied demain. \r\nAlors j\'ai fait 1 heure de gainage hier soir, et 30 minutes ce matin. ', '2016-06-02', 8, 39, 43, 0, 1, NULL, '01:30:00', 2, 12, '2016-06-01 06:43:03', 12, '2016-06-01 06:43:03'),
(24, 39, 'Je suis aller dehors un petit bout avec Philipp et j\'ai fais une petite boucle retour pour retrouver les enfants à la maison.\r\nC\'était Geil !!!!!!!!! Et meme avec un peu de soleil.\r\nJ\'adore faire des ballades à vélo ! C\'est vraiment ce que je préfère !', '2016-06-01', 4, 20, 25, 46.5, 1, NULL, '01:52:00', 3, 11, '2016-06-01 12:05:48', 11, '2016-06-01 12:05:48'),
(25, 30, 'Tour du Lac, tout seul.\r\nAgnès m\'a accompagné jusqu\'à Morges, puis j\'ai mis un peu de vitesse :-), moyenne de plus de 30km/h, suis content.\r\nJ\'aurai pu mettre un RPE de 2, mais je dois dire que mes rotules m\'ont tout de même gêné depuis la mi-parcours.\r\n', '2016-06-01', 6, 30, 29, 167, 1, NULL, '05:40:00', 3, 2, '2016-06-01 15:56:52', 2, '2016-06-01 15:56:52'),
(26, 45, '', '2016-06-01', 8, 38, 23, 2.95, 1, NULL, '00:27:00', 3, 12, '2016-06-02 11:08:45', 12, '2016-06-02 11:08:45'),
(27, 56, '', '2016-06-03', 8, 40, 47, 0, 1, NULL, '01:00:00', 1, 12, '2016-06-02 11:09:39', 12, '2016-06-02 11:09:39');

TRUNCATE TABLE `training`;
INSERT INTO `training` (`id`, `title`, `sport_id`, `category_id`, `sub_category_id`, `sportif_id`, `day_id`, `week_id`, `time`, `rpe`, `explanation`, `extra_comment`, `graph`, `graph_type`, `date`, `published`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'En endurance I2. Sur parcours légèrement vallonné. Varie bien entre assis et debout, varie les rpm. Fais quelques sprints/accélérations au final', 29, 15, NULL, 11, 1, 1, '01:30:00', 3, 'Ces sorties en endurance de base sont très importants. Le 80% de tous les entraînements devrait ce faire dans ces zones ou tu es capable de discuter encore avec quelqu\'un. Les accélérations au final donnent un petit stimuli musculaire non negligeable (coordination intra- et inter-musculaire)', 'Fais ton tour que tu adors ! Et pense aux deux hommes à Mallorca et tout le bonheur que nous sommes en train de créer ... !', 'I2X15/I3X15/I2X15/I3X15/I2X15/I3X15/I2X15/I3X15/I2X15/I3X15/I2X15/I3X15/I5X0.15/I1X0.45/I5X0.15/I1X0.45/I5X0.15/I1X0.45/I5X0.15/I1X0.45/I5X0.15/I1X0.45', 2, '2016-05-25', 3, 2, '2016-05-24 19:16:34', 2, '2016-05-24 23:00:30'),
(2, 'Programme par l\'instructrice.', 43, NULL, NULL, 11, 2, 1, '01:30:00', 2, 'Ces entraînements de gainage se complètent de manière parfaite avec les sports d\'endurance de la semaine.', '', '', NULL, '2016-05-26', 3, 2, '2016-05-24 19:33:31', 2, '2016-05-24 23:00:30'),
(3, 'Endurance I2, 4 accelerations de 100m au final', 23, 1, NULL, 12, 3, 2, '00:25:00', 3, 'Tu cours tout tranquillement en ENDURANCE. C\'est à dire sans stress, bonne respiration, bonne technique, "être capable de discuter avec quelqu\'un" ! Vers la fin de ta sortie, tu fais 4 accélérations de 100m (pas à 100% de la vitesse maximale, mais bien contrôlé) avec chaque fois une minute (1\') de marche entre ces accélérations. ', 'Mulaff Coaching se réjouit BEAUCOUP de démarrer se projet "GETTING FIT" avec toi ! Tu verras, c\'est cool, pas toujours facile, mais nous sommes là pour t\'accompagner à VIVRE TES RÊVES !', 'I2X75/I5X0.10/I1X0.50/I5X0.10/I1X0.50/I5X0.10/I1X0.50/I5X0.10/I1X0.50/', 1, '2016-05-25', 3, 2, '2016-05-24 21:51:35', 2, '2016-05-24 23:00:16'),
(4, '10\' endurance I2, 2*[3\' I3 - P3\' I1], 8\' I2', 23, 3, 1, 12, 4, 2, '00:30:00', 4, 'Tu cours 10\' en endurance I2 tranquille. Ensuite, tu fais 3\' en vitesse MOYENNE avec 3\' marcher. Le but, c\'est de courir un peu plus vite et ensuite - pendant la marche - de descendre la fréquence cardiaque (FC) le plus possible. Les 3\' de marche passées, tu reprends avec la vitesse MOYENNE (bon speed, mais pas maxima