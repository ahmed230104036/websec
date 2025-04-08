<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Online Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        @if (auth()->user()->hasRole('Customer'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('customer_profile') }}">Profile (Credit: {{ auth()->user()->credit }})</a>
                            </li>
                        @endif
                        @if (auth()->user()->hasPermissionTo('manage_products'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('products.create') }}">Add Product</a>
                            </li>
                        @endif
                        @if (auth()->user()->hasPermissionTo('manage_customers'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('employees.customers') }}">Manage Customers</a>
                            </li>
                        @endif
                        @if (auth()->user()->hasPermissionTo('create_employees'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.create_employee') }}">Create Employee</a>
                            </li>
                        @endif
                        @if (auth()->user()->hasPermissionTo('show_users'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('users') }}">Users</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('do_logout') }}">Logout</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>