<?php
session_start();
include "connect.php";

$id          = isset($_POST['id_list_order']) ? htmlentities($_POST['id_list_order']) : "";
$kode_order  = isset($_POST['kode_order']) ? htmlentities($_POST['kode_order']) : "";
$meja        = isset($_POST['meja']) ? htmlentities($_POST['meja']) : "";
$pelanggan   = isset($_POST['pelanggan']) ? htmlentities($_POST['pelanggan']) : "";
$catatan     = isset($_POST['catatan']) ? htmlentities($_POST['catatan']) : "";
$menu        = isset($_POST['menu']) ? htmlentities($_POST['menu']) : "";
$jumlah      = isset($_POST['jumlah_porsi']) ? htmlentities($_POST['jumlah_porsi']) : "";

$status = "";
$pesan = "";

$redirect = "../?x=orderitem&order=$kode_order&meja=$meja&pelanggan=$pelanggan";

if (!empty($_POST['edit_orderitem_validate'])) {

    $select = mysqli_query($conn,
        "SELECT * FROM tb_list_order
        WHERE menu='$menu'
        AND kode_order='$kode_order'
        AND id_list_order != '$id'"
    );

    if (mysqli_num_rows($select) > 0) {

        $status = "error";
        $pesan = "Item yang dimasukkan sudah ada!";

    } else {

        $query = mysqli_query($conn,
            "UPDATE tb_list_order
            SET
            menu='$menu',
            jumlah='$jumlah',
            catatan='$catatan'
            WHERE id_list_order='$id'"
        );

        if ($query) {
            $status = "success";
            $pesan = "Data Order Berhasil Diubah!";
        } else {
            $status = "error";
            $pesan = "Data Order Gagal Diubah!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Notifikasi</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    background:#f5f5f5;
}

.toast{
    position:fixed;
    top:30px;
    left:50%;
    transform:translateX(-50%);
    min-width:450px;
    background:#fff;
    border-radius:15px;
    padding:18px 24px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 8px 25px rgba(0,0,0,.15);
    animation:showToast .35s ease;
}

.toast-content{
    display:flex;
    align-items:center;
    gap:15px;
}

.icon{
    width:40px;
    height:40px;
    border-radius:50%;
    display:flex;
    justify-content:center;
    align-items:center;
    color:#fff;
    font-size:22px;
    font-weight:bold;
}

.success{
    background:#4CAF50;
}

.error{
    background:#F44336;
}

.text{
    font-size:20px;
    color:#333;
}

.close{
    font-size:28px;
    color:#999;
}

@keyframes showToast{
    from{
        opacity:0;
        transform:translate(-50%,-20px);
    }
    to{
        opacity:1;
        transform:translate(-50%,0);
    }
}
</style>

</head>
<body>

<div class="toast">
    <div class="toast-content">
        <div class="icon <?php echo $status; ?>">
            <?php echo ($status == "success") ? "✓" : "!"; ?>
        </div>

        <div class="text">
            <?php echo $pesan; ?>
        </div>
    </div>

    <div class="close">×</div>
</div>

<script>
setTimeout(function(){
    window.location.href = "<?php echo $redirect; ?>";
}, 1000);
</script>

</body>
</html>