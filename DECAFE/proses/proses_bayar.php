<?php
session_start();
include "connect.php";

$kode_order = isset($_POST['kode_order']) ? htmlentities($_POST['kode_order']) : "";
$meja = isset($_POST['meja']) ? htmlentities($_POST['meja']) : "";
$pelanggan = isset($_POST['pelanggan']) ? htmlentities($_POST['pelanggan']) : "";
$total = isset($_POST['total']) ? htmlentities($_POST['total']) : "";
$uang = isset($_POST['nominal_uang']) ? htmlentities($_POST['nominal_uang']) : "";

$kembalian = $uang - $total;

$status = "";
$pesan = "";

$redirect = "../?x=orderitem&order=$kode_order&meja=$meja&pelanggan=$pelanggan";

if (!empty($_POST['bayar_validate'])) {

    if ($kembalian < 0) {

        $status = "error";
        $pesan = "Nominal uang tidak mencukupi!";

    } else {

        $query = mysqli_query($conn,
            "INSERT INTO tb_bayar
            (id_bayar, nominal_uang, total_bayar)
            VALUES
            ('$kode_order','$uang','$total')"
        );

        if ($query) {

            $status = "success";
            $pesan = "Pembayaran Berhasil!";

        } else {

            $status = "error";
            $pesan = "Pembayaran Gagal!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Notifikasi Pembayaran</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    background:rgba(0,0,0,.4);
}

.overlay{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;
}

.modal{
    background:#fff;
    width:450px;
    border-radius:15px;
    box-shadow:0 10px 30px rgba(0,0,0,.2);
    overflow:hidden;
}

.header{
    padding:20px;
    text-align:center;
}

.icon{
    width:60px;
    height:60px;
    border-radius:50%;
    margin:auto;
    color:white;
    font-size:35px;
    display:flex;
    justify-content:center;
    align-items:center;
}

.success{
    background:#4CAF50;
}

.error{
    background:#F44336;
}

.content{
    padding:20px;
    text-align:center;
}

.content h2{
    margin-bottom:15px;
    color:#333;
}

.content p{
    font-size:20px;
    margin:8px 0;
}

.footer{
    padding:20px;
    text-align:center;
}

button{
    background:#ff6b00;
    color:white;
    border:none;
    padding:10px 35px;
    border-radius:8px;
    cursor:pointer;
    font-size:16px;
}

button:hover{
    opacity:.9;
}

</style>

</head>

<body>

<div class="overlay">

    <div class="modal">

        <div class="header">
            <div class="icon <?php echo $status; ?>">
                <?php echo ($status=="success") ? "✓" : "!"; ?>
            </div>
        </div>

        <div class="content">

            <h2><?php echo $pesan; ?></h2>

            <?php if($status=="success"){ ?>

                <p>Total Bayar :</p>
                <strong>Rp. <?php echo number_format($total,0,",","."); ?></strong>

                <br><br>

                <p>Uang Diterima :</p>
                <strong>Rp. <?php echo number_format($uang,0,",","."); ?></strong>

                <br><br>

                <p>Kembalian :</p>
                <strong style="color:green;font-size:24px;">
                    Rp. <?php echo number_format($kembalian,0,",","."); ?>
                </strong>

            <?php } ?>

        </div>

        <div class="footer">
            <button onclick="lanjut()">OK</button>
        </div>

    </div>

</div>

<script>
function lanjut(){
    window.location.href="<?php echo $redirect; ?>";
}
</script>

</body>
</html>