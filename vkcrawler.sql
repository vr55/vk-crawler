-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 15 2016 г., 23:31
-- Версия сервера: 5.5.50-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `vkcrawler`
--

-- --------------------------------------------------------

--
-- Структура таблицы `activations`
--

CREATE TABLE IF NOT EXISTS `activations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `activations`
--

INSERT INTO `activations` (`id`, `user_id`, `code`, `completed`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'RnzsEezUyD43yilGVlIw7OsHMVvRty2F', 1, '2016-05-26 19:24:12', '2016-05-26 19:24:12', '2016-05-26 19:24:12');

-- --------------------------------------------------------

--
-- Структура таблицы `mcComunities`
--

CREATE TABLE IF NOT EXISTS `mcComunities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `efficiency` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Дамп данных таблицы `mcComunities`
--

INSERT INTO `mcComunities` (`id`, `owner_id`, `active`, `efficiency`, `name`, `url`, `created_at`, `updated_at`) VALUES
(13, 1, 0, 1, 'JOBROOM работа кастинги  вакансии съемки модели', 'https://vk.com/jobroom_group', '2016-05-22 14:08:10', '2016-05-27 20:17:16'),
(14, 1, 0, 0, 'ВШОУБИЗЕ.РФ Кастинги Съемки Работа в шоу-бизнесе', 'https://vk.com/v_showbize', '2016-05-22 14:08:35', '2016-05-26 08:16:59'),
(15, 1, 0, 0, 'РАБОТА в EVENTe вакансии для творческих людей!', 'https://vk.com/v.evente', '2016-05-22 14:08:49', '2016-05-22 14:08:49'),
(16, 1, 0, 1, 'Event Work. Поиск работы в event и шоу-бизнесе.', 'https://vk.com/work_event', '2016-05-22 14:09:07', '2016-05-30 20:27:36'),
(17, 1, 0, 0, 'Event Jobs', 'https://vk.com/myeventjobs', '2016-05-22 14:09:22', '2016-05-22 14:09:22'),
(18, 1, 0, 0, 'public65657819', 'https://vk.com/public65657819', '2016-05-22 14:09:37', '2016-05-22 14:09:37'),
(19, 1, 0, 2, 'EVENT''S  WORK', 'https://vk.com/telefon9060575807', '2016-05-22 14:09:54', '2016-05-27 20:17:16'),
(21, 1, 0, 8, 'EventHunt LOW COST - предложения, TFP.', 'https://vk.com/myeventhuntbeginners', '2016-05-22 14:10:24', '2016-06-11 19:18:15'),
(22, 1, 0, 0, 'Работа Для Творческих Людей (Москва)', 'https://vk.com/artworkpeople', '2016-05-24 17:47:20', '2016-05-24 17:47:20'),
(23, 1, 0, 0, 'Вся творческая работа 77 (вакансии) Москва', 'https://vk.com/mskeventjob', '2016-05-24 19:51:27', '2016-05-24 19:51:27'),
(24, 1, 0, 6, 'Event Hunt - поиск подрядчиков для мероприятий', 'https://vk.com/myeventhunt', '2016-05-24 19:52:41', '2016-06-03 17:36:45'),
(25, 1, 0, 3, 'Event Hunt - Доска нужных объявлений', 'https://vk.com/hunttoevent', '2016-05-24 19:56:26', '2016-06-11 19:18:16'),
(26, 1, 0, 0, 'public11294216', 'https://vk.com/public11294216', '2016-05-24 19:58:35', '2016-05-24 19:58:35'),
(27, 1, 0, 91, 'Ищу фотографа, видеографа: агрегатор объявлений', 'https://vk.com/shikari_photo', '2016-05-26 08:19:37', '2016-06-11 19:18:17'),
(28, 1, 0, 0, 'КИОСК РАБОТЫ РОССИЯ', 'https://vk.com/club121389875', '2016-06-01 08:17:13', '2016-06-01 08:17:13');

