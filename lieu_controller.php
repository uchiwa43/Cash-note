<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 02/07/2018 22:16
 * Description:
 */

session_start();
require('autoload.php');

//var_dump($_SESSION);

//1)MODEL :
$bdd = new Bdd();
//requête de selection des etats et des statuts pour alimenter les listes déroulantes
$villes = $bdd->select('SELECT * FROM ville');
$quartiers = $bdd->select('SELECT * FROM quartier');


//2)VIEW: chargement du template
$page_lieu = new LieuController('./template/lieu_view.html');



//3)CONTROLLER
//remplacement des données
$message = $page_lieu->getMessage();
$page_lieu->replaceBalise("#message#",$message);

//Modification d'un quartier
if(isset($_GET['id']))
{
    $page_lieu->replaceBalise("#titre#","Modification d'un lieu");

    $id = $_GET['id'];
    $lieux = $_SESSION['lieux'];
    $lieu = $lieux[$id];

    $_SESSION['id'] = $_GET['id'];

    //champs text
    $page_lieu->setLibelleValue($lieu['libelle']);
    //champs select
    $page_lieu->setVilles($villes, $lieu['id_ville']);
    $page_lieu->setQuartiers($quartiers,$lieu['id_quartier']);

}else{
    $page_lieu->replaceBalise("#titre#","Création d'un quartier");

    //champs text
    $page_lieu->setLibelleValue("");
    //champs select
    $page_lieu->setVilles($villes, null);
    $page_lieu->setQuartiers($quartiers,null);
}

//4) Affichage :
echo $page_lieu->getHtml();