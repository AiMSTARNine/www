<?php
include "proses/connect.php";
$result = [];
$query = mysqli_query($conn, "SELECT * FROM tb_daftar_menu");
while ($row = mysqli_fetch_array($query)) {
  $result[] = $row;
}

$query_chart = mysqli_query($conn,"SELECT nama_menu, tb_daftar_menu.id, SUM(tb_list_order.jumlah) AS total_jumlah FROM tb_daftar_menu LEFT JOIN tb_list_order ON tb_daftar_menu.id = tb_list_order.menu GROUP BY tb_daftar_menu.id ORDER BY tb_daftar_menu.id ASC");

// $result_chart = array ();
while ($record_chart = mysqli_fetch_array($query_chart)) {
  $result_chart[] = $record_chart;
}

$array_menu = array_column($result_chart, 'nama_menu');
$array_menu_quote = array_map(function ($menu){
  return "'" .$menu. "'";
}, $array_menu);
$string_menu = implode(',', $array_menu_quote);


$array_jumlah_pesanan = array_column($result_chart, 'total_jumlah');
$string_jumlah_pesanan = implode(',', $array_jumlah_pesanan);

?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="col-lg-9 mt-2">

  <!-- Carousel -->
  <?php if (!empty($result)) : ?>
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">

      <!-- Carousel Indicators / Tombol Titik -->
      <div class="carousel-indicators">
        <?php
        $slide = 0;
        foreach ($result as $dataTombol) {
          $aktif = ($slide === 0) ? "active" : "";
          $ariaCurrent = ($slide === 0) ? 'aria-current="true"' : "";
        ?>
          <button
            type="button"
            data-bs-target="#carouselExampleCaptions"
            data-bs-slide-to="<?php echo $slide; ?>"
            class="<?php echo $aktif; ?>"
            <?php echo $ariaCurrent; ?>
            aria-label="Slide <?php echo $slide + 1; ?>">
          </button>
        <?php
          $slide++;
        } ?>
      </div>
      <!-- Akhir Carousel Indicators -->

      <!-- Carousel Inner / Gambar -->
      <div class="carousel-inner rounded">
        <?php
        $firstSlide = true;
        foreach ($result as $data) {
          $aktif = $firstSlide ? "active" : "";
          $firstSlide = false;
        ?>
          <div class="carousel-item <?php echo $aktif; ?>">
            <img
              src="assets/img/menu/<?php echo htmlspecialchars($data['foto']); ?>"
              class="d-block img-fluid"
              style="height: 300px; width: 100%; object-fit: cover;"
              alt="<?php echo htmlspecialchars($data['nama_menu']); ?>">
            <div class="carousel-caption d-none d-md-block">
              <h5><?php echo htmlspecialchars($data['nama_menu']); ?></h5>
              <p><?php echo htmlspecialchars($data['keterangan']); ?></p>
            </div>
          </div>
        <?php } ?>
      </div>
      <!-- Akhir Carousel Inner -->

      <!-- Tombol Prev & Next -->
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>

    </div>
  <?php else : ?>
    <div class="alert alert-warning">Belum ada menu yang tersedia.</div>
  <?php endif; ?>
  <!-- Akhir Carousel -->


  <!-- Judul Info -->
  <div class="card mt-4 border-0 bg-light">
    <div class="card-body text-center">
      <h5 class="card-title">DE'CAFE - APLIKASI PEMESANAN COFFESHOP</h5>
      <p class="card-text">
        Aplikasi untuk melakukan pemesanan makanan dan minuman dari coffeshop secara online.
        Nikmati beragam pilihan menu makanan dan minuman favorit anda.
        Pesan, bayar, dan lacak pesanan Anda dengan mudah melalui aplikasi ini.
        Segera pesan sekarang secara mudah dan praktis.
      </p>
      <a href="order" class="btn btn-primary">Pesan Sekarang</a>
    </div>
  </div>
  <!-- Akhir Judul Info -->

  <!-- Judul Chart -->
  <div class="card mt-4 border-0 bg-light">
    <div class="card-body text-center">
      <div>
        <canvas id="myChart"></canvas>
      </div>
        <script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [<?php echo $string_menu ?>],
      datasets: [{
        label: 'Jumlah Porsi Terjual',
        data: [<?php echo $string_jumlah_pesanan ?>],
        borderWidth: 1,
        backgroundColor: [
          'rgba(255, 0, 0, 0.54)',
          'rgba(6, 89, 255, 0.59)',
          'rgba(255, 217, 0, 0.52)',
          'rgba(0, 255, 60, 0.58)',
          'rgba(140, 0, 255, 0.55)',
          'rgba(255, 64, 0, 0.56)'
        ],
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
    </div>
  </div>
  <!-- Akhir Chart Info -->
</div>