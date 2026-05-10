<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (empty($_SESSION['username_decafe'])) {
  header('location:login');
  exit;
}

include "proses/connect.php";

$query = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '$_SESSION[username_decafe]'");
$hasil = mysqli_fetch_array($query);
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DeCafe - Aplikasi Pemesanan Makanan dan Minuman</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

  <!-- DataTables CSS Bootstrap -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
</head>

<body>
  <!-- Header -->
  <?php include "header.php"; ?>
  <!-- End Header -->

  <div class="container-lg">
    <div class="row mb-5">

      <!-- Sidebar -->
      <?php include "sidebar.php"; ?>
      <!-- End Sidebar -->

      <!-- Content -->
      <?php include $page; ?>
      <!-- End Content -->

    </div>

    <div class="fixed-bottom text-center bg-light py-2">
      Copyright 2026 Faris AiMSTAR
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Validasi Form Bootstrap -->

  <script>
    (() => {
      'use strict';
      const forms = document.querySelectorAll('.needs-validation');
      Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
          if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      })
    })();
  </script>

  <!-- DataTables Init -->
  <script>
    $(document).ready(function() {
      $('#example').DataTable({
        language: {
          search: "Cari:",
          lengthMenu: "Tampilkan _MENU_ data",
          info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
          infoEmpty: "Tidak ada data yang ditampilkan",
          infoFiltered: "(difilter dari _MAX_ total data)",
          zeroRecords: "Tidak ada data yang cocok",
          paginate: {
            first: "Pertama",
            last: "Terakhir",
            next: "Selanjutnya",
            previous: "Sebelumnya"
          }
        }
      });
    });
  </script>

</body>

</html>