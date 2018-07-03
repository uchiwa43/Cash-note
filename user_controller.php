<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 24/06/2018 20:31
 * Description:
 *
 */

session_start();
require('autoload.php');


//1)MODEL :
$bdd = new Bdd();
//requête de selection des etats et des statuts pour alimenter les listes déroulantes
$etats = $bdd->select('SELECT * FROM etat WHERE id =1 OR ID =2');
$statuts = $bdd->select('SELECT * FROM statut');


//2)VIEW: chargement du template
$page_user = new UserController('./template/user_view.html');


//3)CONTROLLER
//remplacement des données
$message = $page_user->getMessage();
$page_user->replaceBalise("#message#",$message);

//Modification d'un utilisateur
if(isset($_GET['id']))
{
    $page_user->replaceBalise("#titre#","Modification d'un utilisateur");

    //récupération de l'utilisateur dans les données de session
    $id = $_GET['id'];
    $users = $_SESSION['users'];
    $user = $users[$id];

    $_SESSION['id'] = $_GET['id'];

    //champs text
    $page_user->setPseudoValue($user['pseudo']);
    $page_user->setMailValue($user['mail']);
    $page_user->setPasswordValue($user['mot_de_passe']);
    //champs select
    $page_user->setStatut($statuts, $user['statut']);
    $page_user->setEtat($etats,$user['etat']);

}else{
    $page_user->replaceBalise("#titre#","Création d'un utilisateur");

    //champs text
    $page_user->setPseudoValue("");
    $page_user->setMailValue("");
    $page_user->setPasswordValue("");
    //champs select
    $page_user->setStatut($statuts, null);
    $page_user->setEtat($etats,null);
}


//4) Affichage :
echo $page_user->getHtml();