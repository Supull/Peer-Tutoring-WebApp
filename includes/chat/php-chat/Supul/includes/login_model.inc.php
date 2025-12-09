<?php

declare(strict_types=1);

function is_input_empty2(string $username, string $pwd): bool {
    return empty($username) || empty($pwd);
}

function get_user(object $pdo, string $username) {
    $query = "SELECT id, username, pwd, roles FROM users WHERE username = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}


function is_user_valid2(object $pdo, string $username, string $pwd): bool {
    $user = get_user($pdo, $username);
    if ($user && password_verify($pwd, $user['pwd'])) {
        return true;
    }
    return false;
}
?>
