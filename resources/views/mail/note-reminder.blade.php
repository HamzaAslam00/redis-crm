<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Note Reminder</title>
    <style>
        body { font-family: 'DM Sans', Arial, sans-serif; background: #f4f4f7; margin: 0; padding: 0; }
        .wrapper { max-width: 580px; margin: 40px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #FF6400, #FF8C00); padding: 32px 36px; text-align: center; }
        .header h1 { margin: 0; color: #fff; font-size: 22px; font-weight: 700; }
        .header p { margin: 6px 0 0; color: rgba(255,255,255,0.85); font-size: 14px; }
        .body { padding: 32px 36px; }
        .label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #999; margin-bottom: 4px; }
        .note-box { background: #f9f9fb; border-left: 4px solid #FF6400; border-radius: 6px; padding: 16px 20px; margin-bottom: 20px; }
        .note-box .title { font-size: 17px; font-weight: 700; color: #1a1a1a; margin-bottom: 8px; }
        .note-box .content { font-size: 14px; color: #555; line-height: 1.6; }
        .message-box { background: #fff8f3; border: 1px solid #ffe0c8; border-radius: 8px; padding: 14px 18px; margin-bottom: 24px; font-size: 14px; color: #7a4020; line-height: 1.55; }
        .meta { font-size: 13px; color: #888; margin-bottom: 24px; }
        .meta strong { color: #444; }
        .btn { display: inline-block; background: #FF6400; color: #fff; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 14px; }
        .footer { background: #f4f4f7; padding: 20px 36px; text-align: center; font-size: 12px; color: #aaa; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <h1>🔔 Note Reminder</h1>
        <p>Redis Solution CRM — Personal Notes</p>
    </div>
    <div class="body">
        <p style="font-size:15px;color:#333;margin:0 0 20px">
            Hi <strong>{{ $reminder->user?->name ?? 'there' }}</strong>, you set a reminder for the following note:
        </p>

        <div class="note-box">
            @if($reminder->note?->title)
                <div class="title">{{ $reminder->note->title }}</div>
            @endif
            @if($reminder->note?->content)
                <div class="content">{{ Str::limit(strip_tags($reminder->note->content), 280) }}</div>
            @endif
        </div>

        @if($reminder->custom_message)
            <div class="label">Your Reminder Note</div>
            <div class="message-box">{{ $reminder->custom_message }}</div>
        @endif

        <div class="meta">
            <strong>Reminder set for:</strong> {{ $reminder->remind_at->format('d M Y \a\t h:i A') }}
        </div>

        <a href="{{ route('admin.notes.edit', $reminder->note_id) }}" class="btn">Open Note →</a>
    </div>
    <div class="footer">
        This is an automated reminder from Redis Solution CRM.<br>
        You are receiving this because you set a reminder on this note.
    </div>
</div>
</body>
</html>
