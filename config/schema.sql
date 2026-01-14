-- Home Putra Interior CMS Database Schema

-- Site Settings Table
CREATE TABLE IF NOT EXISTS `site_settings` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `setting_key` VARCHAR(100) UNIQUE NOT NULL,
    `setting_value` TEXT,
    `setting_type` ENUM('text', 'textarea', 'image', 'number', 'boolean') DEFAULT 'text',
    `setting_group` VARCHAR(50) DEFAULT 'general',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Hero Section Table
CREATE TABLE IF NOT EXISTS `hero_section` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `subtitle` TEXT,
    `background_image` VARCHAR(255),
    `button1_text` VARCHAR(100),
    `button1_link` VARCHAR(255),
    `button2_text` VARCHAR(100),
    `button2_link` VARCHAR(255),
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Statistics Table
CREATE TABLE IF NOT EXISTS `statistics` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `stat_number` VARCHAR(20) NOT NULL,
    `stat_suffix` VARCHAR(10),
    `stat_label` VARCHAR(100) NOT NULL,
    `display_order` INT DEFAULT 0,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Portfolio Table
CREATE TABLE IF NOT EXISTS `portfolio` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `category` VARCHAR(100),
    `description` TEXT,
    `image` VARCHAR(255),
    `display_order` INT DEFAULT 0,
    `is_featured` TINYINT(1) DEFAULT 0,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Services Table
CREATE TABLE IF NOT EXISTS `services` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `icon` VARCHAR(100) DEFAULT 'home',
    `display_order` INT DEFAULT 0,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Testimonials Table
CREATE TABLE IF NOT EXISTS `testimonials` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `client_name` VARCHAR(100) NOT NULL,
    `client_location` VARCHAR(100),
    `client_image` VARCHAR(255),
    `testimonial_text` TEXT NOT NULL,
    `rating` INT DEFAULT 5,
    `display_order` INT DEFAULT 0,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Contact Submissions Table
CREATE TABLE IF NOT EXISTS `contact_submissions` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `first_name` VARCHAR(100) NOT NULL,
    `last_name` VARCHAR(100),
    `email` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(20),
    `service_type` VARCHAR(100),
    `message` TEXT,
    `is_read` TINYINT(1) DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Admin Users Table
CREATE TABLE IF NOT EXISTS `admin_users` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `username` VARCHAR(50) UNIQUE NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `full_name` VARCHAR(100),
    `email` VARCHAR(255),
    `role` ENUM('admin', 'editor') DEFAULT 'editor',
    `is_active` TINYINT(1) DEFAULT 1,
    `last_login` TIMESTAMP NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert Default Admin User (password: admin123)
INSERT IGNORE INTO `admin_users` (`username`, `password`, `full_name`, `email`, `role`) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin@homeputra.com', 'admin');

-- Insert Default Site Settings
INSERT IGNORE INTO `site_settings` (`setting_key`, `setting_value`, `setting_type`, `setting_group`) VALUES
('site_name', 'Home Putra Interior', 'text', 'general'),
('site_tagline', 'Desain Interior Premium', 'text', 'general'),
('site_description', 'Kami menciptakan ruang hangat dan mewah yang disesuaikan dengan visi dan gaya hidup unik Anda.', 'textarea', 'general'),
('contact_email', 'hello@homeputra.com', 'text', 'contact'),
('contact_phone', '+62 812 3456 7890', 'text', 'contact'),
('contact_address', 'Jl. Desain No. 123, Jakarta Selatan 12345', 'textarea', 'contact'),
('whatsapp_number', '6281234567890', 'text', 'contact'),
('instagram_url', 'https://instagram.com/homeputrainterior', 'text', 'social'),
('facebook_url', 'https://facebook.com/homeputrainterior', 'text', 'social'),
('logo_image', '', 'image', 'branding');

-- Insert Default Hero Section
INSERT IGNORE INTO `hero_section` (`title`, `subtitle`, `background_image`, `button1_text`, `button1_link`, `button2_text`, `button2_link`) VALUES
('Mendefinisikan Ruang, <span class="text-gold-gradient italic">Meningkatkan Gaya Hidup</span>', 'Rasakan seni desain interior eksklusif. Kami menciptakan lingkungan hangat dan mewah yang disesuaikan dengan visi dan gaya hidup unik Anda.', '', 'Lihat Portfolio', '#portfolio', 'Konsultasi Gratis', '#contact');

-- Insert Default Statistics
INSERT IGNORE INTO `statistics` (`stat_number`, `stat_suffix`, `stat_label`, `display_order`) VALUES
('500', '+', 'Proyek Selesai', 1),
('12', '+', 'Tahun Pengalaman', 2),
('98', '%', 'Kepuasan Klien', 3),
('2', 'th', 'Garansi', 4);

-- Insert Default Services
INSERT IGNORE INTO `services` (`title`, `description`, `icon`, `display_order`) VALUES
('Desain Residensial', 'Renovasi skala penuh dan desain bangunan baru untuk rumah mewah, fokus pada aliran, cahaya, dan materialitas.', 'home', 1),
('Ruang Komersial', 'Menciptakan pengalaman brand yang berdampak melalui desain tata ruang cerdas untuk ritel, perhotelan, dan kantor.', 'storefront', 2),
('Furniture Custom', 'Desain dan koordinasi fabrikasi furniture eksklusif untuk memastikan setiap produk cocok sempurna dengan ruang Anda.', 'chair', 3);

-- Insert Default Portfolio Items
INSERT IGNORE INTO `portfolio` (`title`, `category`, `description`, `image`, `display_order`, `is_featured`) VALUES
('The Penthouse Edit', 'Residensial', 'Ruang tamu minimalis modern dengan sentuhan mewah', '', 1, 1),
('Executive Study', 'Kantor', 'Ruang kerja eksekutif dengan kayu gelap yang elegan', '', 2, 1),
('Serene Master Suite', 'Residensial', 'Kamar tidur utama dengan nuansa Scandinavian yang tenang', '', 3, 1),
('Marble & Gold', 'Dapur', 'Dapur mewah dengan kombinasi marmer dan emas', '', 4, 1),
('The Grand Hall', 'Ruang Makan', 'Ruang makan megah untuk keluarga besar', '', 5, 1);

-- Insert Default Testimonials
INSERT IGNORE INTO `testimonials` (`client_name`, `client_location`, `client_image`, `testimonial_text`, `rating`, `display_order`) VALUES
('Sarah Putri', 'Jakarta Selatan', '', 'Home Putra Interior mengubah apartemen gelap dan kuno kami menjadi tempat tinggal yang penuh cahaya. Perhatian terhadap detail sungguh luar biasa.', 5, 1),
('Michael Hartono', 'Surabaya', '', 'Tim ini memahami visi kami lebih baik dari kami sendiri. Ruang kerja kayu oak hangat sekarang menjadi ruangan favorit saya di seluruh rumah.', 5, 2),
('Lisa Wijaya', 'Bandung', '', 'Profesional, tepat waktu, dan sangat berbakat. Mereka mengelola semuanya mulai dari kontraktor hingga styling.', 5, 3);
