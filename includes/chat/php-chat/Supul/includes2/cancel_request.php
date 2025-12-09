<?php
session_start();
$host = 'localhost';
$dbname = 'tutorial';
$dbusername = 'root';
$dbpassword = '';

$data = json_decode(file_get_contents('php://input'), true);
$requestId = $data['requestId'];
$requester = $data['requester'];
$tutor = $data['tutor'];

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Step 1: Find the grpid associated with the requestId
    $stmt = $conn->prepare("SELECT grpid FROM requests WHERE id = :requestId AND (username = :requester OR username = :tutor)");
    $stmt->bindParam(':requestId', $requestId);
    $stmt->bindParam(':requester', $requester);
    $stmt->bindParam(':tutor', $tutor);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $grpid = $result['grpid'];

        // Step 2: Delete both rows with the same grpid
        $stmt = $conn->prepare("DELETE FROM requests WHERE grpid = :grpid");
        $stmt->bindParam(':grpid', $grpid);
        $stmt->execute();

        echo json_encode(['success' => true, 'message' => 'Request canceled successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Request not found.']);
    }

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}

$conn = null;
?>
