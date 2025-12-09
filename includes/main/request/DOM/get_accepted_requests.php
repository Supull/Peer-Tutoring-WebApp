<?php
require_once('../../../security/config_session.inc.php');
require_once('../../../databases/dbh.inc.php');

$username = $_SESSION['USER_INFO']['username'];

try {
    // Fetch all accepted requests where the current user is either a requester or tutor
    $stmt = $pdo->prepare("
    SELECT * 
    FROM sessions 
    WHERE status = 'accepted'
    AND
    (tutor = :username
    OR learner = :username)
    ");

    $stmt->bindParam(':username', $username); 
    $stmt->execute();

    $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($requests) > 0) {
        foreach ($requests as $request) {
            echo "<div class='individual-user-accepted'>";
            if ($request['tutor'] == $username) {
                $requestName = $request['learner'];
                echo "
                    <h3>$requestName</h3>
                    <p>.learner</p>
                    <button value=$requestName onclick='handleOpenModal(event)' data-modal-target='#modalChat'>CHAT</button>
                ";
            } else if($request['learner'] == $username){
                $requestName = $request['tutor'];
                echo "
                    <h3>$requestName</h3>
                    <p>.tutor</p>
                    <button value=$requestName onclick='handleOpenModal(event)' data-modal-target='#modalChat'>CHAT</button>
                ";
            };
            echo "</div>";
        }
    } else {
        echo "No accepted requests.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
