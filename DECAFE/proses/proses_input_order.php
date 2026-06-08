<?php
session_start();
include "connect.php";

$kode_order = isset($_POST['kode_order']) ? htmlentities($_POST['kode_order']) : "";
$meja       = isset($_POST['meja']) ? htmlentities($_POST['meja']) : "";
$pelanggan  = isset($_POST['pelanggan']) ? htmlentities($_POST['pelanggan']) : "";

$status = "";
$pesan = "";
$redirect = "";

if (!empty($_POST['input_order_validate'])) {

    $select = mysqli_query($conn, "SELECT * FROM tb_order WHERE id_order='$kode_order'");

    if (mysqli_num_rows($select) > 0) {

        $status = "error";
        $pesan = "Kode Order yang dimasukkan sudah ada!";
        $redirect = "../order";

    } else {

        $query = mysqli_query($conn,
            "INSERT INTO tb_order
            (id_order, meja, pelanggan, pelayan)
            VALUES
            ('$kode_order', '$meja', '$pelanggan', '$_SESSION[id_decafe]')"
        );

        if ($query) {
            $status = "success";
            $pesan = "Data Order Berhasil Ditambahkan!";
            $redirect = "../?x=orderitem&order=$kode_order&meja=$meja&pelanggan=$pelanggan";
        } else {
            $status = "error";
            $pesan = "Data Order Gagal Ditambahkan!";
            $redirect = "../order";
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
        min-width:480px;
        background:#fff;
        border-radius:16px;
        padding:18px 25px;
        display:flex;
        justify-content:space-between;
        align-items:center;
        box-shadow:0 8px 25px rgba(0,0,0,.15);
        animation:showToast .4s ease;
    }

    .toast-left{
        display:flex;
        align-items:center;
        gap:15px;
    }

    .icon{
        width:42px;
        height:42px;
        border-radius:50%;
        display:flex;
        justify-content:center;
        align-items:center;
        color:#fff;
        font-size:24px;
        font-weight:bold;
    }

    .success{
        background:#4CAF50;
    }

    .error{
        background:#F44336;
    }

    .text{
        font-size:30px;
        color:#333;
    }

    .close{
        font-size:32px;
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
    <div class="toast-left">
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
    }, 1000); // 1 detik
</script>

</body>
</html>