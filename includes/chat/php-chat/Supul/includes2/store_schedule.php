<?php
session_start();
$host = 'localhost';
$dbname = 'tutorial';
$dbusername = 'root';
$dbpassword = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the POST data
    $requestId = $_POST['request_id'];
    $schedule = $_POST['schedule']; // This should be in the format 'YYYY-MM-DDTHH:MM'
    $requester = $_POST['requester'];
    $tutor = $_POST['tutor'];

    // Validate the input
    if (empty($requestId) || empty($schedule) || empty($requester) || empty($tutor)) {
        echo "Error: Missing request ID, schedule, requester, or tutor.";
        exit;
    }

    // Retrieve the grpid associated with the request
    $stmt = $conn->prepare("SELECT grpid FROM requests WHERE id = :request_id AND (username = :requester OR username = :tutor)");
    $stmt->bindParam(':request_id', $requestId);
    $stmt->bindParam(':requester', $requester);
    $stmt->bindParam(':tutor', $tutor);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $grpid = $result['grpid'];

        // Prepare the update statement
        $stmt = $conn->prepare("UPDATE requests SET schedule = :schedule WHERE grpid = :grpid AND (username = :requester OR username = :tutor)");
        $stmt->bindParam(':schedule', $schedule);
        $stmt->bindParam(':grpid', $grpid);
        $stmt->bindParam(':requester', $requester);
        $stmt->bindParam(':tutor', $tutor);

        // Execute the update statement for all rows with the same grpid
        if ($stmt->execute()) {
            echo "Schedule stored successfully.";
        } else {
            echo "Error: Could not store the schedule.";
        }
    } else {
        echo "Error: Request ID not found.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
