<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 02/07/2018 18:34
 * Description:
 */

session_start();
require('autoload.php');
include('./template/header_jquery.html');

//Supprimer toutes les variables de $_SESSION sauf le message
foreach($_SESSION as $var_session=>$value)
{
    if ($var_session != 'message')
    {
        unset($_SESSION[$var_session]); //"effacer" la variable
    }
}

//1)MODEL : requête de selection des villes
$bdd = new Bdd();
$query =" SELECT * FROM ville";
$villes_non_formates = $bdd->select($query);


//2)VIEW: chargement du template
$page_ville_list = new VilleController('./template/ville_list_view.html');


//3)CONTROLLER
foreach($villes_non_formates as $ville)
{
    foreach($ville as $field=>$value)
    {
        if ($field=='id')
        {
            $villes[$value] = $ville;
        }
    }
}
$_SESSION['villes'] = $villes;

$lignes_villes = $page_ville_list->remplirLignesVille();
$page_ville_list->replaceBalise("#lignes_ville#", $lignes_villes);

$message = $page_ville_list->getMessage();
$page_ville_list->replaceBalise("#message#", $message);


//4) Affichage :
echo $page_ville_list->getHtml();