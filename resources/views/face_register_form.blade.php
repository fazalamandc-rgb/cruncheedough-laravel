<!DOCTYPE html>
<html>
<head>
    <title>Register Face</title>
</head>
<body>
    <h2>Register Face</h2>
    
        <form action="{{ route('attendance.register-face') }}" method="POST">
        @csrf
        <input type="text" name="user_id" placeholder="User ID" required>
        <input type="text" name="user_name" placeholder="User Name" required>
        <button type="submit">Capture Face</button>
    </form>
    
</body>
</html>
