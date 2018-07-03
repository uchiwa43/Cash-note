<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 03/07/2018 20:58
 * Description:
 */

session_start();
require('autoload.php');

//1)MODEL
$bdd = new Bdd();
if (!isset($_SESSION['id']))
{
    $max_id = $bdd->selectMaxId("site_internet");
    $id = $max_id+1;
}



//2)VIEW: aucune



//3)CONTROLLER
$page_site_edit = new SiteController();

if (isset($_SESSION['id'])) {
    $result = $page_site_edit->updateSite($bdd);
    var_dump($result);
    if ($result == 1) {
        $_SESSION['message'] = "Modification du site " . $_POST['libelle'] . " effectuée";
    }

} else {
    //Création d'utilisateur

    //exécuter la requête INSERT
    $result = $page_site_edit->insertSite($bdd, $id);
    var_dump($result);

    if ($result == 1) {
        $_SESSION['message'] = "Création du site " . $_POST['libelle'] . " effectuée";
    }
}
echo "resultat : "; var_dump($_SESSION['message']);
echo "<script type='text/javascript'>document.location.replace('site_controller_list.php');</script>";
