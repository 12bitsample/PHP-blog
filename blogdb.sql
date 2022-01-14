drop database if exists blogdb;
create database if not exists blogdb;

use blogdb;

CREATE TABLE `users` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('Author','Admin') DEFAULT NULL,
  `password` char(60) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
);

CREATE TABLE `posts` (
 `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 `user_id` int(11) DEFAULT NULL,
 `title` varchar(255) NOT NULL,
 `slug` varchar(255) NOT NULL UNIQUE,
 `views` int(11) NOT NULL DEFAULT '0',
 `image` varchar(255) NOT NULL,
 `body` text NOT NULL,
 `published` tinyint(1) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
  );
  
  INSERT INTO `users` (`id`, `username`, `email`, `role`, `password`, `created_at`, `updated_at`) VALUES
(1, 'mahcull', 'mmcadow@student.cscc.edu', 'Admin', 'safepassword', '2021-01-08 12:52:58', '2021-01-08 12:52:58');

INSERT INTO `posts` (`id`, `user_id`, `title`, `slug`, `views`, `image`, `body`, `published`, `created_at`, `updated_at`) VALUES
(1, 1, 'On the topic of Eurorack', 0, 'first-post-on-blog', 'banner.jpg', 'I am a big fan of this format and recommend everyone that likes music check it out.', 1, '2021-02-03 07:58:02', '2021-02-01 19:14:31'),
(2, 1, 'Big Muff: The Classic Fuzz', 'second-post-on-blog', 0, 'banner.jpg', 'One of the iconic distortion pedals of all time, the Big Muff haas been used by bands like The Smashing Pumpkins, Sonic Youth and Muse.', 0, '2021-02-02 11:40:14', '2021-02-01 13:04:36');
  
  select * from users