<?php
session_start();
include "connect.php";

$kode_order = isset($_POST['kode_order']) ? htmlentities($_POST['kode_order']) : "";
$meja        = isset($_POST['meja']) ? htmlentities($_POST['meja']) : "";
$pelanggan   = isset($_POST['pelanggan']) ? htmlentities($_POST['pelanggan']) : "";
$catatan     = isset($_POST['catatan']) ? htmlentities($_POST['catatan']) : "";
$menu         = isset($_POST['menu']) ? htmlentities($_POST['menu']) : "";
$jumlah      = isset($_POST['jumlah_porsi']) ? htmlentities($_POST['jumlah_porsi']) : "";

if (!empty($_POST['input_orderitem_validate'])) {

    $select = mysqli_query($conn, "SELECT * FROM tb_list_order 
                                   WHERE menu='$menu' 
                                   AND kode_order='$kode_order'");

    if (mysqli_num_rows($select) > 0) {
        $status = "error";
        $pesan  = "Item yang dimasukkan sudah ada!";
    } else {

        $query = mysqli_query($conn, "INSERT INTO tb_list_order(menu,kode_order,jumlah,catatan)
                                      VALUES('$menu','$kode_order','$jumlah','$catatan')");

        if ($query) {
            $status = "success";
            $pesan  = "Data Order Berhasil Ditambahkan!";
        } else {
            $status = "error";
            $pesan  = "Data Order Gagal Ditambahkan!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notifikasi</title>

    <style>
        body{
            margin:0;
            padding:0;
            font-family:Arial, Helvetica, sans-serif;
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
            padding:20px 25px;
            box-shadow:0 5px 20px rgba(0,0,0,.15);
            display:flex;
            align-items:center;
            justify-content:space-between;
            animation:slideDown .4s ease;
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
            background:#f44336;
        }

        .message{
            font-size:28px;
            color:#333;
        }

        @keyframes slideDown{
            from{
                opacity:0;
                transform:translate(-50%,-30px);
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
            <?php echo ($status=="success") ? "✓" : "!"; ?>
        </div>

        <div class="message">
            <?php echo $pesan; ?>
        </div>
    </div>

    <div style="font-size:30px;color:#999;">×</div>
</div>

<script>
setTimeout(function(){
    window.location.href =
    "../?x=orderitem&order=<?php echo $kode_order; ?>&meja=<?php echo $meja; ?>&pelanggan=<?php echo $pelanggan; ?>";
}, 1000);
</script>

</body>
</html>