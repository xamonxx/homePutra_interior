-- Calculator Budget Planner Database Schema
-- Home Putra Interior

-- Products Table
CREATE TABLE IF NOT EXISTS `calculator_products` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(100) UNIQUE NOT NULL,
    `description` TEXT,
    `icon` VARCHAR(50) DEFAULT 'chair',
    `display_order` INT DEFAULT 0,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Materials Table
CREATE TABLE IF NOT EXISTS `calculator_materials` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(100) UNIQUE NOT NULL,
    `grade` ENUM('A', 'B', 'C') DEFAULT 'B',
    `description` TEXT,
    `is_waterproof` TINYINT(1) DEFAULT 0,
    `is_termite_resistant` TINYINT(1) DEFAULT 0,
    `display_order` INT DEFAULT 0,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Product-Material Availability
CREATE TABLE IF NOT EXISTS `calculator_product_materials` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `product_id` INT NOT NULL,
    `material_id` INT NOT NULL,
    `is_available` TINYINT(1) DEFAULT 1,
    FOREIGN KEY (`product_id`) REFERENCES `calculator_products`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`material_id`) REFERENCES `calculator_materials`(`id`) ON DELETE CASCADE,
    UNIQUE KEY `product_material` (`product_id`, `material_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Models/Styles Table
CREATE TABLE IF NOT EXISTS `calculator_models` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(100) UNIQUE NOT NULL,
    `price_multiplier` DECIMAL(3,2) DEFAULT 1.00,
    `display_order` INT DEFAULT 0,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Pricing Table (harga per meter)
CREATE TABLE IF NOT EXISTS `calculator_prices` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `product_id` INT NOT NULL,
    `material_id` INT NOT NULL,
    `model_id` INT NOT NULL,
    `location_type` ENUM('dalam_kota', 'luar_kota') NOT NULL,
    `price_per_meter` DECIMAL(12,0) NOT NULL,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`product_id`) REFERENCES `calculator_products`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`material_id`) REFERENCES `calculator_materials`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`model_id`) REFERENCES `calculator_models`(`id`) ON DELETE CASCADE,
    UNIQUE KEY `price_combo` (`product_id`, `material_id`, `model_id`, `location_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Shipping Costs Table
CREATE TABLE IF NOT EXISTS `calculator_shipping` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `min_total` DECIMAL(15,0) NOT NULL,
    `max_total` DECIMAL(15,0),
    `shipping_cost` DECIMAL(12,0) NOT NULL,
    `location_type` ENUM('dalam_kota', 'luar_kota') NOT NULL,
    `description` VARCHAR(255),
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY `shipping_range` (`min_total`, `location_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Additional Costs Table
CREATE TABLE IF NOT EXISTS `calculator_additional_costs` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(100) UNIQUE NOT NULL,
    `cost_type` ENUM('fixed', 'percentage') DEFAULT 'fixed',
    `cost_value` DECIMAL(12,2) NOT NULL,
    `description` TEXT,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Estimates History Table
CREATE TABLE IF NOT EXISTS `calculator_estimates` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `estimate_code` VARCHAR(20) UNIQUE NOT NULL,
    `customer_name` VARCHAR(100),
    `customer_phone` VARCHAR(20),
    `customer_email` VARCHAR(255),
    `location_type` ENUM('dalam_kota', 'luar_kota') NOT NULL,
    `product_id` INT NOT NULL,
    `material_id` INT NOT NULL,
    `model_id` INT NOT NULL,
    `length_meter` DECIMAL(5,2) NOT NULL,
    `price_per_meter` DECIMAL(12,0) NOT NULL,
    `subtotal` DECIMAL(15,0) NOT NULL,
    `shipping_cost` DECIMAL(12,0) DEFAULT 0,
    `additional_costs` DECIMAL(12,0) DEFAULT 0,
    `grand_total` DECIMAL(15,0) NOT NULL,
    `notes` TEXT,
    `created_by` INT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`product_id`) REFERENCES `calculator_products`(`id`),
    FOREIGN KEY (`material_id`) REFERENCES `calculator_materials`(`id`),
    FOREIGN KEY (`model_id`) REFERENCES `calculator_models`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert Default Products
INSERT IGNORE INTO `calculator_products` (`name`, `slug`, `icon`, `display_order`) VALUES
('Kitchen Set', 'kitchen-set', 'countertops', 1),
('Wardrobe / Lemari', 'wardrobe', 'door_sliding', 2),
('Backdrop TV', 'backdrop-tv', 'tv', 3),
('Wallpanel', 'wallpanel', 'dashboard', 4);

-- Insert Default Materials
INSERT IGNORE INTO `calculator_materials` (`name`, `slug`, `grade`, `is_waterproof`, `is_termite_resistant`, `display_order`) VALUES
('Aluminium + ACP', 'aluminium-acp', 'A', 1, 1, 1),
('PVC Board', 'pvc-board', 'B', 1, 1, 2),
('Multipleks HPL', 'multipleks-hpl', 'B', 0, 0, 3),
('Multipleks Duco', 'multipleks-duco', 'B', 0, 0, 4),
('Blockboard', 'blockboard', 'C', 0, 0, 5);

-- Insert Default Models
INSERT IGNORE INTO `calculator_models` (`name`, `slug`, `price_multiplier`, `display_order`) VALUES
('Minimalis', 'minimalis', 1.00, 1),
('Semi Klasik', 'semi-klasik', 1.15, 2),
('Klasik', 'klasik', 1.25, 3),
('Luxury', 'luxury', 1.40, 4);

-- Insert Default Shipping Costs
INSERT IGNORE INTO `calculator_shipping` (`min_total`, `max_total`, `shipping_cost`, `location_type`, `description`) VALUES
(0, 14999999, 500000, 'dalam_kota', 'Ongkir standar dalam kota'),
(15000000, 19999999, 1000000, 'dalam_kota', 'Ongkir luar area inti'),
(20000000, NULL, 0, 'dalam_kota', 'Gratis ongkir'),
(0, 14999999, 750000, 'luar_kota', 'Ongkir standar luar kota'),
(15000000, 19999999, 1500000, 'luar_kota', 'Ongkir luar area inti'),
(20000000, NULL, 0, 'luar_kota', 'Gratis ongkir');

-- Insert Additional Costs
INSERT IGNORE INTO `calculator_additional_costs` (`name`, `slug`, `cost_type`, `cost_value`, `description`) VALUES
('Aksesoris Tambahan', 'aksesoris', 'percentage', 5.00, 'Biaya aksesoris tambahan 5%'),
('Finishing Khusus', 'finishing-khusus', 'percentage', 10.00, 'Finishing premium/custom 10%');

-- Insert Product-Material Availability
INSERT IGNORE INTO `calculator_product_materials` (`product_id`, `material_id`) 
SELECT p.id, m.id FROM calculator_products p, calculator_materials m;

-- Insert Kitchen Set Prices (Dalam Kota)
INSERT IGNORE INTO `calculator_prices` (`product_id`, `material_id`, `model_id`, `location_type`, `price_per_meter`) VALUES
-- Kitchen Set - Aluminium + ACP
(1, 1, 1, 'dalam_kota', 3500000), -- Minimalis
(1, 1, 2, 'dalam_kota', 4500000), -- Premium/Semi Klasik  
(1, 1, 3, 'dalam_kota', 5000000), -- Klasik
(1, 1, 4, 'dalam_kota', 5500000), -- Luxury
-- Kitchen Set - PVC Board
(1, 2, 1, 'dalam_kota', 4000000),
(1, 2, 2, 'dalam_kota', 4500000),
(1, 2, 3, 'dalam_kota', 5000000),
(1, 2, 4, 'dalam_kota', 5500000),
-- Kitchen Set - Multipleks HPL
(1, 3, 1, 'dalam_kota', 2500000),
(1, 3, 2, 'dalam_kota', 2800000),
(1, 3, 3, 'dalam_kota', 3200000),
(1, 3, 4, 'dalam_kota', 3500000),
-- Kitchen Set - Multipleks Duco
(1, 4, 1, 'dalam_kota', 4500000),
(1, 4, 2, 'dalam_kota', 5000000),
(1, 4, 3, 'dalam_kota', 5500000),
(1, 4, 4, 'dalam_kota', 6000000),
-- Kitchen Set - Blockboard
(1, 5, 1, 'dalam_kota', 2000000),
(1, 5, 2, 'dalam_kota', 2300000),
(1, 5, 3, 'dalam_kota', 2600000),
(1, 5, 4, 'dalam_kota', 2900000);

-- Insert Kitchen Set Prices (Luar Kota)
INSERT IGNORE INTO `calculator_prices` (`product_id`, `material_id`, `model_id`, `location_type`, `price_per_meter`) VALUES
(1, 1, 1, 'luar_kota', 3500000),
(1, 1, 2, 'luar_kota', 4500000),
(1, 1, 3, 'luar_kota', 5000000),
(1, 1, 4, 'luar_kota', 5500000),
(1, 2, 1, 'luar_kota', 4100000),
(1, 2, 2, 'luar_kota', 4600000),
(1, 2, 3, 'luar_kota', 5100000),
(1, 2, 4, 'luar_kota', 5600000),
(1, 3, 1, 'luar_kota', 2600000),
(1, 3, 2, 'luar_kota', 2900000),
(1, 3, 3, 'luar_kota', 3300000),
(1, 3, 4, 'luar_kota', 3600000),
(1, 4, 1, 'luar_kota', 4000000),
(1, 4, 2, 'luar_kota', 4500000),
(1, 4, 3, 'luar_kota', 5000000),
(1, 4, 4, 'luar_kota', 5500000),
(1, 5, 1, 'luar_kota', 2300000),
(1, 5, 2, 'luar_kota', 2600000),
(1, 5, 3, 'luar_kota', 2900000),
(1, 5, 4, 'luar_kota', 3200000);

-- Insert Wardrobe Prices (Dalam Kota)
INSERT IGNORE INTO `calculator_prices` (`product_id`, `material_id`, `model_id`, `location_type`, `price_per_meter`) VALUES
(2, 3, 1, 'dalam_kota', 2500000),
(2, 3, 2, 'dalam_kota', 2800000),
(2, 3, 3, 'dalam_kota', 3100000),
(2, 3, 4, 'dalam_kota', 3400000),
(2, 5, 1, 'dalam_kota', 2300000),
(2, 5, 2, 'dalam_kota', 2600000),
(2, 5, 3, 'dalam_kota', 2900000),
(2, 5, 4, 'dalam_kota', 3200000);

-- Insert Wardrobe Prices (Luar Kota)
INSERT IGNORE INTO `calculator_prices` (`product_id`, `material_id`, `model_id`, `location_type`, `price_per_meter`) VALUES
(2, 3, 1, 'luar_kota', 2600000),
(2, 3, 2, 'luar_kota', 2900000),
(2, 3, 3, 'luar_kota', 3200000),
(2, 3, 4, 'luar_kota', 3500000),
(2, 5, 1, 'luar_kota', 2400000),
(2, 5, 2, 'luar_kota', 2700000),
(2, 5, 3, 'luar_kota', 3000000),
(2, 5, 4, 'luar_kota', 3300000);

-- Insert Backdrop TV Prices
INSERT IGNORE INTO `calculator_prices` (`product_id`, `material_id`, `model_id`, `location_type`, `price_per_meter`) VALUES
(3, 3, 1, 'dalam_kota', 2300000),
(3, 3, 2, 'dalam_kota', 2600000),
(3, 3, 3, 'dalam_kota', 2900000),
(3, 3, 4, 'dalam_kota', 3200000),
(3, 5, 1, 'dalam_kota', 2100000),
(3, 5, 2, 'dalam_kota', 2400000),
(3, 5, 3, 'dalam_kota', 2700000),
(3, 5, 4, 'dalam_kota', 3000000),
(3, 3, 1, 'luar_kota', 2400000),
(3, 3, 2, 'luar_kota', 2700000),
(3, 3, 3, 'luar_kota', 3000000),
(3, 3, 4, 'luar_kota', 3300000),
(3, 5, 1, 'luar_kota', 2100000),
(3, 5, 2, 'luar_kota', 2400000),
(3, 5, 3, 'luar_kota', 2700000),
(3, 5, 4, 'luar_kota', 3000000);

-- Insert Wallpanel Prices (WPC)
INSERT IGNORE INTO `calculator_prices` (`product_id`, `material_id`, `model_id`, `location_type`, `price_per_meter`) VALUES
(4, 2, 1, 'dalam_kota', 850000),
(4, 2, 2, 'dalam_kota', 950000),
(4, 2, 3, 'dalam_kota', 1050000),
(4, 2, 4, 'dalam_kota', 1150000),
(4, 2, 1, 'luar_kota', 950000),
(4, 2, 2, 'luar_kota', 1050000),
(4, 2, 3, 'luar_kota', 1150000),
(4, 2, 4, 'luar_kota', 1250000);
