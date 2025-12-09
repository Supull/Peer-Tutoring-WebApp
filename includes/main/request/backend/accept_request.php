<?php
require_once('../../../security/config_session.inc.php');
require_once('../../../databases/dbh.inc.php');

$data = json_decode(file_get_contents('php://input'), true);
$learner = $data['learner'];
$tutor = $_SESSION['USER_INFO']['username'];

try {

    // Fetch request details, including the grpid
    $stmt = $pdo->prepare("UPDATE sessions SET status = 'accepted' WHERE tutor = :tutor AND learner = :learner AND status = 'pending'");
    $stmt->bindParam(':tutor', $tutor);
    $stmt->bindParam(':learner', $learner);
    $stmt->execute();
    $session = $stmt->fetch(PDO::FETCH_ASSOC);
    echo 'Accepted request';
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
