<!DOCTYPE html>
<html>

<head>
    <title>Nhắc nhở: {{ $note->title }}</title>
</head>

<body>
    <h1>Chào {{ $note->user->name }},</h1>

    <p>Đây là nhắc nhở cho ghi chú của bạn:</p>
    <h2>{{ $note->title }}</h2>
    <div>
        {!! nl2br(e($note->content)) !!}
    </div>

    <p>Thời gian nhắc nhở: {{ $note->reminder->reminder_at->format('H:i:s d/m/Y') }}</p>

    <p>Cảm ơn bạn!</p>
</body>

</html>
