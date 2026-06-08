<?php
session_start();
include "connect.php";

$id = isset($_POST['id_list_order']) ? htmlentities($_POST['id_list_order']) : "";
$catatan = isset($_POST['catatan']) ? htmlentities($_POST['catatan']) : "";

$status = "";
$pesan = "";
$redirect = "../dapur";

if (!empty($_POST['siapsaji_orderitem_validate'])) {

    $query = mysqli_query($conn,
        "UPDATE tb_list_order
        SET catatan='$catatan',
            status='2'
        WHERE id_list_order='$id'"
    );

    if ($query) {
        $status = "success";
        $pesan = "Order Siap Disajikan!";
    } else {
        $status = "error";
        $pesan = "Gagal Menyetujui Order!";
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
    min-width:420px;
    background:#ffffff;
    border-radius:15px;
    padding:18px 24px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 10px 30px rgba(0,0,0,.15);
    animation:showToast .35s ease;
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

.toast-content{
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
    color:#888;
    cursor:pointer;
}

</style>

</head>

<body>

<div class="toast">

    <div class="toast-content">

        <div class="icon <?php echo $status; ?>">
            <?php
                if($status=="success"){
                    echo "✓";
                }else{
                    echo "!";
                }
            ?>
        </div>

        <div class="text">
            <?php echo $pesan; ?>
        </div>

    </div>

    <div class="close">&times;</div>

</div>

<script>

document.querySelector(".close").onclick = function(){
    window.location.href="<?php echo $redirect; ?>";
}

setTimeout(function(){
    window.location.href="<?php echo $redirect; ?>";
},1000);

</script>

</body>
</html>