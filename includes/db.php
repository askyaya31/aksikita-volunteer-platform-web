<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'aksikita_simple');

function getDB() {
    static $conn = null;
    if ($conn === null) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            die("<div style='font-family:sans-serif;padding:2rem;background:#fdeaea;color:#991b1b;border-radius:8px;margin:2rem;'>
                <strong>Koneksi Database Gagal:</strong> " . $conn->connect_error . "<br><br>
                Pastikan MySQL berjalan dan database <code>" . DB_NAME . "</code> sudah dibuat. 
                Jalankan file <code>setup.sql</code> terlebih dahulu.
            </div>");
        }
        $conn->set_charset("utf8mb4");
    }
    return $conn;
}
?>
