<?php
session_start();
$host = 'localhost';
$dbname = 'tutorial';
$dbusername = 'root';
$dbpassword = '';

$loggedInUser = $_SESSION['username'];
$subjectFilter = isset($_GET['subject']) ? $_GET['subject'] : 'all';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT username, subjects, sessions FROM users WHERE is_online = 1 AND roles = 'tutor' AND username != :loggedInUser";
    
    if ($subjectFilter !== 'all') {
        $query .= " AND FIND_IN_SET(:subjectFilter, subjects) > 0";
    }

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':loggedInUser', $loggedInUser);

    if ($subjectFilter !== 'all') {
        $stmt->bindParam(':subjectFilter', $subjectFilter);
    }

    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($users) > 0) {
        echo "<ul>";
        foreach ($users as $user) {
            $subjects = htmlspecialchars($user['subjects']);
            $username = strtoupper(htmlspecialchars($user['username']));
            $sessions = intval($user['sessions']); // Convert sessions to integer for display
            echo "<li class='white-box'>
                    <div class='request-info'>$username ($sessions)</div>
                    <div class='request-info1' style='margin-left: 20px;'>$subjects</div>
                    <button class='request-button' data-tutor='$username'>REQUEST</button>
                </li>";
        }
        echo "</ul>";
    } else {
        echo "No tutors are online.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>