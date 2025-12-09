<?php
    header('Content-Type: application/json');
    session_start();
    require_once('../db/connDB.php');

    $sessionID = $_POST['sessionID'];

    
    $db = new connDB();
    $dbConn = $db->connect();

    $stmt = $dbConn->prepare('
        SELECT s.tutor_id
        FROM sessions s
        JOIN users u ON (s.student_id = u.user_id OR s.tutor_id = u.user_id)
        WHERE u.user_id = :user_id
        AND s.session_id = :session_id
    ');

    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);
    $stmt->bindParam(':session_id', $sessionID, PDO::PARAM_INT);

    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($user)

?>