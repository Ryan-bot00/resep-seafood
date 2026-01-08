<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Rental PlayStation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600&family=Poppins:wght@300;400&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            background: radial-gradient(circle at top, #1e40af, #020617);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }

        .login-box {
            width: 100%;
            max-width: 420px;
            background: rgba(15, 23, 42, 0.95);
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 0 40px rgba(37, 99, 235, 0.6);
            position: relative;
            overflow: hidden;
        }

        .login-box::before {
            content: '';
            position: absolute;
            inset: -2px;
            background: linear-gradient(120deg, #2563eb, #22d3ee, #2563eb);
            z-index: -1;
            filter: blur(20px);
        }

        .logo {
            text-align: center;
            font-family: 'Orbitron', sans-serif;
            font-size: 26px;
            color: #38bdf8;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            font-size: 14px;
            color: #94a3b8;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 13px;
            color: #cbd5f5;
            display: block;
            margin-bottom: 6px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 14px;
            background: #020617;
            border: 1px solid #1e293b;
            border-radius: 10px;
            color: #e5e7eb;
            outline: none;
            transition: 0.3s;
        }

        .form-group input:focus {
            border-color: #38bdf8;
            box-shadow: 0 0 10px rgba(56,189,248,0.5);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #2563eb, #22d3ee);
            border: none;
            border-radius: 10px;
            color: #020617;
            font-weight: 600;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            opacity: 0.9;
        }

        /* Loading */
        .btn-login.loading {
            pointer-events: none;
            background: #020617;
            color: transparent;
        }

        .btn-login.loading::after {
            content: '';
            width: 24px;
            height: 24px;
            border: 3px solid #38bdf8;
            border-top-color: transparent;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: translate(-50%, -50%) rotate(360deg); }
        }

        .error {
            background: rgba(220,38,38,0.15);
            color: #fecaca;
            padding: 10px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .footer {
            text-align: center;
            margin-top: 25px;
            font-size: 12px;
            color: #64748b;
        }
    </style>
</head>
<body>

<div class="login-box">
    <div class="logo">RENTAL PS</div>
    <div class="subtitle">PlayStation Rental System</div>

    <?php if (isset($_GET['error'])) { ?>
        <div class="error">
            Login gagal. Periksa username atau password.
        </div>
    <?php } ?>

    <form id="loginForm" action="proses_login.php" method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit" class="btn-login" id="loginBtn">
            LOGIN
        </button>
    </form>

    <div class="footer">
        © <?php echo date('Y'); ?> Rental PlayStation
    </div>
</div>

<script>
    const form = document.getElementById('loginForm');
    const btn = document.getElementById('loginBtn');

    form.addEventListener('submit', function () {
        btn.classList.add('loading');
    });
</script>

</body>
</html>
