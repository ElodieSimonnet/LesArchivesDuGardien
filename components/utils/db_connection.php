<?php
try {
    $db = new PDO(
        "mysql:host=127.0.0.1;port=3306;dbname=lesarchivesdugardien;charset=utf8",
        "root",
        "",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION] // Pour voir les erreurs SQL
    );
    // echo "Database connection successful!";
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
    //echo "Connection failed: " . $e->getMessage();
}
?>