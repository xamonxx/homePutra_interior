<?php
/**
 * Database Configuration
 * Home Putra Interior CMS
 */

define('DB_HOST', 'localhost');
define('DB_NAME', 'homeputra_cms');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Site Configuration
define('SITE_NAME', 'Home Putra Interior');
define('SITE_URL', 'http://localhost/landingpage_homeputra');
define('ADMIN_EMAIL', 'admin@homeputra.com');

// Upload Configuration
define('UPLOAD_DIR', __DIR__ . '/../uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB

// Session Configuration
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Database Connection Class
 */
class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $this->connection = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // If database doesn't exist, create it
            try {
                $dsn = "mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET;
                $pdo = new PDO($dsn, DB_USER, DB_PASS);
                $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                
                // Reconnect to the new database
                $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
                $this->connection = new PDO($dsn, DB_USER, DB_PASS, $options);
                
                // Initialize tables
                $this->initializeTables();
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    private function initializeTables() {
        $sql = file_get_contents(__DIR__ . '/schema.sql');
        $this->connection->exec($sql);
    }
}

/**
 * Get database connection
 */
function getDB() {
    return Database::getInstance()->getConnection();
}
