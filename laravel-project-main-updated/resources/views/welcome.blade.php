<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>HRMS Portal</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>

    * {

      margin: 0;

      padding: 0;

      box-sizing: border-box;

    }

    body,

    html {

      height: 100%;

      font-family: 'Poppins', sans-serif;

    }

    .hero {

      background: url('https://www.completeconnection.ca/wp-content/uploads/2020/08/HRMS.jpg') no-repeat center center/cover;

      height: 100vh;

      color: white;

      display: flex;

      justify-content: center;

      align-items: center;

      text-align: center;

      position: relative;

    }

    .overlay {

      position: absolute;

      inset: 0;

      background-color: rgba(0, 0, 0, 0.6);

      z-index: 1;

    }

    .hero-content {

      position: relative;

      z-index: 2;

      max-width: 700px;

      padding: 30px;

      background-color: rgba(255, 255, 255, 0.1);

      border-radius: 16px;

      backdrop-filter: blur(10px);

      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);

    }

    .hero h1 {

      font-size: 48px;

      font-weight: 600;

      color: #fff;

      margin-bottom: 20px;

    }

    .hero p {

      font-size: 20px;

      color: #f1f1f1;

      margin-bottom: 35px;

    }

    .button-group {

      display: flex;

      gap: 20px;

      justify-content: center;

      flex-wrap: wrap;

    }

    .button-group a {

      text-decoration: none;

      padding: 14px 30px;

      background-color: #ffcc00;

      color: #003366;

      font-weight: 600;

      border-radius: 30px;

      transition: all 0.3s ease-in-out;

      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);

    }

    .button-group a:hover {

      background-color: #ffc107;

      transform: translateY(-3px);

    }

    @media (max-width: 768px) {

      .hero h1 {

        font-size: 32px;

      }

      .hero p {

        font-size: 16px;

      }

      .hero-content {

        padding: 20px;

      }

    }
</style>
</head>

<body>
<section class="hero">
<div class="overlay"></div>
<div class="hero-content">
<h1>Welcome to the HRMS Portal</h1>
<p>Modern platform to manage Human Resources, Attendance, Payroll, and more.</p>
<div class="button-group">

        @if (Route::has('login'))

          @auth
<a href="{{ url('/dashboard') }}">Go to Dashboard</a>

          @else
<a href="{{ route('login') }}">Log In</a>

            {{-- @if (Route::has('register'))
<a href="{{ route('register') }}">Register</a>

            @endif --}}

          @endauth

        @endif
</div>
</div>
</section>
</body>
</html>

