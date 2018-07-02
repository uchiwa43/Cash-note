<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 02/07/2018 23:26
 * Description:
 */

session_start();
require('autoload.php');
//var_dump($_SESSION);

//1)MODEL :
$bdd = new Bdd();
//requête de selection des etats et des statuts pour alimenter les listes déroulantes
$type_categorie = $bdd->select('SELECT * FROM type_categorie');



//2)VIEW: chargement du template
$page_categorie = new CategorieController('./template/categorie_view.html');



//3)CONTROLLER
//remplacement des données
$message = $page_categorie->getMessage();
$page_categorie->replaceBalise("#message#",$message);

if(isset($_GET['id']))
{
    $page_categorie->replaceBalise("#titre#","Modification d'une categorie");

    $id = $_GET['id'];
    $categories = $_SESSION['categories'];
    $categorie = $categories[$id];

    $_SESSION['id'] = $_GET['id'];

    //champs text
    $page_categorie->setLibelleValue($categorie['libelle']);
    //champs select
    $page_categorie->setType($type_categorie,$categorie['id']);
}else{
    $page_categorie->replaceBalise("#titre#","Création d'une categorie");

    //champs text
    $page_categorie->setLibelleValue("");
    //champs select
    $page_categorie->setType($type_categorie,null);
}

//4) Affichage :
echo $page_categorie->getHtml();