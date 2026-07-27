-- Khởi tạo cơ sở dữ liệu cho dự án
-- Chạy trong HeidiSQL / phpMyAdmin của Laragon

CREATE DATABASE IF NOT EXISTS `web2041_project`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `web2041_project`;

-- Bảng mẫu, xoá hoặc sửa lại theo nhu cầu dự án
CREATE TABLE IF NOT EXISTS `users` (
    `id`         INT AUTO_INCREMENT PRIMARY KEY,
    `name`       VARCHAR(100)  NOT NULL,
    `email`      VARCHAR(150)  NOT NULL UNIQUE,
    `password`   VARCHAR(255)  NOT NULL,
    `role`       ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    `created_at` TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
