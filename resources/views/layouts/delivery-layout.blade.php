<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Delivery Panel') }}</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>

        body {
            background: #f1f3f6;
            font-family: 'Arial', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }


        .navbar {
            background: #A3D9A5 !important;
            padding: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            font-size: 22px;
            font-weight: bold;
            color: white !important;
        }
        .nav-link {
            color: white !important;
            font-weight: bold;
            margin: 0 10px;
            transition: 0.3s;
        }
        .nav-link:hover {
            color: #d4edda !important;
        }
        .navbar-toggler {
            border-color: white;
        }


        .logout-btn {
            background: white !important;
            color: black !important;
            font-weight: bold;
            border-radius: 8px;
            padding: 8px 15px;
            transition: 0.3s;
        }
        .logout-btn:hover {
            background: #d4edda !important;
        }


        .main-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            width: 95%;
            max-width: 1200px;
            flex: 1;
        }

        /* Search Bar */
        .search-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .search-bar input, .search-bar select {
            border-radius: 8px;
            padding: 10px;
            border: 1px solid #ccc;
        }

        /* Stats Cards */
        .stats-card {
            background: #E8F5E9;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            font-size: 16px;
            font-weight: bold;
            transition: 0.3s;
        }
        .stats-card i {
            font-size: 24px;
            margin-bottom: 5px;
            color: #28a745;
        }
        .stats-card:hover {
            transform: scale(1.05);
        }

        /* Table Styling */
        .table-container {
            overflow-x: auto;
        }
        .table {
            background: white;
            width: 100%;
            border-radius: 10px;
            overflow: hidden;
            font-size: 16px;
        }
        .table th {
            background: #A3D9A5;
            color: black;
            font-size: 18px;
            text-align: center;
            padding: 15px;
        }
        .table td {
            text-align: center;
            font-size: 16px;
            padding: 15px;
        }
        .table tr:hover {
            background: #E8F5E9;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 20px;
            background: #A3D9A5;
            color: black;
            font-size: 16px;
            width: 100%;
            margin-top: auto;
            border-top: 3px solid #8BC78B;
        }
        .footer a {
            color: black;
            margin: 0 15px;
            font-size: 20px;
            transition: 0.3s;
        }
        .footer a:hover {
            color: #555;
        }

    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">🚚 Delivery Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.myOrders') }}"><i class="fas fa-truck"></i> Delivery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link logout-btn" href="#"><i class="fas fa-sign-out-alt"></i> Log Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="main-container">

        <!-- Search Bar & Filters -->
        <div class="search-bar">
            <input type="text" class="form-control me-2" placeholder="🔍 Search Orders">
            <select class="form-control">
                <option value="">All Orders</option>
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
                <option value="canceled">Canceled</option>
            </select>
        </div>

        <!-- Mini Statistics -->
        <div class="row text-center mb-4">
            <div class="col-md-4">
                <div class="stats-card">
                    <i class="fas fa-list"></i>
                    <p>Total Orders: 150</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <i class="fas fa-check-circle"></i>
                    <p>Completed Orders: 120</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <i class="fas fa-clock"></i>
                    <p>Pending Orders: 30</p>
                </div>
            </div>
        </div>

        @yield('content')

    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; {{ date('Y') }} Delivery System | All Rights Reserved</p>
        <div>
            <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://wa.me/+1234567890" target="_blank"><i class="fab fa-whatsapp"></i></a>
            <a href="https://www.google.com/chrome/" target="_blank"><i class="fab fa-chrome"></i></a>
            <a href="https://www.mozilla.org/firefox/" target="_blank"><i class="fab fa-firefox"></i></a>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
