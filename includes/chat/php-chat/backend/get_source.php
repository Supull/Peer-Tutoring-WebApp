<?php
    header('Content-Type: application/json');
    session_start();
    require_once('../db/connDB.php');

    $db = new connDB();
    $dbConn = $db->connect();

    $stmt = $dbConn->prepare('SELECT conn_id FROM users WHERE user_id = :user_id');

    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($user)

?>