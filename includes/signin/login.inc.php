<?php
require_once '../security/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? '';
    $pwd = $_POST["pwd"] ?? '';

    try {
        require_once '../databases/dbh.inc.php'; // Database connection file
        require_once 'login_model.inc.php'; // Functions for login validation
        
        $ERRORS = [];

        // Validation procedure
        if (input_validation($username, $pwd)) {$ERRORS["empty_fields"] = "Fill in all fields!";}
        if (!credential_verification($pdo, $username, $pwd)) {$ERRORS["invalid_credentials"] = "Incorrect username or password!";}

        //Handling validation errors
        if ($ERRORS) {
            $_SESSION["SIGNIN_VALIDATION_ERRORS"] = $ERRORS;
            header("Location: ../signin.php");
            die();
        } else {
            $user = get_user($pdo, $username); // Fetch user details from database
            session_start();

            //Set user data in server side SESSION
            $userInfo = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['roles']
            ];
            $_SESSION['USER_INFO'] = $userInfo;

            //Forward to page

            header("Location: ../../ontutu.php?login=success");

            // Cleanup code
            $pdo = null;
            $stmt = null;
            die();
        }

    } catch (PDOException $e) {die("Query failed: " . $e->getMessage());}

} else {
    //Handle error rilating to POST
    header("Location: ../signin.php");
    die();
}
?>
