<?php

if (isset($_SESSION['user_id'])) {
    include __DIR__ . '/layout/indexA.php';
} else {
    include __DIR__ . '/auth/login.php';
}