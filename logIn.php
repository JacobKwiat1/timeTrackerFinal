<?php
$pageTitle = "Login";
require_once('connect.php');
include('includes/header.php');
function LoginForm() {
    echo "<p>
    Login to start timer and logout to end it.
    <br>
            <form method='POST' action='login.php'>
                <label for='username'>username:</label>
                <input type='text' id = 'username' name = 'username' required>
                <br>
                <label for='password'>password:</label>
                <input type='text' id = 'password' name = 'password' required>
                <br>
                <input type='submit' value='submit'> 
            </form>
        </p>";
        include('includes/footer.php');
}
// Regex rules
$unameRegex = '/^[a-zA-Z0-9._-]{3,15}$/';
$passRegex = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,15}$/';
    if($_SERVER["REQUEST_METHOD"] === "POST")   {
        $username = $_POST["username"];
        $password = $_POST["password"];
            // Validate input
    if (!preg_match($unameRegex, $username)) {
        echo "<span class='error'>*Invalid username: must be 3-15 characters</span><br>";
        LoginForm();
        exit();
    }

    if (!preg_match($passRegex, $password)) {
        echo "<span class='error'>*Invalid password: 8–15 chars, 1 uppercase, 1 number</span><br>";
        LoginForm();
        exit();
    }

        $q = "SELECT * FROM user WHERE username='$username' AND password='$password'";
        $result = $connection->query($q);

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $ID = $row['ID'];
        if(!isset($_SESSION['admin']) || $_SESSION['admin'] != $row['admin']) {
            $_SESSION["admin"] = $row["admin"];
            echo "<script> window.location.reload();</script>";
        }
        if(!(isset($_SESSION[$ID."start"])) || $_SESSION[$ID."start"] == -1) {
        $_SESSION[$ID."start"] = time();
        $time = $_SESSION[$ID."start"];
        echo "<span class='error'>Your timer has been started </span>";
        }   else {
            $finish = floor((time() - $_SESSION[$ID."start"])/60);
            $_SESSION[$ID."start"] = -1;
            $q = "UPDATE user SET totalTime = totalTime + $finish WHERE ID = '$ID'"; 
            if($connection->query($q)) {
                echo "<span class='error'>Your session has been added to your total time. time for session: $finish minutes </span>";
            }
            else {
                echo "<span class='error'>Something went wrong</span>";
            }
        }
    } else {
        echo "<span class='error'>could not find user with associated username and password</span>";
    }
}
LoginForm();
?>