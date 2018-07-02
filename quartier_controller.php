<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 02/07/2018 20:40
 * Description:
 */

session_start();
require('autoload.php');

//var_dump($_SESSION);

//1)MODEL :
$bdd = new Bdd();
//requête de selection des etats et des statuts pour alimenter les listes déroulantes
$villes = $bdd->select('SELECT * FROM ville');
//var_dump($villes);


//2)VIEW: chargement du template
$page_quartier = new QuartierController('./template/quartier_view.html');


//3)CONTROLLER
//remplacement des données
$message = $page_quartier->getMessage();
$page_quartier->replaceBalise("#message#",$message);


//Modification d'un quartier
if(isset($_GET['id']))
{
    $page_quartier->replaceBalise("#titre#","Modification d'un quartier");

    //récupération du quartier dans les données de session
    $id = $_GET['id'];
    $quartiers = $_SESSION['quartiers'];
    $quartier = $quartiers[$id];

    $_SESSION['id'] = $_GET['id'];

    //champs text
    $page_quartier->setLibelleValue($quartier['libelle']);
    //champs select
    $page_quartier->setVilles($villes, $quartier['id_ville']);

}else{
    $page_quartier->replaceBalise("#titre#","Création d'un quartier");

    //champs text
    $page_quartier->setLibelleValue("");
    //champs select
    $page_quartier->setVilles($villes, null);
}

//4) Affichage :
echo $page_quartier->getHtml();