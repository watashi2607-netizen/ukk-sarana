<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Sekarang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #4f6edb, #2b49c9);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            background: #fff;
            width: 100%;
            max-width: 420px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,.15);
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo img {
            width: 60px;
        }

        .title {
            text-align: center;
            font-size: 22px;
            margin-bottom: 20px;
        }

        /* TAB */
        .tabs {
            display: flex;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 20px;
            background: #f1f1f1;
        }

        .tab {
            flex: 1;
            padding: 10px;
            border: none;
            cursor: pointer;
            background: transparent;
            font-size: 15px;
        }

        .tab.active {
            background: #0d6efd;
            color: #fff;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: #4f6edb;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-login:hover {
            background: #3e5bd3;
        }

        .forgot {
            text-align: center;
            margin-top: 15px;
        }

        .forgot a {
            text-decoration: none;
            color: #4f6edb;
            font-size: 14px;
        }

        .alert {
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .alert-danger {
            background: #f8d7da;
            color: #842029;
        }

        .alert-success {
            background: #d1e7dd;
            color: #0f5132;
        }

        #adminForm { display: none; }
    </style>
</head>
<body>

<div class="login-box">

    <div class="logo">
        <!-- ganti src logo sesuai punyamu -->
        <img src="{{ asset('sbadmin2/img/Logo-SMK8.png') }}" alt="Logo">
    </div> 

    <div class="title">Login Sekarang</div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    <!-- TAB -->
    <div class="tabs">
        <button class="tab" id="tabAdmin" onclick="showAdmin()">Admin</button>
        <button class="tab active" id="tabSiswa" onclick="showSiswa()">Siswa</button>
    </div>

    <!-- FORM ADMIN -->
    <form method="POST" action="{{ route('login.post') }}" id="adminForm">
        @csrf
        <input type="hidden" name="login_type" value="admin">

        <div class="form-group">
            <input type="text" name="username" class="form-control" placeholder="Username Admin" required>
        </div>

        <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Password Admin" required>
        </div>

        <button class="btn-login">Login</button>
    </form>

    <!-- FORM SISWA -->
    <form method="POST" action="{{ route('login.post') }}" id="siswaForm">
        @csrf
        <input type="hidden" name="login_type" value="siswa">

        <div class="form-group">
            <input type="text" name="nis" class="form-control" placeholder="NIS" required>
        </div>

        <div class="form-group">
            <select name="kelas" class="form-control" required>
                <option value="">Pilih Kelas</option>
                <option value="10">Kelas 10</option>
                <option value="11">Kelas 11</option>
                <option value="12">Kelas 12</option>
               
                
            </select>
        </div>

        <button class="btn-login">Login</button>
    </form>

    <!-- <div class="forgot">
        <a href="#">Lupa Password?</a> -->
    </div>
</div>

<script>
    function showAdmin() {
        document.getElementById('adminForm').style.display = 'block';
        document.getElementById('siswaForm').style.display = 'none';
        document.getElementById('tabAdmin').classList.add('active');
        document.getElementById('tabSiswa').classList.remove('active');
    }

    function showSiswa() {
        document.getElementById('adminForm').style.display = 'none';
        document.getElementById('siswaForm').style.display = 'block';
        document.getElementById('tabAdmin').classList.remove('active');
        document.getElementById('tabSiswa').classList.add('active');
    }
</script>

</body>
</html>
