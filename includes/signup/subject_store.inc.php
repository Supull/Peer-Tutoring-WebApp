<?php

require_once '../security/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subjects = $_POST["subjects"] ?? [];

    try {
        require_once '../databases/dbh.inc.php';

        $user_id = $_SESSION['USER_INFO']['id'];

        $subjectsString = implode(',', $subjects);

        $query = "UPDATE users SET subjects = :subjects WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":subjects", $subjectsString);
        $stmt->bindParam(":id", $user_id);
        $stmt->execute();

        // Clear the session user_id after updating subjects
        unset($_SESSION['user_id']);

        header("Location: ../../index.php?subjects=success");

        //Cleanup code
        $pdo = null;
        $stmt = null;
        die();
        
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }

} else {
    header("Location: ../../signup.php");
    die();
}
?>
