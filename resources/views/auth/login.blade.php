<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Inventaris Aset Desa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
        * { font-family: 'Poppins', sans-serif; }

        body {
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(160deg, #1a5f3f 0%, #0d3d28 100%);
        }

        .login-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 40px;
            width: 100%;
            max-width: 400px;
        }

        .icon-box {
            width: 60px;
            height: 60px;
            background: #e6f4ec;
            color: #1a5f3f;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 auto 16px;
        }

        h4 { font-weight: 700; color: #1a2e22; text-align: center; margin-bottom: 4px; }
        p.subtitle { color: #6b7280; font-size: 13.5px; text-align: center; margin-bottom: 28px; }

        .form-label { font-weight: 500; font-size: 14px; color: #374151; }

        .input-group-text {
            background-color: #f8f9fa;
            color: #6b7280;
        }
        .input-group > .input-group-text:first-child {
            border-right: none;
            border-radius: 8px 0 0 8px;
        }
        .input-group > .input-group-text:last-child {
            border-left: none;
            border-radius: 0 8px 8px 0;
            cursor: pointer;
        }
        .input-group > input.form-control {
            border-left: none;
            border-right: none;
            border-radius: 0;
            padding: 10px 12px;
        }
        .input-group > input#usernameInput.form-control {
            border-right: 1px solid #ced4da;
            border-radius: 0 8px 8px 0;
        }
        .input-group .form-control:focus { box-shadow: none; }

        .btn-login {
            background-color: #1a5f3f;
            border: none;
            border-radius: 8px;
            padding: 11px;
            font-weight: 600;
            color: #fff;
            width: 100%;
        }
        .btn-login:hover { background-color: #0d3d28; color: #fff; }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="icon-box"><i class="bi bi-building"></i></div>
        <h4>Sistem Informasi Pengelolaan Inventaris dan Aset Desa</h4>
        <p class="subtitle">Desa Hegarmanah, Kec. Sukaluyu, Kab. Cianjur</p>

        @if($errors->any())
            <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
        @endif

        <form action="/login" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="username" id="usernameInput" class="form-control" placeholder="Masukkan username" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Masukkan password" required>
                    <span class="input-group-text" onclick="togglePassword()">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </span>
                </div>
            </div>
            <button type="submit" class="btn btn-login">Login</button>
        </form>
    </div>

    <script>
    function togglePassword() {
        const input = document.getElementById('passwordInput');
        const icon = document.getElementById('toggleIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
    </script>
</body>
</html>