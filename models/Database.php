<?php

require_once __DIR__ . '/../helpers/flash.php';

class Database
{
    private static ?PDO $instance = null;

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {

            if (session_status() === PHP_SESSION_NONE) {
                session_set_cookie_params([
                    'lifetime' => 0,
                    'path'     => '/',
                    'secure'   => false,
                    'httponly' => true,
                    'samesite' => 'Lax'
                ]);
                session_start();
            }

            if (empty($_SESSION['csrf_token'])) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }

            $envPath = __DIR__ . '/../.env';
            if (file_exists($envPath)) {
                $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                foreach ($lines as $line) {
                    if (str_starts_with(trim($line), '#')) continue;
                    [$key, $value] = explode('=', $line, 2);
                    $_ENV[trim($key)] = trim($value);
                }
            }

            try {
                self::$instance = new PDO(
                    "mysql:host="   . ($_ENV['DB_HOST'] ?? '127.0.0.1')
                    . ";port="      . ($_ENV['DB_PORT'] ?? '3306')
                    . ";dbname="    . ($_ENV['DB_NAME'] ?? 'lesarchivesdugardien')
                    . ";charset=utf8",
                    $_ENV['DB_USER'] ?? 'root',
                    $_ENV['DB_PASS'] ?? '',
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            } catch (PDOException $e) {
                die("Une erreur est survenue. Veuillez réessayer plus tard.");
            }
        }

        return self::$instance;
    }
}
