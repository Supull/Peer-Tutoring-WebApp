<?php
    
    require_once('../includes/security/config_session.inc.php');
    require_once('../includes/databases/dbh.inc.php');

    $username = $_SESSION('username');
    
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email AND password = :pass');

    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);

    $stmt->execute();
    $_SESSION['user_id'] = $stmt->fetch(PDO::FETCH_ASSOC)['user_id']

?>