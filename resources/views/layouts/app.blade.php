<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        #calendar {
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        /* Color Palette */
        :root {
            --primary: #4361ee;       /* Vibrant blue */
            --primary-dark: #3a56d4;  /* Darker blue */
            --secondary: #f72585;     /* Pink accent */
            --success: #4cc9f0;       /* Light blue */
            --info: #4895ef;         /* Medium blue */
            --warning: #f8961e;      /* Orange */
            --danger: #ef233c;       /* Red */
            --light: #f8f9fa;        /* Off-white */
            --dark: #212529;         /* Dark gray */
            --gray: #6c757d;         /* Medium gray */
        }

        /* Base Styles */
        body {
            background-color: var(--light);
            color: var(--dark);
            font-family: 'Nunito', sans-serif;
        }

        /* Navbar */
        .navbar {
            background-color: var(--primary) !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            color: white !important;
            font-weight: 700;
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            color: var(--light) !important;
            transform: scale(1.02);
        }

        .navbar-toggler {
            border-color: rgba(255,255,255,0.5);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3e%3cpath stroke='rgba(255, 255, 255, 0.8)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Navigation Links */
        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            border-radius: 0.25rem;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: white !important;
            background-color: rgba(255,255,255,0.1);
        }

        /* Dropdown Menu */
        .dropdown-menu {
            background-color: white;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
            border-radius: 0.5rem;
        }

        .dropdown-item {
            color: var(--dark);
            padding: 0.5rem 1.25rem;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: var(--light);
            color: var(--primary);
        }

        /* Main Content */
        main {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
            margin: 1.5rem auto;
            padding: 2rem;
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        /* Forms */
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        }

        /* Alerts */
        .alert {
            border-radius: 0.5rem;
            border-left: 4px solid;
        }

        .alert-primary {
            background-color: rgba(67, 97, 238, 0.1);
            border-left-color: var(--primary);
            color: var(--primary-dark);
        }

        .alert-success {
            background-color: rgba(76, 201, 240, 0.1);
            border-left-color: var(--success);
            color: #0d6efd;
        }

        /* Utility Classes */
        .bg-light {
            background-color: var(--light) !important;
        }

        .text-primary {
            color: var(--primary) !important;
        }
    </style>
</head>
<body>
<div id="app">
    @include('sweetalert2::index')
    <nav class="navbar navbar-expand-md navbar-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-1"></i> {{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}"><i class="fas fa-user-plus me-1"></i> {{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#"><i class="fas fa-user me-1 text-primary"></i> Profile</a>
                                <a class="dropdown-item" href="{{route('settings.platforms')}}"><i class="fas fa-cog me-1 text-primary"></i> Settings</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-1 text-danger"></i> {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4 container">
        <!-- Example Alert -->
        <div class="alert alert-primary mb-4">
            <i class="fas fa-info-circle me-2"></i> Welcome to our application!
        </div>

        @yield('content')
    </main>
</div>

<!-- jQuery (optional, needed for some Bootstrap features) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- FullCalendar JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
</body>
</html>
