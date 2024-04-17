<?php
session_start();
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
    <?php if (isset($_SESSION['user'])) {
        echo '<label class="navbar-brand">' . 'Hello '. $_SESSION["user"]["login"] . '!' . '</label>';
    }
    else
        echo '<label class="navbar-brand">You are not logged in or registered!</label>';
    ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <?php if (isset($_SESSION['user'])) {
            echo '<ul class="navbar-nav ml-auto"><li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
        }
        else
            echo '<ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Registration</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                </ul>';
        ?>
    </div>
</nav>

</body>
</html>
