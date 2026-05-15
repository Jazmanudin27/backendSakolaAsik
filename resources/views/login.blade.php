<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sakola Asik - Login</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #4f46e5, #06b6d4);
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
            background: #fff;
        }

        .login-header {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            text-align: center;
            padding: 25px;
        }

        .logo {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
        }

        .logo i {
            font-size: 26px;
        }

        .login-body {
            padding: 30px;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
        }

        .btn-login {
            background: #4f46e5;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
        }

        .btn-login:hover {
            background: #4338ca;
        }

        .divider {
            height: 1px;
            background: #eee;
            margin: 20px 0;
        }

        .footer {
            font-size: 12px;
            color: #999;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="login-card">

        <!-- HEADER -->
        <div class="login-header">
            <div class="logo">
                <i class="fas fa-school"></i>
            </div>
            <h4 class="mb-0">Sakola Asik</h4>
            <small>Sistem Informasi Sekolah</small>
        </div>

        <!-- BODY -->
        <div class="login-body">

            {{-- ERROR --}}
            @error('login')
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ $message }}
                </div>
            @enderror

            {{-- SUCCESS --}}
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <!-- USERNAME -->
                <div class="mb-3">
                    <label class="form-label">Email / Username</label>
                    <input type="text" name="email" class="form-control" placeholder="Masukkan email atau username"
                        value="{{ old('email') }}" required>
                </div>

                <!-- PASSWORD -->
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password"
                        required>
                </div>

                <!-- REMEMBER -->
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>

                <!-- BUTTON -->
                <button class="btn btn-primary btn-login w-100">
                    <i class="fas fa-right-to-bracket me-1"></i> Login
                </button>
            </form>

            <div class="divider"></div>

            <div class="footer">
                © {{ date('Y') }} Sakola Asik
            </div>

        </div>
    </div>

</body>

</html>
