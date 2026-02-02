<?php
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Hachage du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {

        $stmt = $db->prepare("INSERT INTO adg_users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword]);
        echo "success";
    } catch (PDOException $e) {
        // En cas de doublon (pseudo ou email déjà pris)
        echo "Cet aventurier (ou cet email) existe déjà.";
    }
}