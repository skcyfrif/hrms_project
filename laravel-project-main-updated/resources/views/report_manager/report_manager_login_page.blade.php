<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporting Manager Login Portal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <header class="d-flex justify-content-between align-items-center p-3 bg-light border-bottom">
        <a href="#" class="navbar-brand">
            <img src="{{ asset('Picture11.jpeg') }}" alt="Company Logo" width="100">
        </a>
        <nav>
            <ul class="nav">
                <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Work Schedule</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Payroll</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Benefits</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Documents/Policies</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Support/Help</a></li>
            </ul>
        </nav>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                User Menu
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Profile Settings</a></li>
                <li><a class="dropdown-item" href="#">Notifications</a></li>
                <li><a class="dropdown-item" href="{{route('emp.logout')}}">Logout</a></li>
                {{-- <li><a class="dropdown-item" href="{{route('emp.logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                <a href="{{route('emp.logout')}}" class="btn btn-primary w-100">Logout</a> --}}
            </ul>

        </div>
        {{-- <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none"> --}}
        <form>
            @csrf
        </form>
    </header>
    <div class="container mt-5">
        <h2 class="text-center">Welcome back, [Employee Name]!</h2>
        <div class="d-flex">
            <nav class="bg-light p-3 vh-100" style="width: 250px;">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="toggleLinks">+ Quick Links</a>
                        <ul id="quickLinks" style="display: none;">
                          <li><a href="#">My Tasks</a></li>
                          <li><a href="#">Notifications</a></li>
                          <li><a href="#">Upcoming Events</a></li>
                          <li><a href="#">Clock In/Out</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#">Key Metrics</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Personal Information</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Payroll & Compensation</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Work Schedule</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Training & Development</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Leave Management</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Benefits Information</a></li>
                </ul>
            </nav>
            <div class="container mt-5">
                <h2 class="text-center">Welcome back, [Employee Name]!</h2>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <h4>Quick Links</h4>
                        <ul>
                            <li><a href="#">My Tasks</a></li>
                            <li><a href="#">Notifications</a></li>
                            <li><a href="#">Upcoming Events</a></li>
                            <li><a href="#">Clock In/Out</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h4>Key Metrics</h4>
                        <ul>
                            <li>Performance Stats</li>
                            <li>Department KPIs</li>
                            <li>Individual Goals</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    <footer class="text-center mt-5 p-3 bg-light">
        <p>Need help? Contact support at <a href="mailto:support@example.com">support@example.com</a> or call <a href="tel:+1234567890">+1234567890</a></p>
        <p><a href="#">Terms of Use</a> | <a href="#">Privacy Policy</a></p>
        <p>
            <a href="#">Company Policies</a> |
            <a href="#">IT Help Desk</a> |
            <a href="#">Feedback</a>
        </p>
        <p>
            <a href="#"><img src="{{ asset('icons8-facebook-64.png') }}" alt="Facebook" width="40"></a>
            <a href="#"><img src="{{ asset('icons8-linkedin-50.png') }}" alt="LinkedIn" width="40"></a>
            <a href="#"><img src="{{ asset('icons8-twitter-bird-64.png') }}" alt="Twitter" width="40"></a>
        </p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
