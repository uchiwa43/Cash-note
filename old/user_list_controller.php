<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash Note
 * Date: 23/06/2018 00:19
 * Description: Affiche la liste des utilisateurs actifs ou inactifs
 */

echo "modif sur dev";

include 'header_jquery.html';
//New Page(...user_list_viewer...) et dans Page mettre include 'header_jquery.html';

include 'connexion_db.php';
//include user_list_model et dedans mettre include 'connexion_db.php';

//on charge tout le contenu du template dans une page
$page = file_get_contents('./template/user_list_view.html');

///////////////////////////////////////DONNEES/////////////////////////////////////////////////
//si dans l'url on a show_disabled=1 on est en mode "Utilisateurs désactivés"

$message='';
if(isset($_SESSION['message'])){
    $message = $_SESSION['message'];
    echo $message;
};
$_SESSION['message']='';


$lien = "<a href='user_list_controller.php?show_disabled=1'>Voir les utilisateurs désactivés</a><br/>";
if(isset($_GET['show_disabled']) && $_GET['show_disabled']==1)
{
    $lien = "<a href='user_list_controller.php'>Voir les utilisateurs actifs</a><br/>";
}


//lignes tr du tableau
$tr = "";

$query = "SELECT id,prenom,nom FROM utilisateur where id_etat=1"; //utilisateurs actifs
if(isset($_GET['show_disabled']) && $_GET['show_disabled']==1)
{
    $query = "SELECT id,prenom,nom FROM utilisateur where id_etat=2"; //utilisateurs désactivés
}

//exécution de la requête
$reponse = $bdd->query($query);
//tant qu'on a des utilisateurs :
while($user = $reponse->fetch(PDO::FETCH_ASSOC) )
{
    //créer une ligne pour un utilisateur
    $tr.= "
        <tr>
            <td>".$user['id']."</td>
            <td>".$user['nom']."</td>
            <td>".$user['prenom']."</td>
            <td><a href='user_form_update.php?id=".$user['id']."' >Modifier</a></td>";
            if(isset($_GET['show_disabled']) && $_GET['show_disabled']==1)
            {
                $tr.="<td><a>Activer</a></td>";
            }else{
                $tr.="<td><a href='user_action_disable.php?id=".$user['id']."'>Désactiver</a></td>";
            }
        $tr.="</tr>";
}
///////////////////////////////////////FIN DONNEES/////////////////////////////////////////////////

//on remplace les balises du template par les données
$page= str_replace("#message#", $message, $page);
$page= str_replace("#lien#", $lien, $page);
$page= str_replace("#tr#", $tr, $page);

//on affiche la page
echo $page;
