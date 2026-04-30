<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background:#f4f4f8; margin:0; padding:24px; }
        .card { background:#fff; border-radius:14px; padding:32px; max-width:520px; margin:0 auto; }
        .logo { font-size:24px; font-weight:800; color:#1a1a2e; margin-bottom:24px; }
        .logo span { color:#4f8ef7; }
        .title { font-size:18px; font-weight:600; color:#1a1a2e; margin-bottom:8px; }
        .subtitle { font-size:14px; color:#6c757d; margin-bottom:24px; }
        .book-card { background:#f4f4f8; border-radius:10px; padding:16px; margin-bottom:24px; }
        .book-title { font-size:15px; font-weight:600; color:#1a1a2e; }
        .book-author { font-size:13px; color:#6c757d; margin-top:2px; }
        .due-date { font-size:13px; color:#e65100; margin-top:8px; font-weight:500; }
        .btn { display:inline-block; background:#4f8ef7; color:#fff; text-decoration:none;
            padding:10px 24px; border-radius:8px; font-size:14px; font-weight:500; margin-top:8px; }
        .footer { font-size:12px; color:#aaa; margin-top:24px; text-align:center; }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">Li<span>Browse</span></div>
        <div class="title">Your book is due tomorrow! </div>
        <div class="subtitle">Hi {{ $borrow->user->name }}, this is a friendly reminder that the following book is due tomorrow.</div>

        <div class="book-card">
            <div class="book-title">{{ $borrow->book->title }}</div>
            <div class="book-author">by {{ $borrow->book->author }}</div>
            <div class="due-date">⏰ Due: {{ $borrow->due_date->format('F d, Y') }}</div>
        </div>

        <div style="font-size:14px;color:#1a1a2e;margin-bottom:16px">
            Please return the book to the library by tomorrow to avoid being marked overdue.
            You can request a return through your LiBrowse account.
        </div>

        <a href="http://library-system.test/my-borrows" class="btn">View My Borrowed Books</a>

        <div class="footer">
            This is an automated reminder from LiBrowse School Library System.<br>
            Please do not reply to this email.
        </div>
    </div>
</body>
</html>