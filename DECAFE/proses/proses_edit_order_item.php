<?php
session_start();
include "connect.php";
$id = (isset($_POST['id_list_order'])) ? htmlentities($_POST['id_list_order']) : "";
$kode_order = (isset($_POST['kode_order'])) ? htmlentities($_POST['kode_order']) : "";
$meja = (isset($_POST['meja'])) ? htmlentities($_POST['meja']) : "";
$pelanggan = (isset($_POST['pelanggan'])) ? htmlentities($_POST['pelanggan']) : "";
$catatan = (isset($_POST['catatan'])) ? htmlentities($_POST['catatan']) : "";
$menu = (isset($_POST['menu'])) ? htmlentities($_POST['menu']) : "";
$jumlah = (isset($_POST['jumlah_porsi'])) ? htmlentities($_POST['jumlah_porsi']) : "";

if (!empty($_POST['edit_orderitem_validate'])) {
    $select = mysqli_query($conn, "SELECT * FROM tb_list_order WHERE menu ='$menu' && kode_order='$kode_order' && id_list_order != $id");
    if (mysqli_num_rows($select) > 0) {
        $message = '<script>alert("Item yang dimasukan Sudah Ada!")
        window.location="../?x=orderitem&order=' . $kode_order . '&meja=' . $meja . '&pelanggan=' . $pelanggan . '"</script>';
    } else {
        $query = mysqli_query($conn, "UPDATE tb_list_order SET menu='$menu',jumlah='$jumlah',catatan='$catatan' WHERE id_list_order='$id'");
        if ($query) {
            $message = '<script>alert("Data Order Berhasil Diubah!");
                window.location="../?x=orderitem&order=' . $kode_order . '&meja=' . $meja . '&pelanggan=' . $pelanggan . '";</script>';
        } else {
            $message = '<script>alert("Data Order Gagal Diubah!");
                window.location="../?x=orderitem&order=' . $kode_order . '&meja=' . $meja . '&pelanggan=' . $pelanggan . '";</script>';
        }
    }
}
echo $message;
