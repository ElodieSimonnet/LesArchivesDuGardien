<?php
try {
    $db = new PDO(
        "mysql:host=127.0.0.1;port=3306;dbname=lesarchivesdugardien;charset=utf8",
        "root",
        ""
    );
    // echo "Database connection successful!";
} catch (PDOException $e) {
    //echo "Connection failed: " . $e->getMessage();
}
?>