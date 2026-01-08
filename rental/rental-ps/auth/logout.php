<?php
session_start();

/* HAPUS SEMUA SESSION */
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Logout | Rental PlayStation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Orbitron&family=Poppins&display=swap" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            margin: 0;
            background: radial-gradient(circle at top, #1e40af, #020617);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            color: #e5e7eb;
        }

        .logout-box {
            background: rgba(2, 6, 23, 0.95);
            border: 1px solid #1e293b;
            border-radius: 18px;
            padding: 40px;
            text-align: center;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 0 40px rgba(56,189,248,0.4);
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logout-box h2 {
            font-family: 'Orbitron', sans-serif;
            color: #38bdf8;
            margin-bottom: 10px;
        }

        .logout-box p {
            font-size: 14px;
            color: #94a3b8;
            margin-bottom: 30px;
        }

        .btn-login {
            display: inline-block;
            padding: 12px 28px;
            background: linear-gradient(135deg, #2563eb, #22d3ee);
            color: #020617;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-login:hover {
            opacity: 0.9;
            transform: scale(1.03);
        }

        .footer {
            margin-top: 25px;
            font-size: 12px;
            color: #64748b;
        }
    </style>
</head>
<body>

<div class="logout-box">
    <h2>Logout Berhasil</h2>
    <p>Anda telah keluar dari sistem Rental PlayStation.</p>

    <a href="login.php" class="btn-login">Login Kembali</a>

    <div class="footer">
        © <?php echo date('Y'); ?> Rental PlayStation
    </div>
</div>

</body>
</html>
