-- ============================================================
-- CƠ SỞ DỮ LIỆU: web2041_project
-- Schema được dựng lại từ các câu SQL trong thư mục models/
-- Cách chạy: mở HeidiSQL / phpMyAdmin -> Import file này
-- Hoặc CLI: mysql -u root < database.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS `web2041_project`
    DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `web2041_project`;

-- ------------------------------------------------------------
-- users
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
    `id`       INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(100) NOT NULL UNIQUE,
    `email`    VARCHAR(150) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL             COMMENT 'Hash bcrypt (password_hash)',
    `is_main`  TINYINT(1) NOT NULL DEFAULT 0     COMMENT '1 = admin, 0 = khách hàng',
    `status`   TINYINT(1) NOT NULL DEFAULT 1     COMMENT '1 = hoạt động, 0 = bị khóa',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- categories
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `categories` (
    `id`          INT AUTO_INCREMENT PRIMARY KEY,
    `name`        VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `status`      TINYINT(1) NOT NULL DEFAULT 1  COMMENT '1 = hiện, 0 = ẩn'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- products
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `products` (
    `id`          INT AUTO_INCREMENT PRIMARY KEY,
    `category_id` INT NOT NULL,
    `name`        VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `price`       DECIMAL(15,0) NOT NULL DEFAULT 0,
    `quantity`    INT NOT NULL DEFAULT 0         COMMENT 'Tồn kho',
    `image`       VARCHAR(255) NULL              COMMENT 'Đường dẫn tương đối trong assets/uploads/',
    `weights`     VARCHAR(100) NULL              COMMENT 'Khối lượng / dung tích',
    `view_count`  INT NOT NULL DEFAULT 0,
    `status`      TINYINT(1) NOT NULL DEFAULT 1  COMMENT '1 = hiện, 0 = ẩn',
    FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- comments
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `comments` (
    `id`         INT AUTO_INCREMENT PRIMARY KEY,
    `product_id` INT NOT NULL,
    `user_id`    INT NOT NULL,
    `content`    TEXT NOT NULL,
    `status`     TINYINT(1) NOT NULL DEFAULT 1  COMMENT '1 = duyệt, 0 = ẩn',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`user_id`)    REFERENCES `users`(`id`)    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- orders
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `orders` (
    `id`               INT AUTO_INCREMENT PRIMARY KEY,
    `user_id`          INT NULL                 COMMENT 'NULL = khách vãng lai',
    `customer_name`    VARCHAR(255) NOT NULL,
    `customer_phone`   VARCHAR(20)  NOT NULL,
    `customer_address` TEXT         NOT NULL,
    `note`             TEXT NULL,
    `total_price`      DECIMAL(15,0) NOT NULL,
    `status`           ENUM('pending','confirmed','shipping','completed','cancelled')
                       NOT NULL DEFAULT 'pending',
    `payment_method`   VARCHAR(20) NOT NULL DEFAULT 'cod'  COMMENT 'cod | momo',
    `payment_status`   ENUM('unpaid','pending','paid','failed')
                       NOT NULL DEFAULT 'unpaid',
    `momo_trans_id`    VARCHAR(100) NULL,
    `created_at`       DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- order_items
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `order_items` (
    `id`         INT AUTO_INCREMENT PRIMARY KEY,
    `order_id`   INT NOT NULL,
    `product_id` INT NOT NULL,
    `quantity`   INT NOT NULL,
    `price`      DECIMAL(15,0) NOT NULL         COMMENT 'Giá tại thời điểm đặt',
    FOREIGN KEY (`order_id`)   REFERENCES `orders`(`id`)   ON DELETE CASCADE,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- DỮ LIỆU MẪU
-- Mật khẩu của cả 2 tài khoản dưới đây đều là: 123456
-- ============================================================

INSERT INTO `users` (`username`, `email`, `password`, `is_main`, `status`) VALUES
('admin', 'admin@gmail.com', '$2y$10$QTIP3/74i/JH2zzw5viVwu98Sw8BX8.iWO3PNm8c1jDmgI.Q31gpO', 1, 1),
('user1', 'user1@gmail.com', '$2y$10$QTIP3/74i/JH2zzw5viVwu98Sw8BX8.iWO3PNm8c1jDmgI.Q31gpO', 0, 1);

INSERT INTO `categories` (`name`, `description`, `status`) VALUES
('Cà phê',   'Các loại cà phê rang xay', 1),
('Trà',      'Trà túi lọc và trà khô',   1),
('Phụ kiện', 'Dụng cụ pha chế',          1);

INSERT INTO `products` (`category_id`, `name`, `description`, `price`, `quantity`, `image`, `weights`, `view_count`, `status`) VALUES
(1, 'Cà phê Arabica',  'Hạt Arabica Cầu Đất rang mộc',      120000, 50, NULL, '250g', 128, 1),
(1, 'Cà phê Robusta',  'Hạt Robusta Đắk Lắk đậm vị',         95000, 40, NULL, '500g',  96, 1),
(2, 'Trà Ô Long',      'Trà Ô Long Thái Nguyên',            150000, 30, NULL, '100g', 205, 1),
(3, 'Phin pha cà phê', 'Phin nhôm truyền thống cỡ vừa',      45000, 25, NULL, NULL,    47, 1);
