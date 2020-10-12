<?php
$hrefIndex = '../index.php';
//DÉMARRAGE SESSION
session_start();
// ON DÉTRUIT LA SESSION
session_destroy();
// REDIRECTION VERS LA PAGE INDEX
header("Location: $hrefIndex");
?>