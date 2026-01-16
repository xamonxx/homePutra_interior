<?php

/**
 * Helper Functions - Home Putra Interior
 * File ini berisi fungsi-fungsi pembantu global.
 */

/**
 * XSS Protection Helper
 * Menyanitasi output untuk mencegah serangan Cross-Site Scripting.
 * 
 * @param string $str Teks yang akan disanitasi
 * @return string Teks yang sudah aman
 */
if (!function_exists('e')) {
    function e($str)
    {
        return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
    }
}

/**
 * Format Currency IDR
 * Mengubah angka menjadi format Rupiah.
 * 
 * @param float $amount Angka yang akan diformat
 * @return string Format Rupiah
 */
function formatIDR($amount)
{
    return 'Rp ' . number_format($amount, 0, ',', '.');
}

/**
 * Get Site Setting
 * Mengambil nilai setting dari database.
 * 
 * @param string $key Nama setting
 * @param string $default Nilai default jika tidak ditemukan
 * @return string Nilai setting
 */
function getSetting($key, $default = '')
{
    static $cache = [];

    // Return from cache if available
    if (isset($cache[$key])) {
        return $cache[$key];
    }

    try {
        $db = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
            DB_USER,
            DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        $stmt = $db->prepare("SELECT setting_value FROM site_settings WHERE setting_key = :key LIMIT 1");
        $stmt->execute(['key' => $key]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $value = $result ? $result['setting_value'] : $default;
        $cache[$key] = $value;

        return $value;
    } catch (PDOException $e) {
        return $default;
    }
}

/**
 * Get WhatsApp Number
 * Mengambil nomor WhatsApp dari database dalam format internasional.
 * 
 * @return string Nomor WhatsApp (contoh: 6283137554972)
 */
function getWhatsAppNumber()
{
    $number = getSetting('whatsapp_number', '6283137554972');

    // Pastikan format internasional (hilangkan 0 di depan jika ada)
    $number = preg_replace('/[^0-9]/', '', $number);
    if (substr($number, 0, 1) === '0') {
        $number = '62' . substr($number, 1);
    }

    return $number;
}
