<?php
session_start();
require 'config/constants.php';

$username_email = $_SESSION['signin-data']['username_email'] ?? null;
$password = $_SESSION['signin-data']['password'] ?? null;

unset($_SESSION['signin-data']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Website</title>
    <!-- style -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style1.css">

    <!-- icon -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">

    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

</head>
<body>

<section class="form-section">
    <div class="container form-section-container">
        <h2>Sign In</h2>
        <?php if(isset($_SESSION['signup-success'])): ?>
        <div class="alert-message success">
            <p>
                <?= $_SESSION['signup-success'];
                unset($_SESSION['signup-success']); ?>
            </p>
        </div>
        <?php elseif(isset($_SESSION['signin'])): ?> 
        <div class="alert-message error">
            <p>
                <?= $_SESSION['signin'];
                unset($_SESSION['signin']);
                ?> 
            </p>
        </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>signin-logic.php" method="POST">
            <input type="text" name="username_email" value="<?= $username_email ?>" placeholder="Username or Email">
            <input type="password" name="password" value="<?= $password ?>" placeholder="Password">
            <button type="submit" name="submit" class="btn">Sign In</button>
            <small>Don't have account? <a href="signup.php">Sign Up</a></small>
        </form>
    </div>
</section>

<footer>
    <div class="footer-socials">
        <a href="https://youtube.com/alungturu" target="_blank"><i class="uil uil-youtube"></i></a>
        <a href="https://facebook.com/alungturu" target="_blank"><i class="uil uil-facebook-f"></i></a>
        <a href="https://instagram.com/alungturu" target="_blank"><i class="uil uil-instagram"></i></a>
        <a href="https://linkedin.com/alungturu" target="_blank"><i class="uil uil-linkedin"></i></a>
        <a href="https://twitter.com/alungturu" target="_blank"><i class="uil uil-twitter"></i></a>
    </div>
    <div class="container footer-container">
        <article>
            <h4>Categories</h4>
            <ul>
                <li><a href="">Art</a></li>
                <li><a href="">Wild Life</a></li>
                <li><a href="">Travel</a></li>
                <li><a href="">Music</a></li>
                <li><a href="">Science & Technology</a></li>
                <li><a href="">Food</a></li>
            </ul>
        </article>
        <article>
            <h4>Support</h4>
            <ul>
                <li><a href="">Online Support</a></li>
                <li><a href="">Call Numbers</a></li>
                <li><a href="">Emails</a></li>
                <li><a href="">Social Support</a></li>
                <li><a href="">Location</a></li>
            </ul>
        </article>
        <article>
            <h4>Blog</h4>
            <ul>
                <li><a href="">Safety</a></li>
                <li><a href="">Repair</a></li>
                <li><a href="">Recent</a></li>
                <li><a href="">Popular</a></li>
                <li><a href="">Categories</a></li>
            </ul>
        </article>
        <article>
            <h4>Permalinks</h4>
            <ul>
                <li><a href="">Home</a></li>
                <li><a href="">Blog</a></li>
                <li><a href="">About</a></li>
                <li><a href="">Services</a></li>
                <li><a href="">Contact</a></li>
            </ul>
        </article>
    </div>
    <div class="footer-copyright">
        <small>Copyright &copy; 2023 Arul Tempest</small>
    </div>
</footer>

<script src="main.js"></script>
</body>
</html>
