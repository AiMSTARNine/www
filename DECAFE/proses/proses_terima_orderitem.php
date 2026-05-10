<?php
session_start();
include "connect.php";
$id = (isset($_POST['id_list_order'])) ? htmlentities($_POST['id_list_order']) : "";
$catatan = (isset($_POST['catatan'])) ? htmlentities($_POST['catatan']) : "";

if (!empty($_POST['terima_orderitem_validate'])) {
    $query = mysqli_query($conn, "UPDATE tb_list_order SET catatan='$catatan', status=1 WHERE id_list_order='$id'");
    if ($query) {
        $message = '<script>alert("Berhasil Menerima Order!");
                window.location="../dapur"</script>';
    } else {
        $message = '<script>alert("Gagal Menerima Order!");
                window.location="../dapur</script>';
    }
}
echo $message;
?>