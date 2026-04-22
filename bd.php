<?php

try {
    $pdo = new PDO('mysql:dbname=mariamomri_cfitech;host=localhost;charset=utf8mb4', "root", "");

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}
