<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 24/06/2018 23:33
 * Description:
 *
 */

session_start();
require('./autoload.php');
include_once ('template/header_jquery.html');


//Supprimer toutes les variables de $_SESSION sauf le message
foreach($_SESSION as $var_session=>$value)
{
    if ($var_session != 'message')
    {
        unset($_SESSION[$var_session]); //"effacer" la variable
    }
}


//1)MODEL : requête de selection des membres
$bdd = new Bdd();
$query ="
SELECT u.id, pseudo, mail, mot_de_passe, s.libelle as statut, e.libelle as etat
FROM utilisateur u
JOIN etat e ON u.id_etat = e.id
JOIN statut s ON u.id_statut = s.id
";
$users_non_formates = $bdd->select($query);


//2)VIEW: chargement du template
$page_user_list = new UserController('./template/user_list_view.html');


//3)CONTROLLER
//mettre l'id utilisateur comme clé dans un nouvel array $users (ex : l'utilisateur avec l'id 5 sera $users[5] etc)
$users=[];
foreach($users_non_formates as $user)
{
    foreach($user as $field=>$value)
    {
        if ($field=='id')
        {
            $users[$value] = $user;
        }
    }
}
$_SESSION['users'] = $users;

//var_dump($_SESSION);

//remplacement des données
$lignes_utilisateurs = $page_user_list->remplirLignesUtilisateurs($users);
$page_user_list->replaceBalise("#lignes_utilisateurs#", $lignes_utilisateurs);

$message = $page_user_list->getMessage();
$page_user_list->replaceBalise("#message#", $message);


//4) Affichage :
echo $page_user_list->getHtml();