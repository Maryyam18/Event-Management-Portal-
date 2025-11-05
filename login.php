<?php
session_start();
include 'db_connect.php';

// Variables & Data Types: Arrays
$errors = [];

// Functions: Code reusability
function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}

// Control Statements: Check form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = sanitizeInput($_POST['full_name']);
    $password  = $_POST['password'];

    if (empty($full_name) || empty($password)) {
        $errors[] = "Both fields required.";
    } else {
        $stmt = $conn->prepare("SELECT user_id, full_name, password, role_id FROM users WHERE full_name = ?");
        $stmt->execute([$full_name]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']   = $user['user_id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role_id']   = $user['role_id'];
            header("Location: user_dashboard.php");
            exit;
        } else {
            $errors[] = "Invalid credentials.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Event Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #101644 0%, #1a1f6a 50%, #0f162d 100%);
            min-height: 100vh;
            font-family: 'Georgia', serif;
            color: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
        }
        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23001644"><path d="M0 0L50 20C100 40 200 60 300 50C400 40 500 20 600 20C700 20 800 40 900 50L1000 60L1000 100L0 100Z" opacity="0.1"/></svg>') no-repeat bottom;
            z-index: -1;
        }
        .card {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 2.5rem;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            animation: fadeInUp 0.8s ease-out;
            max-width: 520px;
            width: 100%;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .form-input {
            background-color: #f9fafb;
            border: 1px solid #d1d5db;
            color: #1e40af;
            border-radius: 6px;
            padding: 0.875rem;
            width: 100%;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
        }
        .form-input:focus {
            border-color: #1e40af;
            box-shadow: 0 0 0 4px rgba(30, 64, 175, 0.15);
            transform: scale(1.02);
            outline: none;
        }
        .form-input::placeholder {
            color: #60a5fa;
        }
        .error, .success {
            padding: 0.75rem;
            border-radius: 6px;
            text-align: center;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
        }
        .error { background-color: #fef2f2; color: #dc2626; }
        .success { background-color: #d1fae5; color: #065f46; }
        .btn-primary {
            background-color: #1e40af;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            padding: 0.875rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-primary:hover {
            background-color: #1e3a8a;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
        }
        .icon { color: #1e40af; margin-right: 0.5rem; }
        h2 { color: #1e40af; font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem; }
        .text-gray-300 { color: #60a5fa; font-size: 0.875rem; }
        a { color: #1e40af; font-weight: 500; }
        a:hover { color: #1e3a8a; text-decoration: underline; }
        @media (max-width: 640px) {
            .card { padding: 1.5rem; margin: 1rem; max-width: 90%; }
            h2 { font-size: 1.25rem; }
            .form-input { padding: 0.75rem; }
            .btn-primary { padding: 0.75rem; }
        }
        /* Updated label color to dark blue */
        label {
            color: #1e40af; /* Dark blue for better contrast */
        }
    </style>
</head>
<body>
    <div class="hero-bg"></div>
    <div class="card">
        <div class="text-center mb-6">
            <i class="fas fa-calendar-check text-5xl text-blue-800 mb-4"></i>
            <h2>Welcome Back</h2>
            <p class="text-gray-300">Sign in to your Event Management Portal</p>
        </div>

        <?php if (isset($_SESSION['msg'])): ?>
            <div class="success"><?= $_SESSION['msg']; unset($_SESSION['msg']); ?></div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="error"><?= implode('<br>', $errors) ?></div>
        <?php endif; ?>

        <form method="POST" class="space-y-5">
            <div>
                <label class="block font-medium flex items-center"><i class="fas fa-user icon"></i> Full Name</label>
                <input type="text" name="full_name" class="form-input" placeholder="Enter your full name" required>
            </div>
            <div>
                <label class="block font-medium flex items-center"><i class="fas fa-lock icon"></i> Password</label>
                <input type="password" name="password" class="form-input" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn-primary"><i class="fas fa-sign-in-alt mr-2"></i>Login</button>
        </form>
        <p class="text-center mt-4 text-gray-300">New user? <a href="signup.php">Create Account</a></p>
    </div>
</body>
</html>