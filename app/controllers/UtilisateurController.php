<?php
include(__DIR__ . "/../models/UtilisateurModel.php");
class UtilisateurController
{
    public function inscription()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['newname'];
            $email = $_POST['newEmail'];
            $password = $_POST['newPassword'];
            
            $utilisateurModel = new UtilisateurModel();

            $existingUser = $utilisateurModel->getUtilisateurParEmail($email);

            if (!$existingUser) {
                $result = $utilisateurModel->AddUser($nom, $email, $password);
                if ($result) {
                    $message = "Inscription réussie. Vous pouvez vous connecter.";
                } else {
                    $message = "Erreur lors de l'inscription. Veuillez réessayer.";
                }
            } else {
                $message = "Un utilisateur avec cet email existe déjà.";
            }
        }

        include_once(__DIR__ . "/../../index.php");
    }
    public function authentification(){
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email= $_POST["email"];
            $password=$_POST["password"];

            $utilisateurModel = new UtilisateurModel();

            $result=$utilisateurModel->login($email, $password);
            if($result){
                include_once(__DIR__ . "/../views/projet/index.php");
            }
            else{
                $message = $result;
                include_once(__DIR__ . "/../../index.php");

            }
        }

    }
}

?>
