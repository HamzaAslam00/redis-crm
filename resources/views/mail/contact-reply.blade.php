<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $reply->subject }}</title>
    <style>
        body { font-family: 'DM Sans', Arial, sans-serif; background: #f4f4f7; margin: 0; padding: 0; }
        .wrapper { max-width: 580px; margin: 40px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #FF6400, #FF8C00); padding: 32px 36px; }
        .header h1 { margin: 0; color: #fff; font-size: 20px; font-weight: 700; }
        .header p { margin: 6px 0 0; color: rgba(255,255,255,0.85); font-size: 13px; }
        .body { padding: 32px 36px; }
        .body p { font-size: 15px; color: #333; line-height: 1.65; margin: 0 0 20px; }
        .reply-body { font-size: 14px; color: #333; line-height: 1.7; margin-bottom: 28px; }
        .divider { border: none; border-top: 1px solid #e8e8ec; margin: 28px 0; }
        .meta { font-size: 12px; color: #aaa; }
        .footer { background: #f4f4f7; padding: 20px 36px; text-align: center; font-size: 12px; color: #aaa; }
        .footer a { color: #FF6400; text-decoration: none; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <h1>Redis Solution</h1>
        <p>redissolution.com</p>
    </div>
    <div class="body">
        <p>Hi <strong>{{ $reply->to_name }}</strong>,</p>

        <div class="reply-body">
            {!! nl2br(e($reply->body)) !!}
        </div>

        <hr class="divider">

        <div class="meta">
            Replied by {{ $reply->sender?->name ?? 'Redis Solution Team' }}<br>
            {{ $reply->sent_at->format('d M Y, h:i A') }}
        </div>
    </div>
    <div class="footer">
        Redis Solution Pvt. Ltd. &mdash; <a href="{{ url('/') }}">redissolution.com</a><br>
        This is a reply to your inquiry submitted via our contact form.
    </div>
</div>
</body>
</html>
