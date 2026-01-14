<?php

/**
 * Contact Form Handler
 * Home Putra Interior CMS
 */

header('Content-Type: application/json');

// Include configuration
require_once __DIR__ . '/../config/database.php';

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get POST data
$data = [
    'first_name' => trim($_POST['first_name'] ?? ''),
    'last_name' => trim($_POST['last_name'] ?? ''),
    'email' => trim($_POST['email'] ?? ''),
    'phone' => trim($_POST['phone'] ?? ''),
    'service_type' => trim($_POST['service_type'] ?? ''),
    'message' => trim($_POST['message'] ?? '')
];

// Validate required fields
if (empty($data['first_name']) || empty($data['email'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Nama dan email wajib diisi']);
    exit;
}

// Validate email format
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Format email tidak valid']);
    exit;
}

try {
    $db = getDB();

    $stmt = $db->prepare("
        INSERT INTO contact_submissions (first_name, last_name, email, phone, service_type, message)
        VALUES (:first_name, :last_name, :email, :phone, :service_type, :message)
    ");

    $stmt->execute($data);

    echo json_encode([
        'success' => true,
        'message' => 'Terima kasih! Pesan Anda telah terkirim. Kami akan menghubungi Anda segera.'
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan. Silakan coba lagi.']);
}
