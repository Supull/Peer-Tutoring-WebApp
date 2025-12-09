<?php
session_start();
$host = 'localhost';
$dbname = 'tutorial';
$dbusername = 'root';
$dbpassword = '';

$data = json_decode(file_get_contents('php://input'), true);
$requestId = $data['requestId'];
$tutor = $_SESSION['username'];

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch request details, including the grpid
    $stmt = $conn->prepare("SELECT * FROM requests WHERE id = :requestId");
    $stmt->bindParam(':requestId', $requestId);
    $stmt->execute();
    $request = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($request) {
        $requester = $request['requester'];
        $grpid = $request['grpid'];  // Get the grpid of the request

        // Update request status to 'accepted' for all rows with the same grpid
        $stmt = $conn->prepare("UPDATE requests SET status = 'accepted' WHERE grpid = :grpid");
        $stmt->bindParam(':grpid', $grpid);
        $stmt->execute();

        echo json_encode(['success' => true, 'message' => 'Request accepted.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Request not found.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}

$conn = null;
?>
