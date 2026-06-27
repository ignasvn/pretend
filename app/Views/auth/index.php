<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Pretend App</title>
    <!-- Menggunakan Font Awesome untuk icon sosial media -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #e6eef8, #d2dff2);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 30px;
            box-shadow: 0 14px 28px rgba(0,0,0,0.05), 0 10px 10px rgba(0,0,0,0.05);
            position: relative;
            width: 850px;
            max-width: 100%;
            min-height: 500px;
            display: flex;
            overflow: hidden;
        }

        /* --- Bagian Kiri: Form Sign In --- */
        .form-container {
            width: 55%;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .form-container h1 {
            font-size: 2.3rem;
            margin-bottom: 15px;
            color: #1a1a1a;
            font-weight: 700;
        }

        /* Tombol Sosial Media Kotak Ringan */
        .social-container {
            margin: 10px 0 20px 0;
            display: flex;
            gap: 10px;
        }

        .social-container a {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            height: 38px;
            width: 42px;
            color: #333;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .social-container a:hover {
            background-color: #f8fafc;
            border-color: #cbd5e1;
        }

        .span-text {
            font-size: 0.85rem;
            color: #64748b;
            margin-bottom: 20px;
        }

        /* Form Input */
        form {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .input-group {
            width: 85%;
            margin-bottom: 15px;
        }

        .input-group input {
            width: 100%;
            background-color: #f1f5f9;
            border: none;
            padding: 14px 20px;
            border-radius: 10px;
            font-size: 0.95rem;
            color: #333;
            outline: none;
        }

        .input-group input::placeholder {
            color: #94a3b8;
        }

        .forgot-password {
            color: #64748b;
            font-size: 0.85rem;
            text-decoration: none;
            margin-top: 5px;
            margin-bottom: 25px;
            transition: color 0.2s;
        }

        .forgot-password:hover {
            color: #4f46e5;
        }

        /* Tombol Submit */
        .btn-signin {
            border-radius: 8px;
            border: none;
            background: #4f3cc3;
            color: #ffffff;
            font-size: 0.85rem;
            font-weight: bold;
            padding: 12px 45px;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .btn-signin:hover {
            background: #3f2fa3;
        }


        /* --- Bagian Kanan: Overlay Ungu dengan Curve --- */
        .overlay-container {
            width: 45%;
            background: linear-gradient(135deg, #5944d3, #3f29b3);
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            text-align: center;
            position: relative;
            /* Membuat efek lengkungan melingkar besar di sisi kiri panel ungu */
            border-bottom-left-radius: 120px;
            border-top-left-radius: 120px;
        }

        .overlay-container h2 {
            font-size: 2.2rem;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .overlay-container p {
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 30px;
            padding: 0 10px;
            color: #e0d7ff;
        }

        /* Tombol Sign Up Transparan */
        .btn-signup {
            background-color: transparent;
            border: 1.5px solid #ffffff;
            color: #ffffff;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: bold;
            padding: 12px 45px;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-signup:hover {
            background-color: #ffffff;
            color: #4f3cc3;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Panel Kiri: Form -->
        <div class="form-container">
            <h1>Sign In</h1>
            
            <!-- Tombol Media Sosial -->
            <div class="social-container">
                <a href="#"><i class="fab fa-google-plus-g"></i></a>
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-github"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
            
            <span class="span-text">or use your email password</span>
            
            <!-- Arahkan action ke URL proses di CodeIgniter kamu -->
            <form action="<?= base_url('proses-login') ?>" method="POST">
                <!-- Proteksi CSRF bawaan CI4 -->
                <?= csrf_field() ?>

                <div class="input-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                
                <a href="#" class="forgot-password">Forget Your Password?</a>
                
                <button type="submit" class="btn-signin">Sign In</button>
            </form>
        </div>

        <!-- Panel Kanan: Overlay Ungu -->
        <div class="overlay-container">
            <h2>Hello, Pretend!</h2>
            <p>Register with your personal details to use all of site features</p>
            <button class="btn-signup" onclick="location.href='<?= base_url('register') ?>'">Sign Up</button>
        </div>
    </div>

</body>
</html>