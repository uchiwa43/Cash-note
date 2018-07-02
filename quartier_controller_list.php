<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 02/07/2018 20:21
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
$query =" SELECT q.id, q.libelle,q.id_ville, v.libelle AS ville
 FROM quartier q
 JOIN ville v ON id_ville = v.id
 ";
$quartiers_non_formates = $bdd->select($query);


//2)VIEW: chargement du template
$page_quartier_list = new QuartierController('./template/quartier_list_view.html');


//3)CONTROLLER
foreach($quartiers_non_formates as $quartier)
{
    foreach($quartier as $field=>$value)
    {
        if ($field=='id')
        {
            $quartiers[$value] = $quartier;
        }
    }
}
$_SESSION['quartiers'] = $quartiers;

$page_quartier_list->replaceBalise("#titre#", 'Liste des Quartiers');
$message = $page_quartier_list->getMessage();
$page_quartier_list->replaceBalise("#message#", $message);

$lignes_quartiers = $page_quartier_list->remplirLignesQuartiers();
$page_quartier_list->replaceBalise("#lignes_quartiers#", $lignes_quartiers);

//4) Affichage :
echo $page_quartier_list->getHtml();