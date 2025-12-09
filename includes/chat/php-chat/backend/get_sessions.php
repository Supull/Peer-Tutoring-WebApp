<?php

header('Content-Type: application/json');
session_start();
require_once('../db/connDB.php');


$db = new connDB();
$dbConn = $db->connect();

$stmt = $dbConn->prepare('
    SELECT 
        CASE
            WHEN u.is_tutor = TRUE THEN s.student_id
            ELSE s.tutor_id
        END AS user_id,
        s.session_id
    FROM users u
    JOIN sessions s
        ON (u.is_tutor = TRUE AND s.tutor_id = u.user_id AND u.user_id = :user_id)
        OR (u.is_tutor = FALSE AND s.student_id = u.user_id AND u.user_id = :user_id);
');

$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);
$stmt->execute();

$data = array();

$sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($sessions) {
    foreach ($sessions as $session) {
        $stmt = $dbConn->prepare('
        SELECT name, user_id
        FROM users
        WHERE user_id = :user_id
        ');
        $session = array_values($session);
        $stmt->bindParam(':user_id', $session[0]);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $data[] = array(
            'sessionID' => $session[1],
            'recipient' => $user['name']
        );

        
    }
    echo json_encode($data);
} else {
    echo json_encode(array());
}
?>