-- --------------------------------------------------------

--
-- Структура таблицы `mcInvites`
--

CREATE TABLE IF NOT EXISTS `mcInvites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `invited_id` int(11) NOT NULL,
  `code` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `used` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

--
-- Дамп данных таблицы `mcInvites`
--

INSERT INTO `mcInvites` (`id`, `owner_id`, `invited_id`, `code`, `used`, `created_at`, `updated_at`) VALUES
(1, 0, 0, '', 0, '2016-08-14 10:12:31', '2016-08-14 10:12:31'),
(2, 1, 7, '103ffd521da3', 1, '2016-08-14 10:25:39', '2016-08-14 16:10:36'),
(3, 1, 0, '8ed2c8aa88c1', 0, '2016-08-14 10:25:39', '2016-08-14 10:25:39'),
(4, 1, 0, '139c66338dd0', 0, '2016-08-14 10:25:39', '2016-08-14 10:25:39'),
(5, 1, 0, '2a1a4870926b', 0, '2016-08-14 10:25:39', '2016-08-14 10:25:39'),
(6, 1, 0, '63c79038d3fd', 0, '2016-08-14 10:25:39', '2016-08-14 10:25:39'),
(7, 1, 0, 'a557a46ae242', 0, '2016-08-14 10:25:39', '2016-08-14 10:25:39'),
(8, 1, 0, '8480abfa5021', 0, '2016-08-14 10:25:39', '2016-08-14 10:25:39'),
(9, 1, 0, '6fa7dac17d2a', 0, '2016-08-14 10:25:39', '2016-08-14 10:25:39'),
(10, 1, 0, '38df5320e325', 0, '2016-08-14 10:25:39', '2016-08-14 10:25:39'),
(11, 1, 0, '75f818c80a74', 0, '2016-08-14 10:25:39', '2016-08-14 10:25:39'),
(12, 7, 0, 'e3b001d2c5cf', 0, '2016-08-14 16:34:29', '2016-08-14 16:34:29'),
(13, 7, 0, 'ebb8b5aaff45', 0, '2016-08-14 16:34:29', '2016-08-14 16:34:29'),
(14, 7, 0, '95b4be7f77ec', 0, '2016-08-14 16:34:29', '2016-08-14 16:34:29'),
(15, 7, 0, '787d00545d50', 0, '2016-08-14 16:34:29', '2016-08-14 16:34:29'),
(16, 7, 0, 'd5dbc7389e6b', 0, '2016-08-14 16:34:29', '2016-08-14 16:34:29'),
(17, 7, 0, '51bc78195609', 0, '2016-08-14 16:34:29', '2016-08-14 16:34:29'),
(18, 7, 0, '59c55a3997ea', 0, '2016-08-14 16:34:29', '2016-08-14 16:34:29'),
(19, 7, 0, '806b492ad04d', 0, '2016-08-14 16:34:30', '2016-08-14 16:34:30'),
(20, 7, 0, '7a83f267c4a3', 0, '2016-08-14 16:34:30', '2016-08-14 16:34:30'),
(21, 7, 0, 'b4265cb890a1', 0, '2016-08-14 16:35:19', '2016-08-14 16:35:19');

-- --------------------------------------------------------

--
-- Структура таблицы `mcKeywords`
--

CREATE TABLE IF NOT EXISTS `mcKeywords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `keyword` varchar(100) NOT NULL,
  `efficiency` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Дамп данных таблицы `mcKeywords`
--

