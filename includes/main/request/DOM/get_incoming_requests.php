<?php
require_once('../../../security/config_session.inc.php');
require_once('../../../databases/dbh.inc.php');

$username = $_SESSION['USER_INFO']['username'];

try {

    //go to sesssions and get pending request learner then tutor

    // Fetch all pending requests where the current user is either a requester or tutor
    $stmt = $pdo->prepare("
    SELECT * 
    FROM sessions 
    WHERE status = 'pending'
    AND
    (tutor = :username
    OR learner = :username)
    ");

    $stmt->bindParam(':username', $username); 
    $stmt->execute();

    $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($requests) > 0) {
        foreach ($requests as $request) {
            echo "<div class='individual-user-pending'>";
            if ($request['tutor'] == $username) {
                $requestName = $request['learner'];
                echo "
                    <h3 class='pending-info'>$requestName</h3>
                    <div>
                    <button class='accept-pending' value=$requestName onclick='handleAcceptRequest(event)'>&#10004;</button>
                    <button class='cancel-pending'>&#10006;</button>
                    </div>
                ";
            } else if($request['learner'] == $username){
                $requestName = $request['tutor'];
                echo "
                    <h3 class='pending-info'>$requestName</h3>
                    <button class='load-pending'>...</button>
                ";
            };
            echo "</div>";
        }
        
    } else {
        echo "No ongoing requests.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
