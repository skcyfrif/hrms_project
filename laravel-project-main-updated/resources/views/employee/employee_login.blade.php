<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="text-center mb-4">
                    <img src="{{ asset('Picture11.jpeg') }}" alt="Company Logo" width="300">
                    <h3>Welcome to CyfrifProTech Ltd. Employee Portal!</h3>
                </div>
                <form>
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Employee ID or User Name</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Remember Me</label>
                    </div>
                    {{-- <button type="submit" class="btn btn-primary w-100">Login</button> --}}
                    <a href="{{route('emp.login')}}" class="btn btn-primary w-100">Login</a>
                </form>
                <div class="text-center mt-3">
                    <a href="#">Forgot Password?</a> | <a href="#">Help Center</a>
                </div>
                <div class="text-center mt-3">
                    <a href="#">First Time User? Register Here</a>
                </div>
            </div>
        </div>
    </div>
    <footer class="text-center mt-5 p-3 bg-light">
        <p>Need help? Contact support at <a href="mailto:support@example.com">support@example.com</a> or call <a href="tel:+1234567890">+1234567890</a></p>
        <p><a href="#">Terms of Use</a> | <a href="#">Privacy Policy</a></p>
    </footer>
</body>
</html>
