<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Projet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        body {
            background-color: #ffffff; /* white background */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .login-card {
            width: 360px;
            padding: 40px;
            border-radius: 12px;
            background: #f8f9fa;
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
        }
        .login-card h4 {
            font-weight: 700;
            margin-bottom: 30px;
        }
        .form-control:focus {
            border-color: #6c63ff;
            box-shadow: 0 0 8px rgba(108, 99, 255, 0.3);
        }
        .btn-gradient {
            background: linear-gradient(135deg, #6c63ff 0%, #00b4d8 100%);
            border: none;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
        }
        .form-text {
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>
<body>

<div class="login-card animate__animated animate__fadeIn">
    <h4 class="text-center">Login</h4>

    <form action="{{ route('login.post') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" required>
            <div class="form-text">Your credentials are safe with us.</div>
        </div>

        <button type="submit" class="btn btn-gradient w-100 mt-3">Login</button>
    </form>
</div>

</body>
</html>
