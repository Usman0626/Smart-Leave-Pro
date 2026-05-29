<?php
session_start();

function requireEmployee() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'employee') {
        header("Location: /smartleavepro/index.php");
        exit();
    }
}

function requireManager() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'manager') {
        header("Location: /smartleavepro/index.php");
        exit();
    }
}

function requireAdmin() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
        header("Location: /smartleavepro/index.php");
        exit();
    }
}
?>
