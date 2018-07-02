<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 02/07/2018 22:32
 * Description:
 */

session_start();
require('autoload.php');

var_dump($_POST);

//1)MODEL
$bdd = new Bdd();
if (!isset($_SESSION['id']))
{
    $max_id = $bdd->selectMaxId("lieu");
    $id = $max_id+1;
    echo "id : $id";
}


//2)VIEW: aucune


//3)CONTROLLER
$page_lieu_edit = new LieuController();

if ($_POST['id_quartier']==0)
{
    $_POST['id_quartier']= null;
}


if (isset($_SESSION['id'])) {
    $result = $page_lieu_edit->updateLieu($bdd);
    var_dump($result);
    if ($result == 1) {
        $_SESSION['message'] = "Modification du lieu " . $_POST['libelle'] . " effectuée";
    }

} else {
    //Création d'utilisateur

    //exécuter la requête INSERT
    $result = $page_lieu_edit->insertLieu($bdd, $id);

    if ($result == 1) {
        $_SESSION['message'] = "Création du lieu " . $_POST['libelle'] . " effectuée";
    }
}

echo "resultat : ";
var_dump($_SESSION['message']);
//header('Location: user_list_controller.php');
echo "<script type='text/javascript'>document.location.replace('lieu_controller_list.php');</script>";
