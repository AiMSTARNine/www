<?php
session_start();
include "connect.php";
$nama = (isset($_POST['nama'])) ? htmlentities($_POST['nama']) : "";
$nohp = (isset($_POST['nohp'])) ? htmlentities($_POST['nohp']) : "";
$alamat = (isset($_POST['alamat'])) ? htmlentities($_POST['alamat']) : "";

if (!empty($_POST['ubah_profile_validate'])) {

    $query = mysqli_query($conn, "UPDATE tb_user SET nama='$nama', nohp='$nohp', alamat='$alamat' WHERE username = '$_SESSION[username_decafe]' ");
    if ($query) {
        $message = '<script>alert("Profile Berhasil Diubah");
                    window.history.back()</script>
                    </script>';
    } else {
        $message = '<script>alert("Profile Gagal Diubah");
                    window.history.back()</script>
                    </script>';
    }
} else {
    $message = '<script>alert("Akses Ditolak");
                    window.history.back()</script>
                    </script>';
}
echo $message;
