<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - UKK SARANA</title>
    <style>
        body {
            background: linear-gradient(135deg, #ff9a56 0%, #ff6b35 100%);
            font-family: 'Nunito', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
            padding: 40px;
            text-align: center;
        }
        .logo {
            width: 60px;
            margin-bottom: 20px;
        }
        .title {
            font-size: 28px;
            font-weight: 800;
            color: #5a5c69;
            margin-bottom: 10px;
        }
        .subtitle {
            color: #6c757d;
            margin-bottom: 30px;
        }
        .role-buttons {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }
        .role-btn {
            flex: 1;
            padding: 15px 20px;
            border: 2px solid #e3e6f0;
            background: white;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .role-btn.active {
            border-color: #ff6b35;
            background: #ff6b35;
            color: white;
        }
        .role-btn.admin.active {
            border-color: #ff4500;
            background: #ff4500;
        }
        .role-btn.siswa.active {
            border-color: #ffa500;
            background: #ffa500;
        }
        .form-section {
            display: none;
        }
        .form-section.active {
            display: block;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .form-label {
            display: block;
            font-weight: 600;
            color: #5a5c69;
            margin-bottom: 8px;
        }
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #d1d3e2;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }
        .form-control:focus {
            outline: none;
            border-color: #ff6b35;
        }
        .btn-login {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-admin {
            background: #e74a3b;
            color: white;
        }
        .btn-admin:hover {
            background: #d52a1a;
        }
        .btn-siswa {
            background: #1cc88a;
            color: white;
        }
        .btn-siswa:hover {
            background: #17a673;
        }
        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .back-btn {
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            font-size: 14px;
            margin-top: 15px;
        }
        .back-btn:hover {
            color: #5a5c69;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <img src="{{ asset('sbadmin2/img/Logo-SMK8.png') }}" alt="SMK Logo" class="logo">
        <h1 class="title">Sistem Pengaduan Sarana</h1>
        <p class="subtitle">Pilih jenis login yang sesuai</p>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Role Selection -->
        <div id="role-selection" class="role-buttons">
            <button type="button" class="role-btn admin" onclick="showAdminForm()">Admin</button>
            <button type="button" class="role-btn siswa" onclick="showSiswaForm()">Siswa</button>
        </div>

        <!-- Admin Login Form -->
        <div id="admin-form" class="form-section">
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <input type="hidden" name="login_type" value="admin">

                <div class="form-group">
                    <label class="form-label">Username Admin</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Password Admin</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>

                <button type="submit" class="btn-login btn-admin">
                    <i class="fas fa-sign-in-alt"></i> Masuk sebagai Admin
                </button>
            </form>
            <button type="button" class="back-btn" onclick="backToSelection()">← Kembali ke pilihan</button>
        </div>

        <!-- Siswa Login Form -->
        <div id="siswa-form" class="form-section">
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <input type="hidden" name="login_type" value="siswa">

                <div class="form-group">
                    <label class="form-label">NIS</label>
                    <input type="text" name="nis" class="form-control" placeholder="Masukkan NIS" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Kelas</label>
                    <select name="kelas" class="form-control" required>
                        <option value="">Pilih Kelas</option>
                        <option value="10">Kelas 10</option>
                        <option value="11">Kelas 11</option>
                        <option value="12">Kelas 12</option>    
                    
                    </select>
                </div>

                <button type="submit" class="btn-login btn-siswa">
                    <i class="fas fa-sign-in-alt"></i> Masuk sebagai Siswa
                </button>
            </form>
            <button type="button" class="back-btn" onclick="backToSelection()">← Kembali ke pilihan</button>
        </div>
    </div>

    <script>
        function showAdminForm() {
            document.getElementById('role-selection').style.display = 'none';
            document.getElementById('admin-form').classList.add('active');
            document.getElementById('siswa-form').classList.remove('active');

            // Update button states
            document.querySelector('.role-btn.admin').classList.add('active');
            document.querySelector('.role-btn.siswa').classList.remove('active');
        }

        function showSiswaForm() {
            document.getElementById('role-selection').style.display = 'none';
            document.getElementById('siswa-form').classList.add('active');
            document.getElementById('admin-form').classList.remove('active');

            // Update button states
            document.querySelector('.role-btn.siswa').classList.add('active');
            document.querySelector('.role-btn.admin').classList.remove('active');
        }

        function backToSelection() {
            document.getElementById('role-selection').style.display = 'flex';
            document.getElementById('admin-form').classList.remove('active');
            document.getElementById('siswa-form').classList.remove('active');

            // Reset button states
            document.querySelector('.role-btn.admin').classList.remove('active');
            document.querySelector('.role-btn.siswa').classList.remove('active');
        }
    </script>
</body>
</html>