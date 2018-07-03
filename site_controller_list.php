<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 03/07/2018 20:15
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
$query =" SELECT s.id, s.libelle, s.url, s.id_etat, etat.libelle AS etat
FROM site_internet s
LEFT JOIN etat ON s.id_etat = etat.id
 ";

$sites_non_formates = $bdd->select($query);



//2)VIEW: chargement du template
$page_site_list = new SiteController('./template/site_list_view.html');


//3)CONTROLLER
$sites=[];
foreach($sites_non_formates as $site)
{
    foreach($site as $field=>$value)
    {
        if ($field=='id')
        {
            $sites[$value] = $site;
        }
    }
}
//array formaté
$_SESSION['sites'] = $sites;


$lignes_sites = $page_site_list->remplirLignesSites();
$page_site_list->replaceBalise("#lignes_sites#", $lignes_sites);

$page_site_list->replaceBalise("#titre#", 'Liste des sites');
$message = $page_site_list->getMessage();
$page_site_list->replaceBalise("#message#", $message);


//4) Affichage :
echo $page_site_list->getHtml();
