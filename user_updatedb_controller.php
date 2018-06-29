<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 26/06/2018 18:31
 * Description: Fait un INSERT ou un UPDDATE dans la base de données
 */

session_start();
require('autoload.php');

//1)MODEL
$bdd = new Bdd();
//si on créé un utilisateur, il aura pour id : l'id maximum des utilisateurs auquel on ajoute 1
if (!isset($_SESSION['id']))
{
    $max_id = $bdd->selectMaxId("utilisateur");
    $id = $max_id+1;
}


//2)VIEW: aucune


//3)CONTROLLER
$user_edit = new UserController();
echo "Session:";var_dump($_SESSION);

$pseudo = $_SESSION['pseudo'];
$password = $_SESSION['password'];
$mail = $_SESSION['mail'];
$id_etat = $_SESSION['etat'];
$id_statut = $_SESSION['statut'];


if (isset($_SESSION['id']))
{
    //Modification d'utilisateur
    $result = $user_edit->updateUser($bdd);
    var_dump($result);
    if ($result ==1 ) {
        $_SESSION['message'] = "modification de l'utilisateur $pseudo effectuée";
    }

}else{
    //Création d'utilisateur

    //exécuter la requête INSERT
    $result = $user_edit->insertUser($bdd, $id);

    if ($result ==1 ) {
        $_SESSION['message'] = "création de l'utilisateur $pseudo effectuée";
    }
}

echo "resultat : ";  var_dump($_SESSION['message']);
//header('Location: user_list_controller.php');
echo "<script type='text/javascript'>document.location.replace('user_list_controller.php');</script>";
