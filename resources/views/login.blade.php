<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Portal Login - Sistem Informasi Sekolah</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #1e3c72 100%);
            min-height: 100vh;
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Animated Background Pattern */
        .bg-pattern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(255, 255, 255, 0.03) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }
        
        /* Floating Icons */
        .floating-icon {
            position: fixed;
            font-size: 2rem;
            opacity: 0.15;
            color: white;
            animation: float 6s ease-in-out infinite;
            pointer-events: none;
            z-index: 1;
        }
        
        .floating-icon:nth-child(1) { top: 10%; left: 5%; animation-delay: 0s; }
        .floating-icon:nth-child(2) { top: 20%; right: 10%; animation-delay: 1s; }
        .floating-icon:nth-child(3) { top: 60%; left: 8%; animation-delay: 2s; }
        .floating-icon:nth-child(4) { top: 70%; right: 5%; animation-delay: 3s; }
        .floating-icon:nth-child(5) { top: 40%; left: 3%; animation-delay: 4s; }
        .floating-icon:nth-child(6) { top: 85%; left: 15%; animation-delay: 5s; }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }
        
        .login-container {
            position: relative;
            z-index: 2;
        }
        
        .login-card {
            border-radius: 25px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideUp 0.8s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .card-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            border: none;
            padding: 2.5rem 2rem;
            position: relative;
            overflow: hidden;
        }
        
        .card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: shimmer 3s infinite;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%); }
            100% { transform: translateX(100%) translateY(100%); }
        }
        
        .school-logo {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .school-logo i {
            font-size: 2.5rem;
            color: #1e3c72;
        }
        
        .school-motto {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.85rem;
            font-style: italic;
            margin-top: 0.5rem;
        }
        
        .card-body {
            padding: 2.5rem;
        }
        
        .form-control {
            border-radius: 12px;
            border: 2px solid #e8e8e8;
            padding: 14px 18px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        
        .form-control:focus {
            border-color: #2a5298;
            box-shadow: 0 0 0 4px rgba(42, 82, 152, 0.15);
            background: white;
        }
        
        .form-label {
            font-weight: 600;
            color: #333;
            font-size: 0.9rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s ease;
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(30, 60, 114, 0.4);
        }
        
        .alert {
            border-radius: 12px;
            border: none;
            animation: shake 0.5s ease-in-out;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        .invalid-feedback {
            font-size: 12px;
            margin-top: 5px;
        }
        
        .form-check-input:checked {
            background-color: #2a5298;
            border-color: #2a5298;
        }
        
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #e8e8e8, transparent);
            margin: 1.5rem 0;
        }
        
        .footer-text {
            color: #6c757d;
            font-size: 0.8rem;
        }
        
        .footer-text i {
            color: #2a5298;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .login-card {
                border-radius: 20px;
            }
            
            .card-header {
                padding: 2rem 1.5rem;
            }
            
            .card-body {
                padding: 2rem 1.5rem;
            }
            
            .floating-icon {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Background Pattern -->
    <div class="bg-pattern"></div>
    
    <!-- Floating Educational Icons -->
    <i class="fas fa-book floating-icon"></i>
    <i class="fas fa-graduation-cap floating-icon"></i>
    <i class="fas fa-pencil-alt floating-icon"></i>
    <i class="fas fa-lightbulb floating-icon"></i>
    <i class="fas fa-globe floating-icon"></i>
    <i class="fas fa-atom floating-icon"></i>
    
    <div class="container login-container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-5 col-xl-4">
                <div class="card login-card">
                    <div class="card-header text-center text-white">
                        <div class="school-logo">
                            <i class="fas fa-school"></i>
                        </div>
                        <h4 class="mb-0 fw-bold">
                            Portal Akademik
                        </h4>
                        <p class="small mb-0 mt-2">Sistem Informasi Sekolah</p>
                        <p class="school-motto">"Mencerdaskan Kehidupan Bangsa"</p>
                    </div>
                    <div class="card-body">
                        
                        {{-- LOGIN ERROR --}}
                        @error('login')
                            <div class="alert alert-danger" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                {{ $message }}
                            </div>
                        @enderror

                        {{-- SUCCESS --}}
                        @if(session('success'))
                            <div class="alert alert-success" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.submit') }}">
                            @csrf

                            {{-- EMAIL --}}
                            <div class="mb-4">
                                <label for="email" class="form-label">
                                    <i class="fas fa-user me-2 text-primary"></i>
                                    Email atau Username <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" 
                                       placeholder="Masukkan email atau username" required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- PASSWORD --}}
                            <div class="mb-4">
                                <label for="password" class="form-label">
                                    <i class="fas fa-key me-2 text-primary"></i>
                                    Password <span class="text-danger">*</span>
                                </label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password" placeholder="Masukkan password" required>
                                @error('password')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- REMEMBER --}}
                            <div class="mb-4 form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Ingat saya
                                </label>
                            </div>

                            {{-- BUTTON --}}
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    Masuk Portal
                                </button>
                            </div>

                        </form>

                        <div class="divider"></div>

                        <div class="text-center">
                            <p class="footer-text mb-2">
                                <i class="fas fa-shield-alt me-1"></i>
                                Sistem Aman & Terpercaya
                            </p>
                            <p class="footer-text">
                                <i class="fas fa-copyright me-1"></i>
                                2024 Sistem Informasi Sekolah
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
