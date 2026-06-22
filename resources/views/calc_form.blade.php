<!DOCTYPE html>
<html>
<head>
    <title>Python Calculator</title>
</head>
<body>
    <h2>Simple Calculator (Laravel + Python)</h2>

    @if(session('result'))
        <p><strong>Result:</strong> {{ session('result') }}</p>
    @endif

    <form action="{{ route('calc.process') }}" method="POST">
        @csrf
        <label for="num1">Number 1:</label>
        <input type="number" name="num1" required><br><br>

        <label for="num2">Number 2:</label>
        <input type="number" name="num2" required><br><br>

        <label for="action">Action:</label>
        <select name="action">
            <option value="add">Add</option>
            <option value="subtract">Subtract</option>
            <option value="multiply">Multiply</option>
            <option value="divide">Divide</option>
        </select><br><br>

        <button type="submit">Calculate</button>
    </form>
</body>
</html>
