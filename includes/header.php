<?php session_start() ?>
<!doctype html>
<html>
<head>
    <title><?php echo isset( $pageTitle ) ? $pageTitle : "timer" ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul class="nav-links">
                <li><a href="landing.php"><h1>HOME
                </h1></a></li>
                <li><a href="login.php"><h1>LOGIN</h1></a></li>
                <li><a href="signup.php"><h1>SIGNUP</h1></a></li>
                <?php if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                echo "<li><a href='admin.php'><h1>admin</h1></a></li>";
                }
                ?>
            </ul>
        </nav>
    </header>