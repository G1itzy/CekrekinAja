<?php
// GANTI DENGAN KUNCI RAHASIA ANDA SENDIRI
// Kunci ini digunakan untuk memastikan hanya GitHub yang bisa menjalankan skrip ini.
$secret_key = 'dimaskusuma05';

// GANTI DENGAN PATH LENGKAP KE DIREKTORI GIT ANDA
// Biasanya dimulai dengan /home/username/public_html/nama_folder
$repo_dir = '/home/xukxmbxe/CekrekinAja';

// GANTI DENGAN NAMA BRANCH YANG INGIN DI-PULL
// Biasanya 'main' atau 'master'
$branch = 'main';

// ----------------------------------------------------
// -- ANDA TIDAK PERLU MENGUBAH KODE DI BAWAH INI --
// ----------------------------------------------------

// Cek apakah permintaan datang dengan kunci rahasia yang benar
if (!isset($_GET['secret']) || $_GET['secret'] !== $secret_key) {
    http_response_code(403);
    die('Akses Ditolak: Kunci rahasia tidak valid.');
}

// Cek apakah header signature dari GitHub ada (opsional tapi lebih aman)
if (!isset($_SERVER['HTTP_X_HUB_SIGNATURE'])) {
    http_response_code(403);
    die('Akses Ditolak: Signature GitHub tidak ditemukan.');
}

// Perintah yang akan dijalankan
// - cd: Pindah ke direktori repositori
// - git reset --hard HEAD: Membuang semua perubahan lokal
// - git pull origin [branch]: Mengambil perubahan terbaru dari GitHub
$commands = [
    "cd {$repo_dir}",
    "git reset --hard HEAD",
    "git pull origin {$branch}",
    "git status", // Menampilkan status setelah pull
    "git submodule sync --recursive", // Jika Anda pakai submodule
    "git submodule update --init --recursive", // Jika Anda pakai submodule
];

// Jalankan perintah
$output = '';
foreach ($commands as $command) {
    // shell_exec() menjalankan perintah dan mengembalikan output lengkap
    $output .= "Executing: {$command}\n";
    $output .= shell_exec($command . ' 2>&1'); // '2>&1' untuk menangkap error
    $output .= "------------------------\n";
}

// Tampilkan output untuk debugging
header('Content-Type: text/plain');
echo $output;

?>
