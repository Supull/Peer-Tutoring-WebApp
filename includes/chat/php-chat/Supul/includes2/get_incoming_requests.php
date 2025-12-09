<?php
session_start();
$host = 'localhost';
$dbname = 'tutorial';
$dbusername = 'root';
$dbpassword = '';

$username = $_SESSION['username'];

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all pending requests where the current user is either a requester or tutor
    $stmt = $conn->prepare("SELECT * FROM requests WHERE username = :username AND status = 'pending'");
    $stmt->bindParam(':username', $username);
    
    $stmt->execute();

    $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($requests) > 0) {
        echo "<ul>";
        foreach ($requests as $request) {
            $requestId = htmlspecialchars($request['id']);
            $role = htmlspecialchars($request['roles']); // Fetch role from the request
            $requester = htmlspecialchars($request['requester']); // The requester (learner)
            $tutor = htmlspecialchars($request['tutor']); // The tutor
            $oppositeUser = htmlspecialchars($request['username']); // The opposite user (tutor or learner)

            echo "<li class='white-box request-item'>
                    <div class='request-info2'>";
            if ($role == 'learner') {
                // Display the opposite user (tutor) with "Ongoing" for the learner
                echo "$tutor - Ongoing";
                echo "</div>
                    <button class='cancel-button' data-request-id='$requestId' data-tutor='$oppositeUser'>CANCEL</button>";
            } else {
                // Display the opposite user (requester) with accept and cancel buttons for the tutor
                echo "$requester";
                echo "</div>
                    <button class='accept-button' data-request-id='$requestId'>ACCEPT</button>
                    <button class='schedule-button' data-request-id='$requestId' data-requester='$requester' data-tutor='$tutor'>SCHEDULE</button>
                    <button class='cancel-button' data-request-id='$requestId' data-requester='$oppositeUser'>CANCEL</button>";
            }
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "No ongoing requests.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
