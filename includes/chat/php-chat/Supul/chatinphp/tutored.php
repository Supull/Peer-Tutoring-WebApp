
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

    // Select the request details from the requests table where status is accepted
    $stmt = $conn->prepare("SELECT tutor, requester, grpid FROM requests WHERE (tutor = :username OR requester = :username) AND status = 'accepted'");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $_SESSION['tutor'] = $result['tutor'];
        $_SESSION['requester'] = $result['requester'];
        $grpid = $result['grpid'];

        $conn->beginTransaction();

        // Delete all requests with the same grpid (related to the session)
        $stmt = $conn->prepare("DELETE FROM requests WHERE grpid = :grpid");
        $stmt->bindParam(':grpid', $grpid);
        $stmt->execute();

        $stmt = $conn->prepare("UPDATE users SET sessions = sessions + 1 WHERE username = :tutor");
        $stmt->bindParam(':tutor', $_SESSION['tutor']);
        $stmt->execute();

        $conn->commit();

        header("Location: ../ontutu.php");
        exit();
    } else {
        header("Location: ../ontutu.php?error=no_active_session");
        exit();
    }

} catch (PDOException $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    header("Location: ../ontutu.php?error=database_error");
    exit();
}

$conn = null;
?>

