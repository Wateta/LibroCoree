<?php
session_start();
include '../config/db.php';

$message = "";

if(isset($_POST['login'])){
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        if(password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: ../dashboard.php");
            exit();
        } else {
            $message = "Incorrect password. Please try again.";
        }
    } else {
        $message = "No account found with that email address.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — libroCore</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="auth-page">

    <!-- Visual Side -->
    <div class="auth-visual">
        <div class="auth-visual-pattern"></div>
        <div class="auth-visual-content">
            <span class="auth-logo">libro<span>Core</span></span>
            <span class="auth-tagline">Library Management System</span>
            <ul class="auth-feature-list">
                <li>Manage your entire book collection</li>
                <li>Track authors, categories & ISBNs</li>
                <li>Monitor inventory quantities</li>
                <li>Fast, intuitive interface</li>
            </ul>
        </div>
    </div>

    <!-- Form Side -->
    <div class="auth-form-side">
        <div class="auth-form-wrap">

            <h2>Welcome back</h2>
            <p class="auth-subtitle">Sign in to your libroCore account</p>

            <?php if($message != ""): ?>
                <div class="alert alert-error">⚠ <?php echo $message; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="input-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="you@example.com" required>
                </div>
                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit" name="login" class="btn">Sign In</button>
            </form>

            <p class="text-center" style="font-size:13px;color:var(--text-secondary);">
                Don't have an account? <a href="signup.php">Create one</a>
            </p>

        </div>
    </div>

</div>

</body>
</html>
