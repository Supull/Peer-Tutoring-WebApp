<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? '';
    $pwd = $_POST["pwd"] ?? '';
    $email = $_POST["email"] ?? '';
    $roles = $_POST["roles"] ?? '';

    try {
        require_once 'dbh.inc.php';
        require_once 'signup_model.inc.php';
        require_once 'signup_contr.inc.php';

        $errors = [];

        if (is_input_empty($username, $pwd, $email, $roles)) {
            $errors["empty"] = "Fill in all fields!";
        }

        if (is_email_invalid($email)) {
            $errors["invalid_email"] = "Invalid email used!";
        }
        if (is_username_taken($pdo, $username)) {
            $errors["username_taken"] = "Username already taken!";
        }
        if (is_email_registered($pdo, $email)) {
            $errors["email_used"] = "Email already registered!";
        }

        require_once 'config_session.inc.php';

        if ($errors) {
            $_SESSION["errors_signup"] = $errors;
            header("Location: ../signup.php");
            die();
        }

        // Call function to create the user and get the last inserted ID
        create_user($pdo, $username, $pwd, $email, $roles);

        session_start();
        $_SESSION['user_id'] = $pdo->lastInsertId();

        // Redirect based on the role selected
        if ($roles === 'tutor') {
            header("Location: ../subjectform.php?signup=success");
        } else if ($roles === 'learner') {
            header("Location: ../signin.php?signup=success");
        }

        $pdo = null;
        $stmt = null;

        die();
        
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }

} else {
    header("Location: ../signup.php");
    die();
}
?>
