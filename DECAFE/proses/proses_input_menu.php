<?php
include "connect.php";

$message = "";

// Ambil input
$nama_menu = isset($_POST['nama_menu']) ? mysqli_real_escape_string($conn, $_POST['nama_menu']) : "";
$keterangan = isset($_POST['keterangan']) ? mysqli_real_escape_string($conn, $_POST['keterangan']) : "";
$kat_menu = isset($_POST['kat_menu']) ? mysqli_real_escape_string($conn, $_POST['kat_menu']) : "";
$harga = isset($_POST['harga']) ? mysqli_real_escape_string($conn, $_POST['harga']) : "";
$stok = isset($_POST['stok']) ? mysqli_real_escape_string($conn, $_POST['stok']) : "";

// Generate nama file
$kode_rand = rand(10000, 99999) . "-";
$target_dir = "../assets/img/menu/";

// Pastikan folder ada
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$target_file = $target_dir . $kode_rand . basename($_FILES['foto']['name']);
$imageType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if (!empty($_POST['input_menu_validate'])) {

    $statusUpload = 1;

    // Cek apakah file gambar
    $cek = getimagesize($_FILES["foto"]["tmp_name"]);
    if ($cek == false) {
        $message = "Ini bukan file gambar.";
        $statusUpload = 0;
    }

    // Cek ukuran file
    if ($_FILES["foto"]["size"] > 500000) {
        $message = "File terlalu besar.";
        $statusUpload = 0;
    }

    // Cek tipe file
    if (!in_array($imageType, ["jpg", "jpeg", "png", "gif"])) {
        $message = "Format gambar tidak valid.";
        $statusUpload = 0;
    }

    // Jika gagal upload
    if ($statusUpload == 0) {
        echo '<script>alert("' . $message . '"); window.location="../menu"</script>';
        exit;
    }

    // Cek nama menu duplikat
    $select = mysqli_query($conn, "SELECT * FROM tb_daftar_menu WHERE nama_menu='$nama_menu'");
    if (mysqli_num_rows($select) > 0) {
        echo '<script>alert("Nama menu sudah ada!"); window.location="../menu"</script>';
        exit;
    }

    // Upload file
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {

        $nama_file = $kode_rand . basename($_FILES['foto']['name']);

        $query = mysqli_query($conn, "INSERT INTO tb_daftar_menu (foto, nama_menu, keterangan, kategori, harga, stok) VALUES ('$nama_file', '$nama_menu', '$keterangan', '$kat_menu', '$harga', '$stok')");

        if ($query) {
            echo '<script>alert("Data menu berhasil ditambahkan!"); window.location="../menu"</script>';
        } else {
            echo '<script>alert("Gagal menyimpan ke database!");</script>';
        }

    } else {
        echo '<script>alert("Upload gambar gagal!"); window.location="../menu"</script>';
    }
}
?>