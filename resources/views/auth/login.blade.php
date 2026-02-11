<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Activos Fijos</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/icono-herramientas.png') }}" type="image/png">
    <link rel="icon" href="{{ asset('images/icono-herramientas.png') }}" type="image/png">

    <style>
        body {
            background-color: #b8b7b7;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-box {
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            padding: 50px;
            width: 100%;
            height: auto;
            max-width: 550px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-header i {
            background: #529c65ff;
            color: white;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 32px;
        }

        .btn-success {
            background: rgb(27, 105, 47);
            border: none;
            padding: 14px;
            font-weight: 600;
            font-size: 1rem;
        }

        .btn-success:hover {
            background: #1c8b38;
        }

        .input-group-text {
            background-color: #f1f3f5;
            min-width: 45px;
        }

        .password-toggle {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .password-toggle:hover {
            background-color: #e9ecef;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        .form-control {
            padding: 12px;
            font-size: 1rem;
        }
        
        .is-invalid {
            border-color: #dc3545;
        }
        
        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }

        .icono-herramienta{
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <div class="login-header">
            <!-- <i class="fas fa-lock"></i> -->
             <img src="../../../images/icono-herramientas.png" alt="Icono Herramientas" class="icono-herramienta">
            <h3>Activos Fijos</h3>
            <p class="text-muted">Inicio de Sesión</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" id="loginForm">
            @csrf
            <div class="mb-4">
                <label for="email" class="form-label">Correo o Usuario</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-user"></i>
                    </span>
                    <input type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        id="email"
                        name="email"
                        placeholder="ejemplo@yucatan.gob.mx"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        autofocus>
                </div>
                @error('email')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password">
                    <span class="input-group-text password-toggle" id="togglePasswordBtn">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </span>
                </div>
                @error('password')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success w-100 mb-3 py-3">
                <i class="fas fa-sign-in-alt me-2"></i>Ingresar al Sistema
            </button>

            <div class="text-center mt-4">
                <hr>
                <small class="text-muted">
                    Sistema de Gestión de Activos Fijos © DIF Yucatán
                </small>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    
    <script>
        document.getElementById('togglePasswordBtn').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
                this.setAttribute('title', 'Ocultar contraseña');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
                this.setAttribute('title', 'Mostrar contraseña');
            }
            
            passwordInput.focus();
        });
        
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            let isValid = true;
            
            if (!email) {
                document.getElementById('email').classList.add('is-invalid');
                isValid = false;
            }
            
            if (!password) {
                document.getElementById('password').classList.add('is-invalid');
                isValid = false;
            }
            
            if (!isValid) {
                event.preventDefault();
            }
        });
        
        document.getElementById('email').addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
        
        document.getElementById('password').addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
        
        document.getElementById('password').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('togglePasswordBtn').click();
            }
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');
            if (emailInput && !emailInput.value) {
                emailInput.focus();
            }
        });
    </script>

</body>

</html>