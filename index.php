<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="templates/js/script.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="templates/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <label class="navbar-brand" id="console-label">You are not logged in or registered!</label>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <button id="showRegistrationFormButton" class="btn btn-link nav-link">Registration</button>
            </li>
            <li class="nav-item">
                <button id="showLoginFormButton" class="btn btn-link nav-link">Login</button>
            </li>
        </ul>
    </div>
</nav>


<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <!-- Registration Form -->
            <div id="registrationForm" class="form-container mb-4" style="display: none;">
                <h2 class="text-center mb-4">Register</h2>
                <form method="post" id="reg-form">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Login" name="login" required>
                        <div class="alert alert-danger mt-2" role="alert" id="login-reg"></div>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Email" name="email" required>
                        <div class="alert alert-danger mt-2" role="alert" id="email-reg"></div>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                        <div class="alert alert-danger mt-2" role="alert" id="password-reg"></div>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Confirm Password" name="repeatPass" required>
                        <div class="alert alert-danger mt-2" role="alert" id="repeatPass-reg"></div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </form>
            </div>

            <!-- Authorization Form -->
            <div id="loginForm" class="form-container mb-4" style="display: none;">
                <h2 class="text-center mb-4">Login</h2>
                <form method="post" id="auth-form">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Login" name="login" required>
                        <div class="alert alert-danger mt-2" role="alert" id="login-auth"></div>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                        <div class="alert alert-danger mt-2" role="alert" id="pass-auth"></div>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
