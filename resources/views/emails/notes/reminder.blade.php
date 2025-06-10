<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Nhắc nhở của Node App</title>
    <style type="text/css">
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        table {
            border-collapse: collapse !important;
        }

        body {
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            background-color: #f4f4f4;
        }

        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        @media screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
                margin: auto !important;
            }
        }
    </style>
</head>

<body style="margin: 0 !important; padding: 0 !important; background-color: #f4f4f4;">
    <div
        style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
        @if ($notes->isNotEmpty())
            Bạn có {{ $notes->count() }} ghi chú được nhắc nhở. {{-- Sửa lại câu chữ --}}
        @else
            Bạn có một thông báo nhắc nhở.
        @endif
    </div>

    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f4f4;">
        <tr>
            <td align="center" valign="top" style="padding: 20px 0;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"
                    class="email-container">
                    <tr>
                        <td align="center" style="background-color: #4A5568; padding: 20px 0;">
                            <h1
                                style="margin: 0; font-family: Arial, sans-serif; font-size: 24px; font-weight: bold; color: #ffffff;">
                                Nhắc Nhở Ghi Chú
                            </h1>
                        </td>
                    </tr>

                    <tr>
                        <td
                            style="background-color: #ffffff; padding: 30px 25px; text-align: left; font-family: Arial, sans-serif; font-size: 16px; line-height: 1.6; color: #333333;">
                            <p style="margin: 0 0 20px 0;">Chào <strong
                                    style="color: #2D3748;">{{ $user->name }}</strong>,</p>

                            <p style="margin: 0 0 20px 0;">Bạn có <strong
                                    style="color: #2D3748;">{{ $notes->count() }}</strong> ghi chú được nhắc nhở cho
                                thời điểm <strong style="color: #2D3748;">{{ $reminder->reminder_at->format('H:i') }}
                                    ngày {{ $reminder->reminder_at->format('d/m/Y') }}</strong>:</p>

                            @foreach ($notes as $note)
                                <div
                                    style="background-color: #edf2f7; border-left: 4px solid {{ $note->category->color ?? '#CBD5E0' }}; padding: 15px 20px; margin-bottom: 25px;">
                                    <h2
                                        style="margin: 0 0 10px 0; font-family: Arial, sans-serif; font-size: 20px; font-weight: bold; color: {{ $note->category->color ?? '#2D3748' }};">
                                        {{ $note->title }}
                                    </h2>
                                    <div
                                        style="font-family: Arial, sans-serif; font-size: 15px; color:  {{ $note->category->color ?? '#4A5568' }}; line-height: 1.5;">
                                        {!! nl2br(e($note->content)) !!}
                                    </div>
                                </div>
                            @endforeach


                            <p style="margin: 0;">Cảm ơn bạn đã sử dụng ứng dụng của chúng tôi!</p>
                        </td>
                    </tr>

                    <tr>
                        <td
                            style="background-color: #e2e8f0; padding: 20px 25px; text-align: center; font-family: Arial, sans-serif; font-size: 12px; line-height: 1.5; color: #718096;">
                            <p style="margin: 0 0 5px 0;">&copy; {{ date('Y') }} Note-web-laravel. Bảo lưu
                                mọi
                                quyền.</p>
                            <p style="margin: 0;">
                                {{-- [Địa chỉ của bạn] | <a href="https://en.bab.la/dictionary/vietnamese-english/h%E1%BB%A7y-%C4%91%C4%83ng-k%C3%BD" style="color: #4A5568; text-decoration: underline;">Hủy đăng ký</a> --}}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
