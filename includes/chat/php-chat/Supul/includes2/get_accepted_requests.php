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

    // Fetch all accepted requests where the current user is either a requester or tutor
    $stmt = $conn->prepare("
        SELECT * FROM requests 
        WHERE (requester = :username OR tutor = :username) 
        AND status = 'accepted'
        GROUP BY grpid
    ");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($requests) > 0) {
        echo "<ul>";
        foreach ($requests as $request) {
            $requestId = htmlspecialchars($request['id']);
            $requester = htmlspecialchars($request['requester']);
            $tutor = htmlspecialchars($request['tutor']);
            $schedule = htmlspecialchars($request['schedule']); // Get schedule
            $role = ($username === $request['requester']) ? 'learner' : 'tutor'; // Determine role
            
            // Determine which user to display and their role
            if ($role == 'learner') {
                $displayName = $tutor;
                $displayRole = 'Tutor';
                $oppositeUser = $tutor;
            } else {
                $displayName = $requester;
                $displayRole = 'Requester';
                $oppositeUser = $requester;
            }

            // Format schedule for display or set default message
            $scheduleDisplay = $schedule ? date('Y-m-d H:i', strtotime($schedule)) : 'No schedule';
            $scheduleTimestamp = $schedule ? strtotime($schedule) * 1000 : null; // Convert to milliseconds for JavaScript

            // Determine if chat button should be initially hidden
            $chatButtonClass = $schedule ? 'hidden-chat' : '';

            echo "<li class='white-box request-item'>
                    <div class='request-info3'>
                        $displayName <span class='role'>($displayRole)</span>
                        <div class='schedule-info'>
                            $scheduleDisplay
                            <span class='countdown' data-schedule='$scheduleTimestamp'></span>
                        </div>
                    </div>
                    <form action='chatin.php' method='get'>
                        <input type='hidden' name='request_id' value='$requestId'>
                        <button type='submit' class='chat-button $chatButtonClass'>CHAT</button>
                    </form>
                </li>";
        }
        echo "</ul>";
    } else {
        echo "No accepted requests.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
