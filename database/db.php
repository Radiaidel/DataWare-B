<?php
class database{
    private $dsn="mysql:host=localhost;dbname=dataware_db";
    private $username="root";
    private $password="";


    public function connexion() {
        try {
            $pdo = new PDO($this->dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            throw new Exception("Connexion échouée : " . $e->getMessage());
        }
    }
    
}
?>