<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HRMS Portal</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body,
    html {
      height: 100%;
      font-family: 'Segoe UI', sans-serif;
    }

    .hero {
      background: url('https://www.completeconnection.ca/wp-content/uploads/2020/08/HRMS.jpg') no-repeat center center/cover;
      height: 100vh;
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      position: relative;
    }

    .overlay {
      position: absolute;
      inset: 0;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 1;
    }

    .hero-content {
      position: relative;
      z-index: 2;
      max-width: 800px;
      padding: 20px;
      color: rgb(5, 0, 0)
    }

    .hero h1 {
      font-size: 48px;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .hero p {
      font-size: 20px;
      margin-bottom: 30px;
    }

    .button-group {
      display: flex;
      gap: 15px;
      justify-content: center;
      flex-wrap: wrap;
    }

    .button-group a {
      text-decoration: none;
      padding: 12px 24px;
      background-color: #ffcc00;
      color: #003366;
      font-weight: bold;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    .button-group a:hover {
      background-color: #ffd633;
    }

    @media (max-width: 768px) {
      .hero h1 {
        font-size: 32px;
      }

      .hero p {
        font-size: 16px;
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
            <a href="{{ url('/dashboard') }}">Dashboard</a>
          @else
            <a href="{{ route('login') }}">Log in</a>
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
