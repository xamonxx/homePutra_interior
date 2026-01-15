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
