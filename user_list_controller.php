<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 24/06/2018 23:33
 * Description:
 */

include_once ('class/UserList.php');

//1)MODEL : requête de selection des membres
$bdd = new Bdd();
$query ="
SELECT u.id, pseudo, mail, mot_de_passe, s.libelle as statut, e.libelle as etat
FROM utilisateur u
JOIN etat e ON u.id_etat = e.id
JOIN statut s ON u.id_statut = s.id
";
$users = $bdd->querySelect($query);
var_dump($users);


//2)VIEW: chargement du template
$liste_utilisateur = new UserList('./template/user_list_view.html');


//3)CONTROLLER remplacement des données
//$_SESSION['message']='je suis un message';
$message = $liste_utilisateur->getMessage();

$lignes_utilisateurs = $liste_utilisateur->remplirLignesUtilisateurs($users);

$liste_utilisateur->replaceBalise("#message#", $message);

$liste_utilisateur->replaceBalise("#lignes_utilisateurs#", $lignes_utilisateurs);


//4) Affichage :
echo $liste_utilisateur->getHtml();