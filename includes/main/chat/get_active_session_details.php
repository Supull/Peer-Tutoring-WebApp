<?php
require_once('../../security/config_session.inc.php');


$active_session = [
    'source' => $_SESSION['ACTIVE_SESSION']['source'],
    'recipient' => $_SESSION['ACTIVE_SESSION']['recipient']
];

header('Content-Type: application/json');
echo json_encode($active_session);
?>