INSERT INTO `mcKeywords` (`id`, `owner_id`, `keyword`, `efficiency`, `created_at`, `updated_at`) VALUES
(1, 1, '#нуженвидеограф', 0, NULL, '2016-05-26 21:09:07'),
(2, 1, '#нуженвидеооператор', 0, '2016-05-21 17:48:25', '2016-05-21 17:48:25'),
(3, 1, '#ищувидеооператора', 0, '2016-05-21 17:48:45', '2016-05-21 17:48:45'),
(4, 1, '#нужновидео', 0, '2016-05-21 17:49:03', '2016-05-21 17:49:03'),
(5, 1, '#нужновидеонасвадьбу', 0, '2016-05-21 17:49:28', '2016-05-21 17:49:28'),
(6, 1, '#скороженимся', 0, '2016-05-21 17:49:58', '2016-05-21 17:49:58'),
(7, 1, '#мыпомолвлены', 0, '2016-05-21 17:50:14', '2016-05-21 17:50:14'),
(8, 1, '#скоросвадьба', 0, '2016-05-21 17:50:24', '2016-05-21 17:50:24'),
(9, 1, '#ясделалпредложение', 0, '2016-05-21 17:50:38', '2016-05-21 17:50:38'),
(10, 1, '#онасказалада', 0, '2016-05-21 17:50:48', '2016-05-21 17:50:48'),
(11, 1, '#мояневеста', 0, '2016-05-21 17:51:01', '2016-05-21 17:51:01'),
(13, 1, '#подализаявлениевзагс', 0, '2016-05-21 17:54:24', '2016-05-21 17:54:24'),
(14, 1, '#заявлениевзагс', 0, '2016-05-21 17:54:39', '2016-05-21 17:54:39'),
(15, 1, '#делаюпредложение', 0, '2016-05-21 17:54:50', '2016-05-21 17:54:50'),
(16, 1, '#нуженфотограф', 94, '2016-05-21 17:55:00', '2016-06-11 19:18:16'),
(18, 1, '#нужнофотонасвадьбу', 0, '2016-05-21 17:55:28', '2016-05-21 17:55:28'),
(19, 1, '#мойжених', 0, '2016-05-21 17:55:41', '2016-05-21 17:55:41'),
(20, 1, '#женихмой', 0, '2016-05-21 17:55:53', '2016-05-21 17:55:53'),
(21, 1, '#женихиневеста', 0, '2016-05-21 17:56:07', '2016-05-21 17:56:07'),
(22, 1, '#жених', 0, '2016-05-21 17:56:20', '2016-05-21 17:56:20'),
(23, 1, 'оператор', 0, '2016-05-21 18:45:36', '2016-05-26 21:09:08'),
(24, 1, 'фотографа', 6, '2016-05-21 18:45:51', '2016-06-03 17:36:44'),
(25, 1, 'фотограф', 21, '2016-05-21 18:45:55', '2016-06-11 19:18:16'),
(26, 1, 'видео-оператор', 0, '2016-05-21 18:46:26', '2016-05-21 18:46:26'),
(27, 1, 'видеооператор', 3, '2016-05-21 18:46:33', '2016-06-03 17:36:44'),
(28, 1, 'фотографы', 0, '2016-05-30 20:28:47', '2016-05-30 20:28:47'),
(29, 1, '#нужнофото', 0, '2016-06-11 18:39:10', '2016-06-11 18:39:10');

-- --------------------------------------------------------

--
-- Структура таблицы `mcPosts`
--

