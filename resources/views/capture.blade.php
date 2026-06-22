<!DOCTYPE html>
<html>
<head>
    <title>Face Attendance</title>
</head>
<body>
    <h2>Mark Attendance</h2>

    @if(session('success')) <p>{{ session('success') }}</p> @endif
    @if(session('error')) <p>{{ session('error') }}</p> @endif

    <form method="POST" action="/attendance/mark">
        @csrf
        <button type="submit" name="status" value="entry">Entry</button>
        <button type="submit" name="status" value="exit">Exit</button>
    </form>
</body>
</html>
