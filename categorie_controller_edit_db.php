<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 02/07/2018 23:45
 * Description:
 */

session_start();
require('autoload.php');

var_dump($_SESSION);var_dump($_POST);


//1)MODEL
$bdd = new Bdd();
if (!isset($_SESSION['id']))
{
    $max_id = $bdd->selectMaxId("categorie");
    $id = $max_id+1;
    echo "id : $id";
}


//2)VIEW: aucune



//3)CONTROLLER
$page_categorie_edit = new CategorieController();


if (isset($_SESSION['id'])) {
    $result = $page_categorie_edit->updateCategorie($bdd);
    var_dump($result);
    if ($result == 1) {
        $_SESSION['message'] = "Modification de la catégorie " . $_POST['libelle'] . " effectuée";
    }

} else {
    //Création d'utilisateur

    //exécuter la requête INSERT
    $result = $page_categorie_edit->insertCategorie($bdd, $id);
    var_dump($result);

    if ($result == 1) {
        $_SESSION['message'] = "Création de la catégorie " . $_POST['libelle'] . " effectuée";
    }
}
echo "resultat : "; var_dump($_SESSION['message']);
echo "<script type='text/javascript'>document.location.replace('categorie_controller_list.php');</script>";
