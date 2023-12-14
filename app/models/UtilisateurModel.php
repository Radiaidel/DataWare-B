<?php
include_once(__DIR__ . "/../../database/db.php");
class UtilisateurModel
{
    private $conn;

    public function __construct()
    {
        $db = new database();
        $this->conn = $db->connexion();
        if (!$this->conn) {
            die("La connexion à la base de données a échoué.");
        }
    }

    public function AddUser($nom, $email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);


        $sql = "INSERT INTO users (username, email, pass_word, status, role) VALUES (:name, :email, :password, 'active', 'user')";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":name", $nom);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashedPassword);

        try {
            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Échec de l'exécution de la requête.");
            }
        }catch (Exception $e) {
            throw new Exception("Erreur d'insertion : " . $e->getMessage());
        }
        
    }

    public function getUtilisateurParEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":email", $email);

        try {
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }
    
    public function login($email, $password)
    {
        
        $User = $this->getUtilisateurParEmail($email);

        if ($User) {
            if (password_verify($password, $User['pass_word'])) {
                session_start();
                $_SESSION['iduser'] = $User['id'];
                $_SESSION['roleUser'] = $User['role'];

                return true;
            } else {
                return "Mot de passe incorrect.";
            }
        } else {
            return "Aucun utilisateur avec ces coordonnées";
        }
    }
}
?>