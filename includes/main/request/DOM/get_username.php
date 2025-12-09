<?php

require_once('../../../security/config_session.inc.php');

header('Content-Type: application/json');

// Check if user is logged in
if (isset($_SESSION['USER_INFO']['username'])) {
    echo json_encode(['username' => $_SESSION['USER_INFO']['username']]);
} else {
    echo json_encode(['username' => null]);
}
?>
