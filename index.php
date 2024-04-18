<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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
                <form method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Login" name="login" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Email" name="email" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Confirm Password" name="confpass" required>
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

<script>
    $(document).ready(function () {
        // Functionality to show/hide registration form
        $("#showRegistrationFormButton").click(function(){
            $("#registrationForm").toggle();
            $("#loginForm").hide(); // Hide login form when showing registration form
        });

        // Functionality to show/hide login form
        $("#showLoginFormButton").click(function(){
            $("#loginForm").toggle();
            $("#registrationForm").hide(); // Hide registration form when showing login form
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#login-auth').hide()
        $('#pass-auth').hide()
        // Handle form submissions
        $('#auth-form').on("submit", function (event) {
            event.preventDefault(); // Prevent default form submission

            // Send POST request to backend.php
            $.post("./app/View/backend.php", $(this).serialize(), function (response) {
                // Process JSON response from php
                if (response.success) {
                    $('#auth-form')[0].reset();
                    $('#login-auth').hide()
                    $('#pass-auth').hide()
                    $('#loginForm').toggle();
                    $('#console-label').html('Login is success!')
                }
                else {
                    $('#auth-form')[0].reset();
                    if (!response.error.login) {
                        $('#login-auth').hide()
                    }
                    if (response.error.login) {
                        $('#login-auth').html(response.error.login).show();
                    }
                    if (!response.error.password){
                        $('#pass-auth').hide();
                    }
                    if (response.error.password){
                        $('#pass-auth').html(response.error.password).show();
                    }
                }
                }, 'json');
        });
    });
</script>
</body>
</html>
