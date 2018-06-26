<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 24/06/2018 20:31
 * Description:
 */

session_start();
include_once ('class/User.php');

// récupérer l'id de l'url et le mettre en session
if(isset($_GET['id']))
{
    $_SESSION['id'] = $_GET['id'];
}
echo "session:<br>"; var_dump($_SESSION); echo "<br><br/>";



//1)MODEL : requête de selection des membres
$etats  = $bdd->querySelect('SELECT * FROM etat');
$statuts  = $bdd->querySelect('SELECT * FROM statut');

if(isset($_SESSION['id']))
{
    $user = $bdd->queryMonoSelect('SELECT * FROM utilisateur WHERE id='.$_SESSION['id']);
}



//2)VIEW: chargement du template
$page_user = new User('./template/user_view.html');



//3)CONTROLLER remplacement des données
if(isset($_SESSION['id']))
{
    $page_user->replaceBalise("#titre#","Modification d'un utilisateur");

    //champs text
    $page_user->setPseudoValue($user['pseudo']);
    $page_user->setMailValue($user['mail']);
    $page_user->setPasswordValue($user['mot_de_passe']);
    //champs select
    $page_user->setStatut($statuts, $user['id_statut']);
    $page_user->setEtat($etats,$user['id_etat']);

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
if(isset($_SESSION['message'])){
    $page_user->replaceBalise("#message#",$_SESSION['message']);
}else{
    $page_user->replaceBalise("#message#","");
}



//4) Affichage :
echo $page_user->getHtml();