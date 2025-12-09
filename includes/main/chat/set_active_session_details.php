<?php
require_once('../../security/config_session.inc.php');
require_once('../../databases/dbh.inc.php');

$username = $_SESSION['USER_INFO']['username'];

$data = json_decode(file_get_contents('php://input'), true);
$recipient = $data['recipient'];

try {
    $_SESSION['ACTIVE_SESSION']['source'] = $username;
    $_SESSION['ACTIVE_SESSION']['recipient'] = $recipient;

    
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>
