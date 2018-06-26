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
    //echo "id :".$_SESSION['id'];
}
echo "session:<br>";
var_dump($_SESSION);
echo "<br><br/>";

//1)MODEL : requête de selection des membres
if(isset($_SESSION['id']))
{
    $user = $bdd->queryMonoSelect('SELECT * FROM utilisateur WHERE id='.$_SESSION['id']);
    echo "recupération des données depuis la base";
    //var_dump($user);
}
//selection des etats
$etats  = $bdd->querySelect('SELECT * FROM etat');
//var_dump($etats);
//selection des etats
$statuts  = $bdd->querySelect('SELECT * FROM statut');
//var_dump($statuts);



//2)VIEW: chargement du template
$page_user = new User('./template/user_view.html');


//3)CONTROLLER remplacement des données
$page_user->setEtat($etats);
$page_user->setStatut($statuts);

if(isset($_SESSION['id']))
{
    $page_user->replaceBalise("#titre#","Modification d'un utilisateur");

    //TODO si le champs existe dans la session : mettre le champ en session, sinon la requête

    $page_user->replaceBalise("#value_pseudo#", $user['pseudo']);
    $page_user->replaceBalise("#value_mail#", $user['mail']);
    $page_user->replaceBalise("#value_mdp#", $user['mot_de_passe']);

    //$hidden = "";
    //$page_user->replaceBalise("#hidden#",$hidden);

}else{
    $page_user->replaceBalise("#titre#","Création d'un utilisateur");

    $page_user->replaceBalise("#value_pseudo#","");
    $page_user->replaceBalise("#value_mail#","");
    $page_user->replaceBalise("#value_mdp#","");
}
if(isset($_SESSION['message'])){
    $page_user->replaceBalise("#message#",$_SESSION['message']);
}else{
    $page_user->replaceBalise("#message#","");
}


//4) Affichage :
echo $page_user->getHtml();