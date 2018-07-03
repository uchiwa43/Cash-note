<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 03/07/2018 20:42
 * Description:
 */

session_start();
require('autoload.php');
//var_dump($_SESSION['sites'][1]);


//1)MODEL :
$bdd = new Bdd();
//requête de selection des etats et des statuts pour alimenter les listes déroulantes
$etats = $bdd->select('SELECT * FROM etat WHERE id =1 OR id=2');



//2)VIEW: chargement du template
$page_site = new SiteController('./template/site_view.html');



//3)CONTROLLER
//remplacement des données
$message = $page_site->getMessage();
$page_site->replaceBalise("#message#",$message);


if(isset($_GET['id']))
{
    $page_site->replaceBalise("#titre#","Modification d'un site");

    $id = $_GET['id'];
    $sites = $_SESSION['sites'];
    $site = $sites[$id];

    $_SESSION['id'] = $_GET['id'];

    //champs text
    $page_site->setLibelleValue($site['libelle']);
    $page_site->setAdresseValue($site['url']);
    //champs select
    $page_site->setEtat($etats,$site['id_etat']);

}else{
    $page_site->replaceBalise("#titre#","Création d'un site");

    //champs text
    $page_site->setLibelleValue("");
    $page_site->setAdresseValue("");
    //champs select
    $page_site->setEtat($etats,null);

}


//4) Affichage :
echo $page_site->getHtml();