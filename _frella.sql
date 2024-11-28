CREATE DATABASE _freela;

USE _freela;

-- CRIAÇÃO TABELA DE USUARIOS --
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `profile_pic` varchar(255) NOT NULL DEFAULT 'default_profile.jpg',
  `age` int(3) NOT NULL DEFAULT 0,
  `bio` varchar(400) NOT NULL DEFAULT 'Sem bio ainda',
  `job` varchar(200) NOT NULL DEFAULT 'Sem emprego',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
);

Select * from users;