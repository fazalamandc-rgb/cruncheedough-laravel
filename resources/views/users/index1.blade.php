<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
</head>
<body>
    <h1>Users List</h1>
    <table border="1">
        <thead>
            <tr>
                <th>User Name</th>
                <th>Admin Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->User_Name }}</td>
                    <td>{{ $user->Admin ? 'True' : 'User' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
