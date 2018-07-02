<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 02/07/2018 19:10
 * Description:
 */

session_start();
require('autoload.php');

var_dump($_POST);


$bdd = new Bdd();
//si on créé un utilisateur, il aura pour id : l'id maximum des utilisateurs auquel on ajoute 1
if (!isset($_SESSION['id']))
{
    $max_id = $bdd->selectMaxId("ville");
    $id = $max_id+1;
}


//2)VIEW: aucune


//3)CONTROLLER
$ville_edit = new VilleController();
echo "Session:";var_dump($_SESSION);

if (isset($_SESSION['id']))
{
    //Modification d'utilisateur
    $result = $ville_edit->updateVille($bdd);
    var_dump($result);
    if ($result ==1 ) {
        $_SESSION['message'] = "Modification de la ville " .$_POST['libelle']. " effectuée";
    }

}else{

    //Création d'utilisateur
    echo "id :" . $id;
    //exécuter la requête INSERT
    $result = $ville_edit->insertVille($bdd, $id);

    if ($result ==1 ) {
        $_SESSION['message'] = "Création de la ville " .$_POST['libelle']. " effectuée";
    }
}

echo "resultat : ";  var_dump($_SESSION['message']);
echo "<script type='text/javascript'>document.location.replace('ville_controller_list.php');</script>";