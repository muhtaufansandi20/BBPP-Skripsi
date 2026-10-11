<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sibaco</title>
    <link rel="icon" type="image/png" sizes="64x64" href="{{ asset('image/logo5.png') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#10B981',  // Hijau
                        secondary: '#F59E0B', // Kuning
                        accent: '#F97316',    // Orange
                        danger: '#EF4444',    // Red for errors
                    },
                    animation: {
                        'bounce-slow': 'bounce 3s infinite',
                        'pulse-slow': 'pulse 4s infinite',
                        'shake': 'shake 0.5s cubic-bezier(.36,.07,.19,.97) both',
                    },
                    keyframes: {
                        shake: {
                            '0%, 100%': { transform: 'translateX(0)' },
                            '10%, 30%, 50%, 70%, 90%': { transform: 'translateX(-5px)' },
                            '20%, 40%, 60%, 80%': { transform: 'translateX(5px)' },
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Font: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
        }
        .login-container {
            background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(248,250,252,0.9) 100%);
            backdrop-filter: blur(10px);
            border-left: 1px solid rgba(241, 245, 249, 0.5);
        }
        .btn-primary {
            background: linear-gradient(135deg, #10B981 0%, #F59E0B 100%);
            transition: all 0.3s ease;
            color: white;
            font-weight: 500;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3), 
                        0 2px 4px -1px rgba(245, 158, 11, 0.3);
        }
        .input-field {
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        .input-field:focus {
            border-color: #10B981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
        }
        .input-error {
            border-color: #EF4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2);
        }
        .remember-me {
            accent-color: #F59E0B;
        }
        .forgot-password-link {
            color: #64748b;
            transition: all 0.2s ease;
        }
        .forgot-password-link:hover {
            color: #F97316;
        }
        .hero-section {
            background: linear-gradient(135deg, rgba(16,185,129,0.1) 0%, rgba(245,158,11,0.05) 100%);
        }
        .floating-logo {
            animation: bounce-slow 3s infinite;
        }
        .notification {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 1000;
            max-width: 24rem;
            width: 100%;
        }
        @keyframes ping-slow {
            0% {
                transform: scale(0.8);
                opacity: 0.7;
            }
            70%, 100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }
        @keyframes float-particle-1 {
            0%, 100% {
                transform: translate(0, 0);
            }
            50% {
                transform: translate(10px, -15px);
            }
        }
        @keyframes float-particle-2 {
            0%, 100% {
                transform: translate(0, 0);
            }
            50% {
                transform: translate(-10px, 15px);
            }
        }
        .animate-ping-slow {
            animation: ping-slow 3s infinite;
        }
        .animate-float-particle-1 {
            animation: float-particle-1 5s ease-in-out infinite;
        }
        .animate-float-particle-2 {
            animation: float-particle-2 4s ease-in-out infinite reverse;
        }
        .hover\:shadow-glow:hover {
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.5), 
                       0 0 40px rgba(245, 158, 11, 0.3);
        }

        /* Mobile logo styles */
        .mobile-logo-container {
            display: none;
        }

        @media (max-width: 767px) {
            .mobile-logo-container {
                display: flex;
                justify-content: center;
                margin-bottom: 2rem;
            }
            
            .mobile-logo {
                width: 100px;
                height: 100px;
                border-radius: 50%;
                /* background: linear-gradient(135deg, #10B981 0%, #F59E0B 100%); */
                padding: 0.5rem;
                animation: bounce-slow 3s infinite;
            }
            
            .mobile-logo-inner {
                width: 100%;
                height: 100%;
                /* background: white; */
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            /* .mobile-logo img {
                width: 70px;
                height: 70px;
            } */
            
            .mobile-back-button {
                position: absolute;
                top: 1rem;
                left: 1rem;
                background: white;
                border-radius: 50%;
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                z-index: 10;
            }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col md:flex-row">
    <!-- Notification Area -->
    <div class="notification space-y-2">
        @if($errors->has('nip') || $errors->has('password'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 animate-shake rounded">
                <div class="flex items-center">
                    <div class="flex-shrink-0 mt-1">
                        <svg class="h-10 w-10 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <div class="flex text-sm text-red-700">
                            @if($errors->has('nip'))
                            <div>
                                </p>Gagal Masuk<p>
                                </p>NIP atau Password Tidak Sesuai<p>
                            </div>
                            @elseif($errors->has('password'))
                                Password yang Anda masukkan salah
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        @if(session('status'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">
                            @if(session('status') == 'password-reset')
                                Link reset password telah dikirim ke email Anda
                            @else
                                {{ session('status') }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 animate-shake">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            @if(session('error') == 'credentials')
                                Kombinasi NIP dan password tidak sesuai
                            @elseif(session('error') == 'inactive')
                                Akun Anda tidak aktif. Silakan hubungi admin
                            @else
                                Terjadi kesalahan. Silakan coba lagi
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Mobile Logo and Back Button -->
    <div class="mobile-logo-container md:hidden pt-12 relative mb-4"> 
        <a href="{{ url('/') }}" class="mobile-back-button">
            <i class="fas fa-arrow-left text-gray-600"></i>
        </a>
        <div class="mobile-logo">
            <div class="mobile-logo-inner">
                <img src="{{ asset('/image/baco.png') }}" alt="App Logo" class="ml-1">
            </div>
        </div>
    </div>

    <!-- Hero Section (Left) - Desktop -->
    <div class="hidden md:flex flex-col justify-between w-1/2 hero-section p-12">
        <div class="floating-logo relative self-center mt-12">
            <div class="absolute inset-0 rounded-full bg-primary/20 animate-ping-slow"></div>
            <div class="w-40 h-40 rounded-full bg-gradient-to-br from-primary to-accent p-2 animate-spin-slow relative z-10 hover:shadow-glow">
                <div class="w-full h-full rounded-full bg-white flex items-center justify-center">
                    <img src="{{ asset('/image/logo5.png') }}" alt="App Logo" 
                        class="ml-2 w-28 h-28 object-contain hover:rotate-12 transition-transform duration-300">
                </div>
            </div>
            <!-- Particle dots -->
            <div class="absolute -top-2 -left-2 w-4 h-4 rounded-full bg-accent animate-float-particle-1"></div>
            <div class="absolute -bottom-2 -right-2 w-3 h-3 rounded-full bg-secondary animate-float-particle-2"></div>
        </div>
        
        <div>
            <h1 class="text-4xl leading-tight font-bold text-transparent bg-clip-text bg-gradient-to-r from-primary to-accent mb-4">
                Selamat Datang di Sibaco
            </h1>
            <p class="text-gray-600 mb-4">
                Sistem Batangkaluku Cuti Online - Balai Besar Pelatihan Pertanian Batangkaluku.
            </p>

            <a href="{{ url('/') }}" 
            class="bg-gradient-to-r from-accent to-accent/60 text-white rounded-full px-6 py-2 inline-flex items-center space-x-2 text-sm shadow-md transition-transform duration-300 hover:-translate-y-0.5 hover:shadow-lg transform animate-bounce-horizontal">
                <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center transition-colors duration-300">
                    <i class="fas fa-home text-xs"></i>
                </div>
                <span>Back to Home</span>
            </a>

            <div class="flex items-center space-x-2 mt-8">
                <div class="w-3 h-3 rounded-full bg-primary animate-pulse"></div>
                <div class="w-3 h-3 rounded-full bg-secondary animate-pulse delay-100"></div>
                <div class="w-3 h-3 rounded-full bg-accent animate-pulse delay-200"></div>
            </div>
        </div>
    </div>

    <!-- Login Section (Right) -->
    <div class="w-full md:w-1/2 flex items-center justify-center login-container mt-0"> <!-- Pastikan mt-0 -->
        <div class="w-full max-w-md px-8 py-6"> <!-- Diubah py-12 menjadi py-6 -->
            <div class="mb-6 text-center md:text-left"> <!-- Diubah mb-10 menjadi mb-6 -->
                <h2 class="text-2xl font-bold text-gray-800">Masuk ke Akun Anda</h2>
                <p class="text-gray-500 mt-1">Gunakan NIP dan password untuk masuk</p> <!-- Diubah mt-2 menjadi mt-1 -->
            </div>

            <x-auth-session-status class="mb-6 p-4 rounded-lg bg-green-50 text-green-800 border border-green-200" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- NIP -->
                <div>
                    <x-input-label for="nip" :value="__('NIP')" class="block text-sm font-medium text-gray-700" />
                    <x-text-input id="nip" class="block mt-1 w-full input-field py-3 px-4 rounded-lg @error('nip') input-error @enderror" 
                                type="text" name="nip" :value="old('nip')" required autofocus autocomplete="nip" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700" />
                    <x-text-input id="password" class="block mt-1 w-full input-field py-3 px-4 rounded-lg @error('password') input-error @enderror"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                </div>

                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="remember-me rounded border-gray-300 shadow-sm focus:ring-primary" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>

                    {{-- @if (Route::has('password.request'))
                        <a class="forgot-password-link text-sm" href="{{ route('password.request') }}">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif --}}
                </div>

                <button type="submit" class="btn bg-primary text-white w-full py-3 px-6 rounded-lg font-medium flex items-center justify-center hover:scale-105 hover:bg-emerald-600">
                    {{ __('Log in') }} <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">
                    © {{ date('Y') }} Sibaco. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <script>
        // Auto-hide notifications after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const notifications = document.querySelectorAll('.notification > div');
            
            notifications.forEach(notification => {
                setTimeout(() => {
                    notification.style.transition = 'opacity 0.5s ease';
                    notification.style.opacity = '0';
                    setTimeout(() => notification.remove(), 500);
                }, 5000);
            });
            
            // Animasi getar untuk field error
            const errorFields = document.querySelectorAll('.input-error');
            errorFields.forEach(field => {
                field.classList.add('animate-shake');
                field.addEventListener('animationend', () => {
                    field.classList.remove('animate-shake');
                });
            });
        });
    </script>
</body>
</html>