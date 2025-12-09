<?php

include_once('../../../security/config_session.inc.php');

$requester = $_SESSION['USER_INFO']['username'];
$data = json_decode(file_get_contents('php://input'), true);
$tutor = $data['tutor'];

try {
    include_once('../../../databases/dbh.inc.php');

    // Insert two rows with the same grpid
    $stmt = $pdo->prepare("INSERT INTO sessions (tutor, learner, status) VALUES (:tutor, :requester, 'pending')");
    $stmt->bindParam(':tutor', $tutor);
    $stmt->bindParam(':requester', $requester);
    $stmt->execute();
    echo "Request sent successfully.";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>