<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 26/06/2018 18:31
 * Description: Fait un INSERT ou un UPDDATE dans la base de données
 */

session_start();
//include_once ('./class/.php');


//MODEL
//comme ca avec ma classe ca ne marche pas :
include_once ('./class/Bdd.php');
$bdd = new Bdd();


if (!isset($_SESSION['id']))
{
    $max_id = $bdd->selectMaxId("utilisateur");
    $id = $max_id+1;
}


//CONTROLLER
//echo "Session:";var_dump($_SESSION);

$pseudo = $_SESSION['pseudo'];
$password = $_SESSION['password'];
$mail = $_SESSION['mail'];
$id_etat = $_SESSION['etat'];
$id_statut = $_SESSION['statut'];


if (isset($_SESSION['id']))
{
    //Modification d'utilisateur

    $id = $_SESSION['id'];

    //créer la requête UPDATE
    $sql_update_user = "
    UPDATE Utilisateur
    SET
        pseudo ='$pseudo',
        mail ='$mail',
        mot_de_passe ='$password',
        id_etat=$id_etat,
        id_statut=$id_statut
        WHERE id='$id'
    ";
    var_dump($sql_update_user);

    //exécuter la requête UPDATE
    $result = $bdd->executeQuery($sql_update_user);

    if ($result ==1 ) {
        $_SESSION['message'] = "modification de l'utilisateur $pseudo effectuée";
    }

}else{
    //Création d'utilisateur

    //créer la requête INSERT
    $sql_insert_user = "
    INSERT INTO utilisateur (id, pseudo, mail, mot_de_passe, id_etat, id_statut)
    VALUES ($id, '$pseudo', '$mail', '$password', $id_etat, $id_statut)";
    var_dump($sql_insert_user);

    //exécuter la requête INSERT
    $result = $bdd->executeQuery($sql_insert_user);

    if ($result ==1 ) {
        $_SESSION['message'] = "création de l'utilisateur $pseudo effectuée";
    }
}

echo "resultat : ";  var_dump($_SESSION['message']);
header('Location: user_list_controller.php');
