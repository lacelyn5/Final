<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'classes/User.php';
$user = new User();
$errorMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    if (!empty($username) && !empty($password)) {
        $user_id = $user->login($username, $password);
        if ($user_id !== false) {
            $_SESSION['user_id'] = $user_id;
            header('Location: index.php');
            exit; 
        } else {
            $errorMessage = "Login failed. Wrong username or password.";
        }
    } else {
        $errorMessage = "Both fields are required!";
    }
}
?>
<html>
<head>
    <title>Event Management System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">Event Management</a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <?php if (isset($_SESSION['user_id'])) : // Check if user is logged in ?>
                <li class="nav-item">
                    <a class="nav-link" href="events.php">Manage Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            <?php else : ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
<div class="container">
    <h2>Login</h2>
    <?php if ($errorMessage) : ?>
        <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
    <?php endif; ?>
    <form method="post" action="login.php">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>
</div>
<style>
    .footer {
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        background-color: #343a40;
        color: #fff;
        text-align: center;
        padding: 10px 0;
    }
</style>
<div class="footer">
    <p> Developed by Maksim Kernazhytski - 46589.</p>
</div>
</body>
</html>
