<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 02/07/2018 21:56
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
$query =" SELECT l.id, l.libelle, l.id_ville, v.libelle AS ville, l.id_quartier, q.libelle AS quartier
FROM lieu l
LEFT JOIN ville v ON l.id_ville = v.id
LEFT JOIN quartier q ON l.id_quartier = q.id
 ";

$lieux_non_formates = $bdd->select($query);


//2)VIEW: chargement du template
$page_lieu_list = new LieuController('./template/lieu_list_view.html');



//3)CONTROLLER
foreach($lieux_non_formates as $lieu)
{
    foreach($lieu as $field=>$value)
    {
        if ($field=='id')
        {
            $lieux[$value] = $lieu;
        }
    }
}
$_SESSION['lieux'] = $lieux;

$lignes_lieux = $page_lieu_list->remplirLignesLieux();
$page_lieu_list->replaceBalise("#lignes_lieux#", $lignes_lieux);


$page_lieu_list->replaceBalise("#titre#", 'Liste des lieux');
$message = $page_lieu_list->getMessage();
$page_lieu_list->replaceBalise("#message#", $message);


//4) Affichage :
echo $page_lieu_list->getHtml();
