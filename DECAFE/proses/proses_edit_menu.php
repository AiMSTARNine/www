<?php
include "connect.php";

if (isset($_POST['input_menu_validate'])) {

    // =========================
    // AMBIL DATA
    // =========================
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $nama_menu = isset($_POST['nama_menu']) ? trim($_POST['nama_menu']) : '';
    $keterangan = isset($_POST['keterangan']) ? trim($_POST['keterangan']) : '';
    $kat_menu = isset($_POST['kat_menu']) ? $_POST['kat_menu'] : null;
    $harga = isset($_POST['harga']) ? $_POST['harga'] : null;
    $stok = isset($_POST['stok']) ? $_POST['stok'] : null;

    // =========================
    // VALIDASI DASAR
    // =========================
    if ($id <= 0 || $nama_menu == '') {
        echo '<script>alert("Data tidak lengkap!"); window.location="../menu"</script>';
        exit;
    }

    // =========================
    // AMBIL DATA LAMA (PENTING)
    // =========================
    $getOld = mysqli_query($conn, "SELECT * FROM tb_daftar_menu WHERE id='$id'");
    $old = mysqli_fetch_assoc($getOld);

    // fallback kalau kategori kosong
    if ($kat_menu === null || $kat_menu === '') {
        $kat_menu = $old['kategori'];
    } {
        $kat_menu = $old['kategori'];
    }

    // fallback harga & stok
    if ($harga === null || $harga === '') {
        $harga = $old['harga'];
    }

    if ($stok === null || $stok === '') {
        $stok = $old['stok'];
    }
    // =========================
    // CEK DUPLIKAT
    // =========================
    $cekNama = mysqli_query($conn, "
        SELECT id FROM tb_daftar_menu 
        WHERE nama_menu='$nama_menu' AND id != '$id'
    ");

    if (mysqli_num_rows($cekNama) > 0) {
        echo '<script>alert("Nama menu sudah ada!"); window.location="../menu"</script>';
        exit;
    }

    // =========================
    // SETUP QUERY
    // =========================
    $sql = "
        UPDATE tb_daftar_menu 
        SET foto='" . $kode_rand . $_FILES['foto']['name'] . "',
            nama_menu='$nama_menu',
            keterangan='$keterangan',
            kategori='$kat_menu',
            harga='$harga',
            stok='$stok'
    ";

    // =========================
    // UPLOAD GAMBAR (OPSIONAL)
    // =========================
    if (!empty($_FILES['foto']['name'])) {

        $target_dir = "../assets/img/menu/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $kode_rand = rand(10000, 99999) . "-";
        $nama_file = $kode_rand . basename($_FILES['foto']['name']);
        $target_file = $target_dir . $nama_file;

        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            $sql .= ", foto='$nama_file'";
        }
    }

    $sql .= " WHERE id='$id'";

    $query = mysqli_query($conn, $sql);

    if ($query) {
        echo '<script>alert("Data berhasil diupdate!"); window.location="../menu"</script>';
    } else {
        echo '<script>alert("Gagal update!");</script>';
    }
}
