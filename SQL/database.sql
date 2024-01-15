DROP DATABASE IF EXISTS `jrcsalter`;

CREATE DATABASE IF NOT EXISTS `jrcsalter`;

USE `jrcsalter`;

DROP TABLE IF EXISTS `users`;

CREATE TABLE IF NOT EXISTS `users` (
    `id`         INT          AUTO_INCREMENT PRIMARY KEY,
    `first_name` VARCHAR(255) NOT NULL,
    `last_name`  VARCHAR(255) NOT NULL,
    `username`   VARCHAR(255) NOT NULL UNIQUE,
    `email`      VARCHAR(255) NOT NULL UNIQUE,
    `password`   VARCHAR(255) NOT NULL,
    `birthday`   TIMESTAMP,
    `created_at` TIMESTAMP    NOT NULL DEFAULT NOW(),
    `updated_at` TIMESTAMP    NOT NULL DEFAULT NOW() ON UPDATE NOW()
);

DROP TABLE IF EXISTS `posts`;

CREATE TABLE IF NOT EXISTS `posts` (
    `id`         INT          AUTO_INCREMENT PRIMARY KEY,
    `title`      VARCHAR(255) NOT NULL,
    `content`    TEXT         NOT NULL,
    `user_id`    INT          NOT NULL,
    `created_at` TIMESTAMP    NOT NULL DEFAULT NOW(),
    `updated_at` TIMESTAMP    NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);

DROP TABLE IF EXISTS `comments`;

CREATE TABLE IF NOT EXISTS `comments` (
    `id`         INT          AUTO_INCREMENT PRIMARY KEY,
    `content`    TEXT         NOT NULL,
    `user_id`    INT          NOT NULL,
    `post_id`    INT          NOT NULL,
    `created_at` TIMESTAMP    NOT NULL DEFAULT NOW(),
    `updated_at` TIMESTAMP    NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
    FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`)
);