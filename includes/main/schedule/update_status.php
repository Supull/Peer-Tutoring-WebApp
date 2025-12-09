<?php
session_start();
$host = 'localhost';
$dbname = 'tutorial';
$dbusername = 'root';
$dbpassword = '';

$username = $_SESSION['username'];
$status = $_POST['status'];
$is_online = ($status === 'online') ? 1 : 0;

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("UPDATE users SET is_online = :is_online WHERE username = :username");
    $stmt->bindParam(':is_online', $is_online);
    $stmt->bindParam(':username', $username);

    $stmt->execute();

    echo "Status updated successfully.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
