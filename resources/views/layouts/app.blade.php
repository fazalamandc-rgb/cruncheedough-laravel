<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel Application')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktc6KVRkzqEozW5kNIMqQ4EZxdQYVWwAxUlmEZ+64" crossorigin="anonymous">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        /* General Styling */
        body {
            background-color: #f0f8ff; /* Light blue background */
        }

        /* Footer */
        footer {
            background-color: #343a40;
            color: white;
            font-size: 0.8rem;
            padding: 10px 0;
            text-align: center;
        }

        /* Navigation */
        .header-nav a {
            text-decoration: none;
        }

        /* Images */
        .small-img {
            max-width: 20%;  /* Set smaller maximum width */
            height: auto;    /* Maintain aspect ratio */
        }

        /* Tables */
        .table {
            width: 100%;        /* Full width */
            table-layout: auto; /* Automatic layout for flexible columns */
            margin-bottom: 20px;
        }

        .table th, .table td {
            padding: 10px;
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word; /* Ensure long text wraps properly */
        }

        /* Footer Center Alignment */
        .footer-center {
            text-align: center;
        }

        /* Container */
        .container {
            margin: 0 auto;
            width: 100%;
            max-width: 100%;
        }

        /* Alerts */
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="bg-light py-3 shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="/" class="text-decoration-none text-dark fs-4">Exit</a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer-center">
        <p>&copy; 2025 CRUNCHEEDOUGH</p>
    </footer>

    <!-- JavaScript -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqEQ6QaPvLCh/aH+6Y3oRsHt7SZkF16YczUkN3edQoD1YtpmI2JhThzD6U9gD" crossorigin="anonymous"></script>

    <!-- Error and Success Messages -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
</body>
</html>
