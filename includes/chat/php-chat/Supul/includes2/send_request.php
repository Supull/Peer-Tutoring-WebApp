<?php
session_start();
$host = 'localhost';
$dbname = 'tutorial';
$dbusername = 'root';
$dbpassword = '';

$requester = $_SESSION['username'];
$data = json_decode(file_get_contents('php://input'), true);
$tutor = $data['tutor'];

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Generate a unique grpid
    $grpid = uniqid();

    // Check if there's already a pending or accepted request where the current user is the requester
    $stmt = $conn->prepare("
        SELECT * FROM requests 
        WHERE requester = :requester 
          AND tutor = :tutor 
          AND status IN ('pending', 'accepted')
    ");
    $stmt->bindParam(':requester', $requester);
    $stmt->bindParam(':tutor', $tutor);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        // Insert two rows with the same grpid
        $stmt = $conn->prepare("INSERT INTO requests (username, roles, status, grpid, requester, tutor) VALUES (:requester, 'learner', 'pending', :grpid, :requester, :tutor)");
        $stmt->bindParam(':requester', $requester);
        $stmt->bindParam(':tutor', $tutor);
        $stmt->bindParam(':grpid', $grpid);
        $stmt->execute();

        $stmt = $conn->prepare("INSERT INTO requests (username, roles, status, grpid, requester, tutor) VALUES (:tutor, 'tutor', 'pending', :grpid, :requester, :tutor)");
        $stmt->bindParam(':tutor', $tutor);
        $stmt->bindParam(':requester', $requester);
        $stmt->bindParam(':grpid', $grpid);
        $stmt->execute();

        echo "Request sent successfully.";
    } else {
        echo "You already have a pending or accepted request with this tutor.";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>