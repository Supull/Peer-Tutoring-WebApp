<?php

declare(strict_types=1);

function check_empty(string $username, string $pwd, string $email, string $roles) {
    if (empty($username) || empty($pwd) || empty($email) || empty($roles)) {return true;} 
    else {return false;}
}

function email_validation($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {return true;} 
    else {return false;}
}

function username_verification(object $pdo, string $username) {
    if (get_username($pdo, $username)) {return true;} 
    else {return false;}
}

function email_verification(object $pdo, string $email) {
    if (get_email($pdo, $email)) {return true;} 
    else {return false;}
}

function create_user(object $pdo, string $username, string $pwd, string $email, string $roles) {
    set_user($pdo, $username, $pwd, $email, $roles);
}

function create_subjects(object $pdo, string $subjects) {
    set_subjects($pdo, $subjects);
}

