<?php
    //  session_start();
     if(!empty($_SESSION['username_decafe'])){
        header('location:home');
     }
?>   
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeCafe - Aplikasi Pemesanan Makanan dan Minuman </title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        body {
            background-color: #f5f5f5;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            width: 350px;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(to right, #4a6cf7, #3b82f6);
            border: none;
        }
    </style>
</head>

<body>

    <div class="login-box">

        <i class="bi bi-cup-hot fs-1"></i>

        <h4 class="mb-3">Please Login</h4>

        <form class="needs-validation" novalidate action="proses/proses_login.php" method="POST">

            <div class="form-floating mb-2">
                <input name="username" type="email" class="form-control" id="email" placeholder="Email address" required>
                <label for="email">Email address</label>
                <div class="invalid-feedback">
                    Masukkan email yang valid.
                </div>
            </div>

            <div class="form-floating mb-3">
                <input name="password" type="password" class="form-control" id="password" placeholder="Password" required minlength="6">
                <label for="password">Password</label>
                <div class="invalid-feedback">
                    Masukkan kata sandi yang benar.
                </div>
            </div>

            <div class="form-check mb-3 text-start">
                <input class="form-check-input" type="checkbox" id="remember">
                <label class="form-check-label" for="remember">
                    Remember me
                </label>
            </div>

            <button class="btn btn-primary w-100 py-2" type="submit" name="submit_validate" value="abc">
                Login
            </button>

            <p class="mt-4 text-muted">© 2025–2026</p>
        </form>
    </div>

    <script>
        (() => {
            'use strict'

            const forms = document.querySelectorAll('.needs-validation')

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>

</body>

</html>