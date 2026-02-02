<?php
require_once __DIR__ . '/../../bootstrap/app.php';
$authController->login();
?>

<link rel="stylesheet" href="css/auth.css">

<main class="login-container">
    <form class="login" method="POST">
        <h2>Login !</h2>
        <label for="username">username</label>
        <input type="text" id="username" name="username" placeholder="Username" required>

        <label for="password">password</label>
        <input type="password" name="password" id="password" placeholder="Password" required>

        <button class="submit" type="submit" name="login">Submit</button>
    </form>
</main>