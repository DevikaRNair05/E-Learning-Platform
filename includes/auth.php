<?php
// Authentication and role check
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit();
}
// Only allow one role per email (enforced in registration/login logic)
