<?php
include '../config/db.php';

$message = "";

if(isset($_POST['signup'])){
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);
    $hashed   = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users(username, email, password) VALUES('$username', '$email', '$hashed')";
    if(mysqli_query($conn, $sql)){
        $message = "success";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — libroCore</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="auth-page">

    <div class="auth-visual">
        <div class="auth-visual-pattern"></div>
        <div class="auth-visual-content">
            <span class="auth-logo">libro<span>Core</span></span>
            <span class="auth-tagline">Library Management System</span>
            <ul class="auth-feature-list">
                <li>Free to get started</li>
                <li>Full access to all features</li>
                <li>Manage unlimited books</li>
                <li>Secure password encryption</li>
            </ul>
        </div>
    </div>

    <div class="auth-form-side">
        <div class="auth-form-wrap">

            <h2>Create account</h2>
            <p class="auth-subtitle">Join libroCore to start managing your library</p>

            <?php if($message === "success"): ?>
                <div class="message">✓ Account created! <a href="login.php">Sign in now</a></div>
            <?php elseif($message != ""): ?>
                <div class="alert alert-error">⚠ <?php echo $message; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="input-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="yourname" required>
                </div>
                <div class="input-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="you@example.com" required>
                </div>
                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit" name="signup" class="btn">Create Account</button>
            </form>

            <p class="text-center" style="font-size:13px;color:var(--text-secondary);">
                Already have an account? <a href="login.php">Sign in</a>
            </p>

        </div>
    </div>

</div>

</body>
</html>
