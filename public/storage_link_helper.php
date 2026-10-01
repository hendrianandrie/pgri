<?php
/**
 * Helper otomatis untuk membuat symlink storage di cPanel tanpa terminal SSH.
 * Buka URL ini di browser sekali saja: https://domain-anda.com/storage_link_helper.php
 * Setelah berhasil, segera hapus file ini demi keamanan.
 */

// Cek kemungkinan lokasi folder storage Laravel
$possibleTargets = [
    __DIR__ . '/../storage/app/public',
    dirname(__DIR__) . '/laravel_pgri/storage/app/public',
    dirname(dirname(__DIR__)) . '/laravel_pgri/storage/app/public'
];

$target = null;
foreach ($possibleTargets as $t) {
    if (file_exists($t)) {
        $target = $t;
        break;
    }
}

$link = __DIR__ . '/storage';

echo "<div style='font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 25px; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);'>";
echo "<h2 style='color: #dc2626; margin-top: 0;'>PGRI Storage Link Helper</h2>";

if (is_link($link) || file_exists($link)) {
    echo "<p style='color: #059669; font-weight: bold;'>✓ Folder atau symlink 'storage' sudah ada dan siap digunakan.</p>";
    echo "<p style='color: #64748b; font-size: 13px;'>Tautan: <code>$link</code></p>";
} elseif (!$target) {
    echo "<p style='color: #dc2626; font-weight: bold;'>✗ Folder target 'storage/app/public' tidak ditemukan.</p>";
    echo "<p style='color: #64748b; font-size: 13px;'>Pastikan struktur folder Laravel telah diunggah dengan benar.</p>";
} else {
    if (@symlink($target, $link)) {
        echo "<p style='color: #059669; font-weight: bold;'>✓ Berhasil! Symlink storage berhasil dibuat.</p>";
        echo "<p style='color: #64748b; font-size: 13px;'>Target: <code>$target</code><br>Link: <code>$link</code></p>";
    } else {
        echo "<p style='color: #d97706; font-weight: bold;'>⚠ Fungsi symlink() PHP tidak diizinkan oleh penyedia hosting Anda.</p>";
        echo "<p style='color: #64748b; font-size: 13px;'>Solusi alternatif: Buka <b>cPanel > Terminal</b> dan ketikkan perintah: <br><code>php artisan storage:link</code></p>";
    }
}

echo "<hr style='border: none; border-top: 1px solid #e2e8f0; margin: 20px 0;'>";
echo "<p style='color: #dc2626; font-size: 12px; font-weight: bold;'>CATATAN KEAMANAN: Segera hapus file ini (storage_link_helper.php) dari folder public_html setelah pengujian selesai.</p>";
echo "</div>";
