<!DOCTYPE html>
<html>
<head>
    <title>Webcam Capture</title>
</head>
<body>
    <h2>Capture Image from Webcam</h2>

    <form method="GET" action="{{ route('capture.image') }}">
        <button type="submit">Capture Image</button>
    </form>

    @if(session('image'))
        <h3>Captured Image:</h3>
        <img src="{{ asset(session('image')) }}" width="300" alt="Captured Image">
    @endif
</body>
</html>
