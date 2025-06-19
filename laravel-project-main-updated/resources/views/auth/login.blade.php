<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <div class="form-container">
        <form class="form-box" method="POST" action="{{ route('login') }}">

        @csrf
            <h2>Login</h2>
            <input id="login" type="text" name="login" :value="old('login')" required
                autofocus autocomplete="username" />
            <input id="password" type="password" name="password" required
                autocomplete="current-password" />
            <button type="submit">Login</button>
            {{-- <p class="switch-link">Forgot your password? <a href="register.html">Reset</a></p> --}}
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </form>
    </div>
</body>



<style>
    /* General Reset */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  background: linear-gradient(to right, #00c6ff, #0072ff);
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

.form-container {
  background-color: white;
  padding: 2rem;
  border-radius: 12px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 400px;
}

.form-box h2 {
  text-align: center;
  margin-bottom: 1.5rem;
  color: #333;
}

.form-box input {
  width: 100%;
  padding: 12px;
  margin-bottom: 1rem;
  border: 1px solid #ddd;
  border-radius: 8px;
  font-size: 1rem;
}

.form-box button {
  width: 100%;
  padding: 12px;
  background-color: #0072ff;
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  cursor: pointer;
  transition: background 0.3s;
}

.form-box button:hover {
  background-color: #005dc1;
}

.switch-link {
  text-align: center;
  margin-top: 1rem;
  font-size: 0.9rem;
}

.switch-link a {
  color: #0072ff;
  text-decoration: none;
}

.switch-link a:hover {
  text-decoration: underline;
}
</style>
</html>
