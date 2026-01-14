<?php

/**
 * Authentication Functions
 * Home Putra Interior CMS
 */

// Start session at the very beginning
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/database.php';

/**
 * Check if user is logged in
 */
function isLoggedIn()
{
    return isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']);
}

/**
 * Require login - redirect if not logged in
 */
function requireLogin()
{
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

/**
 * Login user
 */
function loginUser($username, $password)
{
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM admin_users WHERE username = :username AND is_active = 1");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['admin_name'] = $user['full_name'];
            $_SESSION['admin_role'] = $user['role'];

            // Update last login
            $stmt = $db->prepare("UPDATE admin_users SET last_login = NOW() WHERE id = :id");
            $stmt->execute(['id' => $user['id']]);

            return true;
        }
        return false;
    } catch (PDOException $e) {
        return false;
    }
}

/**
 * Logout user
 */
function logoutUser()
{
    session_destroy();
    header('Location: login.php');
    exit;
}

/**
 * Get current user info
 */
function getCurrentUser()
{
    if (!isLoggedIn()) return null;

    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM admin_users WHERE id = :id");
        $stmt->execute(['id' => $_SESSION['admin_id']]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        return null;
    }
}

/**
 * Check if user is admin
 */
function isAdmin()
{
    return isset($_SESSION['admin_role']) && $_SESSION['admin_role'] === 'admin';
}

/**
 * Generate CSRF token
 */
function generateCSRFToken()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 */
function verifyCSRFToken($token)
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Escape output
 */
function e($string)
{
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Set flash message
 */
function setFlash($type, $message)
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

/**
 * Get and clear flash message
 */
function getFlash()
{
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}
