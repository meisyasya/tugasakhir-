<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            color: #333;
            padding: 30px;
            text-align: center;
        }
        .container {
            background-color: #fff;
            border-radius: 10px;
            padding: 40px 30px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        .title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #4a4a4a;
        }
        .message {
            font-size: 16px;
            margin-bottom: 30px;
            color: #666;
        }
        .reset-link {
            display: inline-block;
            background-color: #6f42c1;
            color: #fff !important;
            padding: 12px 24px;
            border-radius: 6px;
            font-size: 16px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .reset-link:hover {
            background-color: #5a32a3;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #aaa;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">Permintaan Reset Password</div>
        <div class="message">
            Hai, kamu telah meminta untuk mereset password.<br>
            Klik tombol di bawah ini untuk melanjutkan.
        </div>

        @if($token)
            {{-- <a href="{{ route('validasi-forgot-password', ['token' => $token]) }}" class="reset-link">
                Reset Password
            </a> --}}
            <a href="{{ route('reset-password', ['token' => $token]) }}" class="reset-link">
                Reset Password
            </a>
        @else
            <p>Token tidak valid. Silakan coba lagi.</p>
        @endif

        <div class="footer">
            Jika kamu tidak merasa melakukan permintaan ini, abaikan email ini.
        </div>
    </div>
</body>
</html>
