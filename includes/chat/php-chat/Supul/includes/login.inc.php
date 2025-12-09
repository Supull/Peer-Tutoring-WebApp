<?php
session_start();
$host = 'localhost';
$dbname = 'tutorial';
$dbusername = 'root';
$dbpassword = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? '';
    $pwd = $_POST["pwd"] ?? '';

    try {
        require_once 'dbh.inc.php'; // Database connection file
        require_once 'login_model.inc.php'; // Functions for login validation
        
        $errors = [];

        if (is_input_empty2($username, $pwd)) {
            $errors["empty"] = "Fill in all fields!";
        }

        if (!is_user_valid2($pdo, $username, $pwd)) {
            $errors["invalid_credentials"] = "Incorrect username or password!";
        }

        if ($errors) {
            $_SESSION["errors_login"] = $errors;
            header("Location: ../signin.php");
            die();
        }

        $user = get_user($pdo, $username); // Fetch user details from database
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['roles'] = $user['roles']; // Store user role in session

        header("Location: ../ontutu.php?login=success");
        $pdo = null;
        $stmt = null;

        die();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }

} else {
    header("Location: ../signin.php");
    die();
}
?>
