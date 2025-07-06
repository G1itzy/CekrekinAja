<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Permintaan Reset Password</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; padding: 30px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <h2 style="color: #343a40; text-align: center;">Reset Password Akun Anda</h2>

        <p>Halo,</p>

        <p>Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('password.reset', $token) }}"
            style="background-color: #0d6efd; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 5px; display: inline-block;">
                Reset Password Sekarang
            </a>
        </div>

        <p style="color: #6c757d;">Tautan di atas hanya berlaku selama 60 menit. Jika Anda tidak meminta reset password, abaikan email ini.</p>

        <hr style="margin-top: 40px;">
        <p style="font-size: 13px; color: #6c757d; text-align: center;">&copy; {{ date('Y') }} Rental Kamera CekrekinAja Yogyakarta</p>
    </div>
</body>
</html>
