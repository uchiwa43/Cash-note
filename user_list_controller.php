<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 24/06/2018 23:33
 * Description:
 */

session_start();
include_once ('class/UserList.php');

//Supprimer toutes les variables de $_SESSION sauf le message
foreach($_SESSION as $var_session=>$value)
{
    //var_dump($var_session);
    if ($var_session != 'message')
    {
        //echo "effacer";
        unset($_SESSION[$var_session]);
    }
}


//1)MODEL : requête de selection des membres
$query ="
SELECT u.id, pseudo, mail, mot_de_passe, s.libelle as statut, e.libelle as etat
FROM utilisateur u
JOIN etat e ON u.id_etat = e.id
JOIN statut s ON u.id_statut = s.id
";
$users = $bdd->select($query);


//2)VIEW: chargement du template
$page_user_list = new UserList('./template/user_list_view.html');


//3)CONTROLLER remplacement des données
$message = $page_user_list->getMessage();
$lignes_utilisateurs = $page_user_list->remplirLignesUtilisateurs($users);

$page_user_list->replaceBalise("#message#", $message);
$page_user_list->replaceBalise("#lignes_utilisateurs#", $lignes_utilisateurs);


//4) Affichage :
echo $page_user_list->getHtml();