CREATE TABLE IF NOT EXISTS `mcPosts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `vk_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `owner_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `from_id` int(11) NOT NULL,
  `signer_id` int(11) NOT NULL,
  `sent` tinyint(1) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vk_id` (`vk_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Дамп данных таблицы `mcPosts`
--

INSERT INTO `mcPosts` (`id`, `user_id`, `vk_id`, `owner_id`, `owner_name`, `from_id`, `signer_id`, `sent`, `date`, `text`, `created_at`, `updated_at`) VALUES
(10, 1, 56197, -68937293, 'EventHunt LOW COST - предложения, TFP.', -68937293, 0, 0, 1465663742, '<br>1.Видео, фото\n<br>2.актер\n<br>3.диджей\n<br>4.звукооператор\n\n<br>1.Срочно требуются на завтра видеограф и<b> фотограф </b>на условиях TFP на сьемках клипа начинающей певицы . DANCE. Крутая команда. Питание) <br><a href=https://vk.com/metelevat>https://vk.com/metelevat</a>\n\n<br>2.МОСКВА\n12 июня длля съемки в многосерийном фильме "Артист" требуется\n"Охранник"- мужчина фактурной внешности(рост 185 и выше), спортивного телосложения. Возраст 35-45 лет\nЗанятость с 19.00 вечера до 23.30 вечера. \nОплата 1500 руб.\nДва съемочных дня( второй день 29 июня)\nФото, информацию о себе в личку <br><a href=https://vk.com/id250962244>https://vk.com/id250962244</a>\n\n<br>3.Нужен диджей на сегодня с контроллером <br><a href=https://vk.com/idilg>https://vk.com/idilg</a>\n\n<br>4.Звукооператор в караоке на юге Москвы , сегодня, срочно. С 00:00 до 5:00, оплата 2000 руб. <br><a href=https://vk.com/shokoladmoscow>https://vk.com/shokoladmoscow</a>', '2016-06-11 19:18:15', '2016-06-11 19:18:15'),
(11, 1, 1861, -93682417, 'Event Hunt - Доска нужных объявлений', -93682417, 337098519, 0, 1465574436, 'Требуется 17 июля<b> фотограф </b>на девичник. Территориально Одинцово. Время работы с 14.00 до 16.30, от вас оригинальные идеи приветствуются!', '2016-06-11 19:18:16', '2016-06-11 19:18:16'),
(12, 1, 10206, -99360420, 'Ищу фотографа, видеографа: агрегатор объявлений', -99360420, 3645940, 0, 1465677504, '<br>#Питер <br>#спб <br>#ищуфотографа<b> <br>#нуженфотограф </b>www.shikari.do\n\nСрочно нуждаюсь в Танцующей Балерине, ассистентке Сумасшедщего, вечнообучающегося <br>#Фотографа, для воплощения мыслкй прожектерских.\n\nАвтор: <br><a href=https://vk.com/id3645940>https://vk.com/id3645940</a>\nСсылка: <br><a href=http://vk.com/wall3645940_7110>http://vk.com/wall3645940_7110</a>\nНайдено: 10 июня, 19:01', '2016-06-11 19:18:16', '2016-06-11 19:18:16'),
(13, 1, 10204, -99360420, 'Ищу фотографа, видеографа: агрегатор объявлений', -99360420, 1338901, 0, 1465673964, '<br>#Москва <br>#мск <br>#ищуфотографа<b> <br>#нуженфотограф </b>www.shikari.do\n\nДорогие друзья-фотографы.\nНужны Ваши услуги на 2 июля поснимать <br>#свадьбу хороших друзей.\nС 13 до 17 (можно дольше)\nПеред загсом чуть-чуть - загс - после ресторан \n<br>#Альбом не нужен \nМетро бабушкинская\nСвои предложения в личку,пожалуйста.\nЗаранее спасибо!\n\nАвтор: <br><a href=https://vk.com/panchekhina>https://vk.com/panchekhina</a>\nСсылка: <br><a href=http://vk.com/wall1338901_2405>http://vk.com/wall1338901_2405</a>\nНайдено: 10 июня, 13:27', '2016-06-11 19:18:17', '2016-06-11 19:18:17');

-- --------------------------------------------------------

--
-- Структура таблицы `mcProposals`
--

CREATE TABLE IF NOT EXISTS `mcProposals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `mcProposals`
--

INSERT INTO `mcProposals` (`id`, `owner_id`, `text`, `created_at`, `updated_at`) VALUES
(7, 1, 'Тест', '2016-05-31 21:06:33', '2016-05-31 21:06:33');

-- --------------------------------------------------------

--
-- Структура таблицы `mcSettings`
--

CREATE TABLE IF NOT EXISTS `mcSettings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `secret_key` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `admin_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `xmpp` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `xmpp2` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `xmpp3` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `send_proposal` tinyint(1) NOT NULL DEFAULT '0',
  `scan_depth` int(3) NOT NULL DEFAULT '5',
  `scan_freq` int(11) NOT NULL,
  `register_deny` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2;

--
-- Дамп данных таблицы `mcSettings`
--

INSERT INTO `mcSettings` (`id`, `owner_id`, `client_id`, `secret_key`, `access_token`, `admin_email`, `xmpp`, `xmpp2`, `xmpp3`, `send_proposal`, `scan_depth`, `scan_freq`, `register_deny`, `created_at`, `updated_at`) VALUES
(1, 1, 5472275, 'EETXFY9FhnT2vrscS8PQ', 'de40360d2a49cb6721b858bcedbab580dc5bb02184951dc96edb433d08aebd556809d5c670f074d5291bf', 'vr5@bk.ru', 'vr5@jabberzac.org', '', '', 0, 5, 1, 1, '2016-05-22 19:11:08', '2016-08-15 17:20:53');


-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_05_20_154525_mcPromo', 1),
('2014_07_02_230147_migration_cartalyst_sentinel', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `persistences`
--

CREATE TABLE IF NOT EXISTS `persistences` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `persistences_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Дамп данных таблицы `persistences`
--

INSERT INTO `persistences` (`id`, `user_id`, `code`, `created_at`, `updated_at`) VALUES
(5, 1, '0y5xLPP3u2eQwcRRTVKedZDb0Yen3Pej', '2016-06-03 20:47:55', '2016-06-03 20:47:55'),
(7, 1, 'db4tHjPGhSIsQtvuSZwIGzMT1H0XhDgY', '2016-06-06 16:30:18', '2016-06-06 16:30:18'),
(9, 2, 'xsMll7DdNpCP5D3lS9a3H37FCd0UWGUI', '2016-06-27 18:30:19', '2016-06-27 18:30:19'),
(10, 1, 'px5bt4S5AZzUeKfAyGirKUxYgizRahxe', '2016-07-01 18:22:54', '2016-07-01 18:22:54'),
(11, 1, 'AYBUS4lPIh6J8IxB7uxIw3NyQFVbuFuc', '2016-07-20 18:20:07', '2016-07-20 18:20:07'),
(12, 1, 'umGtDRHZ5zAdUsh2TUqC2Vkz0fZp50nl', '2016-08-14 08:58:08', '2016-08-14 08:58:08'),
(13, 1, 'WIxnQp6KnrsR6ts5aAVhWaA7QxlIvBUk', '2016-08-15 15:54:41', '2016-08-15 15:54:41');

-- --------------------------------------------------------

--
-- Структура таблицы `reminders`
--

CREATE TABLE IF NOT EXISTS `reminders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `slug`, `name`, `permissions`, `created_at`, `updated_at`) VALUES
(1, 'administrators', 'Administrators', '{"user.create":true,"user.delete":true,"user.view":true,"user.update":true}', '2016-05-25 19:07:34', '2016-05-25 19:07:34'),
(2, 'users', 'Users', '{"user.create":false,"user.delete":false,"user.view":true,"user.update":false}', '2016-05-25 19:07:34', '2016-05-25 19:07:34');

-- --------------------------------------------------------

--
-- Структура таблицы `role_users`
--

CREATE TABLE IF NOT EXISTS `role_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `role_users`
--

INSERT INTO `role_users` (`user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2016-05-26 19:36:35', '2016-05-26 19:36:35');


-- --------------------------------------------------------

--
-- Структура таблицы `throttle`
--

CREATE TABLE IF NOT EXISTS `throttle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `throttle_user_id_index` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

--
-- Дамп данных таблицы `throttle`
--

INSERT INTO `throttle` (`id`, `user_id`, `type`, `ip`, `created_at`, `updated_at`) VALUES
(1, NULL, 'global', NULL, '2016-05-25 19:30:57', '2016-05-25 19:30:57'),
(2, NULL, 'ip', '127.0.0.1', '2016-05-25 19:30:57', '2016-05-25 19:30:57'),
(3, NULL, 'global', NULL, '2016-05-25 19:31:31', '2016-05-25 19:31:31'),
(4, NULL, 'ip', '127.0.0.1', '2016-05-25 19:31:31', '2016-05-25 19:31:31'),
(5, NULL, 'global', NULL, '2016-05-25 19:31:33', '2016-05-25 19:31:33'),
(6, NULL, 'ip', '127.0.0.1', '2016-05-25 19:31:33', '2016-05-25 19:31:33'),
(7, NULL, 'global', NULL, '2016-05-25 19:31:34', '2016-05-25 19:31:34'),
(8, NULL, 'ip', '127.0.0.1', '2016-05-25 19:31:34', '2016-05-25 19:31:34'),
(9, NULL, 'global', NULL, '2016-05-25 19:31:53', '2016-05-25 19:31:53'),
(10, NULL, 'ip', '127.0.0.1', '2016-05-25 19:31:53', '2016-05-25 19:31:53'),
(11, NULL, 'global', NULL, '2016-06-16 17:29:07', '2016-06-16 17:29:07'),
(12, NULL, 'ip', '127.0.0.1', '2016-06-16 17:29:07', '2016-06-16 17:29:07'),
(13, NULL, 'global', NULL, '2016-06-16 17:33:02', '2016-06-16 17:33:02'),
(14, NULL, 'ip', '127.0.0.1', '2016-06-16 17:33:02', '2016-06-16 17:33:02'),
(15, NULL, 'global', NULL, '2016-06-16 17:33:04', '2016-06-16 17:33:04'),
(16, NULL, 'ip', '127.0.0.1', '2016-06-16 17:33:04', '2016-06-16 17:33:04'),
(17, NULL, 'global', NULL, '2016-06-16 17:34:23', '2016-06-16 17:34:23'),
(18, NULL, 'ip', '127.0.0.1', '2016-06-16 17:34:23', '2016-06-16 17:34:23'),
(19, NULL, 'global', NULL, '2016-06-16 17:34:53', '2016-06-16 17:34:53'),
(20, NULL, 'ip', '127.0.0.1', '2016-06-16 17:34:53', '2016-06-16 17:34:53'),
(21, NULL, 'global', NULL, '2016-06-16 17:36:47', '2016-06-16 17:36:47'),
(22, NULL, 'ip', '127.0.0.1', '2016-06-16 17:36:47', '2016-06-16 17:36:47'),
(23, NULL, 'global', NULL, '2016-06-16 17:44:33', '2016-06-16 17:44:33'),
(24, NULL, 'ip', '127.0.0.1', '2016-06-16 17:44:33', '2016-06-16 17:44:33'),
(25, NULL, 'global', NULL, '2016-06-16 17:48:06', '2016-06-16 17:48:06'),
(26, NULL, 'ip', '127.0.0.1', '2016-06-16 17:48:06', '2016-06-16 17:48:06'),
(27, NULL, 'global', NULL, '2016-06-16 17:48:36', '2016-06-16 17:48:36'),
(28, NULL, 'ip', '127.0.0.1', '2016-06-16 17:48:36', '2016-06-16 17:48:36');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `last_login` timestamp NULL DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `permissions`, `last_login`, `first_name`, `last_name`, `created_at`, `updated_at`) VALUES
(1, 'vr5@bk.ru', '$2y$10$XUd8nd2g7/WrY/jrmqgwLucGe5.VujlhIwa5sFKgjcTKmRaxIZN86', NULL, '2016-08-15 15:54:41', NULL, NULL, '2016-05-26 19:24:12', '2016-08-15 15:54:41');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
