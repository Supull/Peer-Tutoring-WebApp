<?php

require_once '../security/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? '';
    $pwd = $_POST["pwd"] ?? '';
    $email = $_POST["email"] ?? '';
    $roles = $_POST["roles"] ?? '';

    try {
        require_once '../databases/dbh.inc.php';
        require_once 'signup_model.inc.php';
        require_once 'signup_contr.inc.php';

        $ERRORS = [];

        if (check_empty($username, $pwd, $email, $roles)) {$ERRORS["empty_fields"] = "Fill in all fields!";}
        if (email_validation($email)) {$ERRORS["invalid_email"] = "Invalid email entered!";}
        if (email_verification($pdo, $email)) {$ERRORS["email_user"] = "Email already registered!";}
        if (username_verification($pdo, $username)) {$ERRORS["username_taken"] = "Username already taken!";}
        

        if ($ERRORS) {
            $_SESSION["SIGNUP_VALIDATION_ERRORS"] = $ERRORS;
            header("Location: ../../signup.php");
            die();
        } else {
            // Call function to create the user and get the last inserted ID
            create_user($pdo, $username, $pwd, $email, $roles);
            $_SESSION['USER_INFO']['id'] = $pdo->lastInsertId();

            // Redirect based on the role selected
            if ($roles === 'tutor') {header("Location: ../../subjectform.php?signup=success");}
            else if ($roles === 'learner') {header("Location: ../../signin.php?signup=success");}

            //Cleanup Code
            $pdo = null;
            $stmt = null;
            die();
        }

        
        
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }

} else {
    header("Location: ../../signup.php");
    die();
}
?>
