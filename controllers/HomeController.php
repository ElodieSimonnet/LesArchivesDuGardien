<?php

class HomeController
{

    public function home(): void
    {
        Database::getConnection(); 
        require __DIR__ . '/../views/index.php';
    }
}
