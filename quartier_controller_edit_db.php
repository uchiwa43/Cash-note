<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 02/07/2018 21:06
 * Description:
 */

session_start();
require('autoload.php');

var_dump($_POST);
var_dump($_SESSION);

//1)MODEL
$bdd = new Bdd();
if (!isset($_SESSION['id']))
{
    $max_id = $bdd->selectMaxId("quartier");
    $id = $max_id+1;
    //echo "id : $id";
}


//2)VIEW: aucune


//3)CONTROLLER
$page_quartier_edit = new QuartierController();


if (isset($_SESSION['id']))
{
    $result = $page_quartier_edit->updateQuartier($bdd);
    var_dump($result);
    if ($result ==1 ) {
        $_SESSION['message'] = "Modification du quartier ".$_POST['libelle']." effectuée";
    }

}else{
    //Création d'utilisateur

    //exécuter la requête INSERT
    $result = $page_quartier_edit->insertQuartier($bdd, $id);

    if ($result ==1 ) {
        $_SESSION['message'] = "Création du quartier ".$_POST['libelle']." effectuée";
    }
}

echo "resultat : ";  var_dump($_SESSION['message']);
//header('Location: user_list_controller.php');
echo "<script type='text/javascript'>document.location.replace('quartier_controller_list.php');</script>";