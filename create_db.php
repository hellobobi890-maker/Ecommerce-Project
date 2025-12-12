<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS laravel_ecommerce");
    echo "Database 'laravel_ecommerce' created successfully.\n";
} catch (PDOException $e) {
    die("DB Error: " . $e->getMessage() . "\n");
}
