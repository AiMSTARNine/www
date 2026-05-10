<?php
include "proses/connect.php";

// Validasi parameter GET
if (empty($_GET['order']) || empty($_GET['meja']) || empty($_GET['pelanggan'])) {
  echo "<script>window.location.href='?x=order'</script>";
  exit();
}

$kode = $_GET['order'];
$meja = $_GET['meja'];
$pelanggan = $_GET['pelanggan'];

$query = mysqli_query($conn, "SELECT *, SUM(harga*jumlah) AS harganya FROM tb_list_order
  LEFT JOIN tb_order ON tb_order.id_order = tb_list_order.kode_order
  LEFT JOIN tb_daftar_menu ON tb_daftar_menu.id = tb_list_order.menu
  LEFT JOIN tb_bayar ON tb_bayar.id_bayar = tb_order.id_order
  GROUP BY id_list_order
  HAVING tb_list_order.kode_order = '$kode'");

// ... sisa kode tetap sama

while ($record = mysqli_fetch_array($query)) {
  $result[] = $record;
}

// Ambil data menu dari database
$query_menu = mysqli_query($conn, "SELECT id, nama_menu FROM tb_daftar_menu");

// Simpan ke array supaya bisa dipakai berkali-kali
$select_menu = [];
while ($m = mysqli_fetch_assoc($query_menu)) {
  $select_menu[] = $m;
}
?>
<div class="col-lg-9 mt-2">
  <div class="card">
    <div class="card-header">
      Halaman View Pemesanan
    </div>
    <div class="card-body">
      <a href="report" class="btn btn-info mb-3"><i class="bi bi-arrow-90deg-left"></i></a>
      <div class="row">
        <div class="col-lg-3">
          <div class="form-floating mb-3">
            <input disabled type="text" class="form-control" id="kodeorder" value="<?php echo $kode; ?>">
            <label for="uploadFoto">Kode Order</label>
          </div>
        </div>
        <div class="col-lg-2">
          <div class="form-floating mb-3">
            <input disabled type="text" class="form-control" id="meja" value="<?php echo $meja; ?>">
            <label for="uploadFoto">Meja</label>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="form-floating mb-3">
            <input disabled type="text" class="form-control" id="pelanggan" value="<?php echo $pelanggan; ?>">
            <label for="uploadFoto">Pelanggan</label>
          </div>
        </div>
      </div>


      <?php
      if (empty($result)) {
        echo "Data Menu tidak ada";
      } else {
        foreach ($result as $row) {
      ?>

        <?php
        }
        ?>


        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr class="text-nowrap">
                <th scope="col">Menu</th>
                <th scope="col">Harga</th>
                <th scope="col">Qty</th>
                <th scope="col">Status</th>
                <th scope="col">Catatan</th>
                <th scope="col">Total</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $total = 0;
              foreach ($result as $row) {
              ?>
                <tr>
                  <td><?php echo $row['nama_menu'] ?></td>
                  <td><?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                  <td><?php echo $row['jumlah'] ?></td>
                  <td><?php if ($row['status'] == 1) {
                        echo "<span class='badge text-bg-warning'>Masuk Ke Dapur</span>";
                      } elseif ($row['status'] == 2) {
                        echo "<span class='badge text-bg-primary'>Siap Disajikan</span>";
                      } ?></td>
                  <td><?php echo $row['catatan'] ?></td>
                  <td><?php echo number_format($row['harganya'], 0, ',', '.'); ?></td>

                </tr>
              <?php
                $total += $row['harganya'];
              }

              ?>
              <tr>
                <td colspan="5" class="fw-bold">
                  Total Harga
                </td>
                <td class="fw-bold">
                  <?php echo number_format($total, 0, ',', '.'); ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      <?php
      }
      ?>
    </div>
  </div>
</div>