<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../templates/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <label class="navbar-brand">You are not logged in or registered!</label>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="register.php">Registration</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="login.php">Login</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <!-- Authorization Form -->
            <div id="loginForm" class="form-container mb-4"">
                <h2 class="text-center mb-4">Login</h2>
                <form action="auth.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Login" name="login" required>
                        <?php if (isset($_SESSION['Login incorrect'])): ?>
                            <div class="alert alert-danger mt-2" role="alert">
                                <?php echo $_SESSION['Login incorrect']; ?>
                            </div>
                            <?php unset($_SESSION['Login incorrect']); ?>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                        <?php if (isset($_SESSION['Password incorrect'])): ?>
                            <div class="alert alert-danger mt-2" role="alert">
                                <?php echo $_SESSION['Password incorrect']; ?>
                            </div>
                            <?php unset($_SESSION['Password incorrect']); ?>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>