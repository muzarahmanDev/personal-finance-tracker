<?php
// includes/functions.php

/**
 * Format angka menjadi format Rupiah: 1500000 -> "Rp 1.500.000"
 */
function formatRupiah($angka) {
    return "Rp " . number_format((float)$angka, 0, ',', '.');
}

/**
 * Format tanggal ISO (2026-09-15) menjadi format Indonesia (15 Sep 2026)
 */
function formatTanggal($date) {
    $bulan = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    $parts = explode('-', $date);
    if (count($parts) !== 3) return $date;
    return (int)$parts[2] . ' ' . $bulan[(int)$parts[1]] . ' ' . $parts[0];
}
?>