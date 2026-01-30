<!DOCTYPE html>
<html lang="id" style="margin: 0; padding: 0; background: #f3f4f6">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Reset Password</title>
    </head>

    <body style="font-family: Arial, sans-serif; background: #f3f4f6; padding: 30px">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center">
                    <table
                        role="presentation"
                        width="100%"
                        cellpadding="0"
                        cellspacing="0"
                        style="
                            max-width: 550px;
                            background: #ffffff;
                            border-radius: 14px;
                            padding: 32px;
                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
                        "
                    >
                        <tr>
                            <td align="center" style="padding-bottom: 20px">
                                <h2 style="color: #01af61; margin: 0; font-size: 26px">Reset Password</h2>
                                <p style="color: #6b7280; margin-top: 6px; font-size: 14px">
                                    Permintaan reset password diterima
                                </p>
                            </td>
                        </tr>

                        <tr>
                            <td style="padding-bottom: 25px; font-size: 15px; color: #374151; line-height: 1.6">
                                Halo
                                <strong>{{ $notifiable->name ?? 'User' }}</strong>
                                ,
                                <br />
                                <br />
                                {{-- DEBUG --}}
                                {{ $notifiable->email }}
                                {{ $notifiable->name }}
                                {{ $notifiable->username }}
                                Kami menerima permintaan untuk mereset password akun Anda. Klik tombol di bawah ini
                                untuk membuat password baru.
                            </td>
                        </tr>

                        <tr>
                            <td align="center" style="padding-bottom: 30px">
                                <a
                                    href="{{ $actionUrl }}"
                                    style="
                                        background: linear-gradient(135deg, #01af61, #23db2e);
                                        color: white;
                                        padding: 12px 28px;
                                        border-radius: 8px;
                                        font-size: 16px;
                                        text-decoration: none;
                                        display: inline-block;
                                        font-weight: bold;
                                        box-shadow: 0 4px 10px rgba(0, 150, 80, 0.3);
                                    "
                                >
                                    Reset Password
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px; color: #6b7280; line-height: 1.5">
                                Tautan ini berlaku selama
                                <strong>60 menit</strong>
                                .
                                <br />
                                <br />
                                Jika Anda tidak meminta reset password, abaikan email ini.
                            </td>
                        </tr>

                        <tr>
                            <td align="center" style="padding-top: 32px; font-size: 12px; color: #9ca3af">
                                © {{ date('Y') }} Absensi App — All rights reserved.
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
