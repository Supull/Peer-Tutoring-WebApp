<?php
require_once('../../../security/config_session.inc.php');

require_once('../../../databases/dbh.inc.php');


try {
    $query = "
        SELECT u.username
        FROM users u
        WHERE u.roles = 'tutor'
        AND NOT EXISTS (
            SELECT 1
            FROM sessions s
            WHERE s.tutor = u.username
            AND s.learner = :thisuser
        )
    ";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':thisuser', $_SESSION['USER_INFO']['username']);

    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($users) > 0) {
        foreach ($users as $user) {
            // $subjects = htmlspecialchars($user['subjects']);
            $username = htmlspecialchars($user['username']);
            echo "
                <div class='individual-user-request'>
                <h1 class='request-info'>$username</h1>
                <button class='request-button' value=$username onclick='{handleRequest(event)}'>REQUEST</button>
                </div>
                ";
        }

    } else {
        echo "<h1>No tutors are online.</h1>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>