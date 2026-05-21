<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>HRMS Login</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
          rel="stylesheet">

    <style>

        *{
            font-family: 'Inter', sans-serif;
        }

        body{
            min-height:100vh;
            background:
                linear-gradient(135deg,
                #0f172a 0%,
                #1e293b 40%,
                #2563eb 100%);
            overflow-x:hidden;
        }

        .login-wrapper{
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:30px 15px;
        }

        .login-card{
            width:100%;
            max-width:460px;
            background:rgba(255,255,255,0.12);
            backdrop-filter:blur(18px);
            border:1px solid rgba(255,255,255,0.18);
            border-radius:28px;
            overflow:hidden;
            box-shadow:
                0 20px 60px rgba(0,0,0,0.35);
        }

        .login-body{
            padding:45px;
        }

        .brand-logo{
            width:80px;
            height:80px;
            border-radius:22px;
            background:linear-gradient(135deg,#3b82f6,#2563eb);
            display:flex;
            align-items:center;
            justify-content:center;
            margin:auto;
            box-shadow:0 10px 25px rgba(37,99,235,0.4);
        }

        .brand-logo i{
            font-size:38px;
            color:#fff;
        }

        .login-title{
            font-size:32px;
            font-weight:700;
            color:#fff;
            margin-top:22px;
        }

        .login-subtitle{
            color:rgba(255,255,255,0.75);
            font-size:15px;
            margin-top:8px;
        }

        .form-label{
            color:#fff;
            font-weight:500;
            margin-bottom:10px;
        }

        .input-group{
            border-radius:16px;
            overflow:hidden;
            background:rgba(255,255,255,0.08);
            border:1px solid rgba(255,255,255,0.12);
        }

        .input-group-text{
            background:transparent;
            border:none;
            color:#cbd5e1;
            padding-left:18px;
        }

        .form-control{
            background:transparent;
            border:none;
            color:#fff;
            height:54px;
            font-size:15px;
        }

        .form-control:focus{
            box-shadow:none;
            background:transparent;
            color:#fff;
        }

        .form-control::placeholder{
            color:rgba(255,255,255,0.5);
        }

        .form-check-label{
            color:#e2e8f0;
            font-size:14px;
        }

        .form-check-input{
            border-color:#94a3b8;
        }

        .form-check-input:checked{
            background-color:#2563eb;
            border-color:#2563eb;
        }

        .login-btn{
            height:54px;
            border:none;
            border-radius:16px;
            background:linear-gradient(135deg,#3b82f6,#2563eb);
            font-size:16px;
            font-weight:600;
            transition:0.3s ease;
            box-shadow:0 10px 25px rgba(37,99,235,0.35);
        }

        .login-btn:hover{
            transform:translateY(-2px);
            box-shadow:0 14px 30px rgba(37,99,235,0.45);
        }

        .forgot-link{
            color:#bfdbfe;
            text-decoration:none;
            font-size:14px;
            transition:0.3s;
        }

        .forgot-link:hover{
            color:#fff;
        }

        .invalid-feedback{
            display:block;
        }

        .alert{
            border-radius:14px;
        }

        @media(max-width:576px){

            .login-body{
                padding:30px 22px;
            }

            .login-title{
                font-size:26px;
            }

        }

    </style>

</head>

<body>

<div class="login-wrapper">

    <div class="login-card">

        <div class="login-body">

            <!-- Logo -->
            <div class="text-center mb-4">

                <div class="brand-logo">

                    <i class="bi bi-person-workspace"></i>

                </div>

                <h1 class="login-title">
                    HRMS Login
                </h1>

                <p class="login-subtitle">
                    Welcome back! Please login to your account
                </p>

            </div>

            <!-- Success Message -->
            @if (session('status'))

                <div class="alert alert-success">

                    {{ session('status') }}

                </div>

            @endif

            <!-- Login Form -->
            <form method="POST"
                  action="{{ route('login') }}">

                @csrf

                <!-- Email -->
                <div class="mb-4">

                    <label class="form-label">
                        Email Address
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-envelope"></i>
                        </span>

                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="Enter your email"
                               required
                               autofocus>

                    </div>

                    @error('email')

                        <div class="invalid-feedback mt-2">

                            {{ $message }}

                        </div>

                    @enderror

                </div>

                <!-- Password -->
                <div class="mb-3">

                    <label class="form-label">
                        Password
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>

                        <input type="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Enter your password"
                               required>

                    </div>

                    @error('password')

                        <div class="invalid-feedback mt-2">

                            {{ $message }}

                        </div>

                    @enderror

                </div>

                <!-- Remember + Forgot -->
                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div class="form-check">

                        <input type="checkbox"
                               name="remember"
                               class="form-check-input"
                               id="remember">

                        <label class="form-check-label"
                               for="remember">

                            Remember Me

                        </label>

                    </div>

                    <a href="{{ route('password.request') }}"
                       class="forgot-link">

                        Forgot Password?

                    </a>

                </div>

                <!-- Login Button -->
                <div class="d-grid">

                    <button type="submit"
                            class="btn btn-primary login-btn">

                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Login

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>