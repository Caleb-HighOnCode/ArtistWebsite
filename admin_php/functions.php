<?php
function redirectTo($location) {
    header("Location: $location");
    exit();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        redirectTo('./admin_php/login.php');
    }
}
?>
