<?php

declare(strict_types=1);

function get_username(object $pdo, string $username) {
    $query = "SELECT username FROM users WHERE username = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_email(object $pdo, string $email) {
    $query = "SELECT email FROM users WHERE email = :email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function set_user(object $pdo, string $username, string $pwd, string $email, string $roles) {
    $query = "INSERT INTO users (username, pwd, email, roles) VALUES (:username, :pwd, :email, :roles);";
    $stmt = $pdo->prepare($query);

    //Password hashing
    $options = ['cost' =>12];
    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);

    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":pwd", $hashedPwd);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":roles", $roles);
    $stmt->execute();
}

function set_subjects(object $pdo, string $subjects) {
    $query = "INSERT INTO users (subjects) VALUES (:subjects);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":subjects", $subjects);
    $stmt->execute();
}