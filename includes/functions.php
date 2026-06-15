<?php
function sanitize(string $str): string {
    return htmlspecialchars(strip_tags(trim($str)), ENT_QUOTES, 'UTF-8');
}

function redirect(string $url): never {
    header("Location: $url");
    exit;
}

function formatTanggal(string $tgl): string {
    $bulan = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
              'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    $d = explode('-', $tgl);
    if (count($d) !== 3) return $tgl;
    return (int)$d[2] . ' ' . ($bulan[(int)$d[1]] ?? '') . ' ' . $d[0];
}

function badgeStatus(string $status): string {
    $map = [
        'Akan Datang' => ['akan-datang', '🗓️'],
        'Berlangsung' => ['berlangsung', '🔥'],
        'Selesai'     => ['selesai',     '✅'],
    ];
    [$cls, $icon] = $map[$status] ?? ['lain', '📌'];
    return "<span class='badge badge-{$cls}'>{$icon} {$status}</span>";
}

function badgeKategori(string $kat): string {
    $map = [
        'Lingkungan' => ['lingkungan', '🌿'],
        'Sosial'     => ['sosial',     '🤝'],
        'Pendidikan' => ['pendidikan', '📚'],
        'Kesehatan'  => ['kesehatan',  '❤️'],
        'Lainnya'    => ['lainnya',    '📌'],
    ];
    [$cls, $icon] = $map[$kat] ?? ['lainnya', '📌'];
    return "<span class='badge badge-kat-{$cls}'>{$icon} {$kat}</span>";
}

function iconKategori(string $kat): string {
    return ['Lingkungan'=>'🌿','Sosial'=>'🤝','Pendidikan'=>'📚','Kesehatan'=>'❤️','Lainnya'=>'📌'][$kat] ?? '📌';
}

function warnaBg(string $kat): string {
    return ['Lingkungan'=>'#dcfce7','Sosial'=>'#dbeafe','Pendidikan'=>'#fef9c3','Kesehatan'=>'#ffe4e6','Lainnya'=>'#f3f4f6'][$kat] ?? '#f3f4f6';
}

function isPageActive(string $page): string {
    $current = basename($_SERVER['PHP_SELF']);
    return ($current === $page) ? ' active' : '';
}

function flashMsg(string $type): array {
    $msgs = [
        'tambah' => ['✅ Kegiatan berhasil ditambahkan!', 'success'],
        'edit'   => ['💾 Kegiatan berhasil diperbarui!', 'success'],
        'hapus'  => ['🗑️ Kegiatan berhasil dihapus.', 'info'],
    ];
    return $msgs[$type] ?? [];
}
?>
