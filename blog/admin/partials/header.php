<?php
require '../partials/header.php';

//fetch current user from database
if (!isset($_SESSION['user-id'])) {
    header('location:' . ROOT_URL . 'signin.php');
    die();
}
?>

