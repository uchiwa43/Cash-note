<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 02/07/2018 18:57
 * Description:
 */

session_start();
require('autoload.php');

//1)MODEL


//2)VIEW: chargement du template
$page_ville = new VilleController('./template/ville_view.html');


//3)CONTROLLER
//remplacement des données
$message = $page_ville->getMessage();
$page_ville->replaceBalise("#message#",$message);

//Modification d'un utilisateur
if(isset($_GET['id']))
{
    $page_ville->replaceBalise("#titre#","Modification d'une ville");

    //récupération de l'utilisateur dans les données de session
    $id = $_GET['id'];
    $villes = $_SESSION['villes'];
    $ville = $villes[$id];

    $_SESSION['id'] = $_GET['id'];

    //champs text
    $page_ville->setLibelleValue($ville['libelle']);

}else{
    $page_ville->replaceBalise("#titre#","Création d'une ville");

    //champs text
    $page_ville->setLibelleValue("");
}


//4) Affichage :
echo $page_ville->getHtml();