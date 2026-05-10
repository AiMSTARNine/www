<?php
// PERBAIKAN: Cek session sebelum start agar tidak konflik dengan main.php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include "proses/connect.php";
$query = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '$_SESSION[username_decafe]'");
$records = mysqli_fetch_array($query);
?>

<nav class="navbar navbar-expand navbar-dark bg-primary sticky-top">
  <div class="container-lg">
    <a class="navbar-brand" href="."><i class="bi bi-cup-hot"></i> DeCafe</a>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $hasil['username']; // Tetap pakai $hasil dari main.php ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end mt-2">
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#ModalUbahProfile"><i class="bi bi-person-square"></i> Profile</a></li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#ModalUbahPassword"><i class="bi bi-key"></i> Ubah Password</a></li>
            <li><a class="dropdown-item" href="logout"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Awal Modal Password -->
<div class="modal fade" id="ModalUbahPassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-fullscreen-md-down">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Password</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" novalidate action="proses/proses_ubah_password.php" method="POST">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-floating mb-3">
                <!-- PERBAIKAN: name harus unik, bukan "username" lagi untuk password lama -->
                <input disabled type="text" class="form-control" id="floatingUsername" placeholder="username" name="username" required value="<?php echo htmlspecialchars($_SESSION['username_decafe']); ?>">
                <label for="floatingUsername">Username</label>
                <div class="invalid-feedback">Masukkan Username.</div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-floating mb-3">
                <!-- PERBAIKAN: name="passwordlama" bukan "username" -->
                <input type="password" class="form-control" id="floatingPasswordLama" name="passwordlama" required>
                <label for="floatingPasswordLama">Password Lama</label>
                <div class="invalid-feedback">Masukkan Password Lama.</div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingPasswordBaru" name="passwordbaru" required>
                <label for="floatingPasswordBaru">Password Baru</label>
                <div class="invalid-feedback">Masukkan Password Baru.</div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingRePassword" name="repasswordbaru" required>
                <label for="floatingRePassword">Ulangi Password Baru</label>
                <div class="invalid-feedback">Konfirmasi Password Baru.</div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="ubah_password_validate" value="12345">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Akhir Modal Password -->


<!-- Awal Modal Profile -->
<div class="modal fade" id="ModalUbahProfile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-fullscreen-md-down">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Profile</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" novalidate action="proses/proses_ubah_profile.php" method="POST">
          <div class="row">
            <div class="col-lg-4">
              <div class="form-floating mb-3">
                <input disabled type="text" class="form-control" id="floatingUsernameProfile" name="username" required value="<?php echo htmlspecialchars($_SESSION['username_decafe']); ?>">
                <label for="floatingUsernameProfile">Username</label>
                <div class="invalid-feedback">Masukkan Username.</div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingNama" name="nama" required value="<?php echo htmlspecialchars($records['nama']); ?>">
                <label for="floatingNama">Nama</label>
                <div class="invalid-feedback">Masukkan Nama Lengkap.</div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-floating mb-3">
                <input type="number" class="form-control" id="floatingNoHp" name="nohp" required value="<?php echo htmlspecialchars($records['nohp']); ?>">
                <label for="floatingNoHp">Nomor HP</label>
                <div class="invalid-feedback">Masukkan Nomor HP.</div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="form-floating mb-3">
                <textarea class="form-control" id="floatingAlamat" style="height:100px" name="alamat"><?php echo htmlspecialchars($records['alamat']); ?></textarea>
                <label for="floatingAlamat">Alamat</label>
                <div class="invalid-feedback">Masukan Alamat.</div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="ubah_profile_validate" value="12345">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Akhir Modal Profile -->