<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 24/06/2018 23:30
 * Description:
 */

include_once ('class/Page.php');
include_once ('Bdd.php');
include_once ('template/header_jquery.html');

class UserList extends Page
{
    //
    protected $listHtml;

    function __construct($template)
    {
        parent::__construct($template);
    }

    function remplirLignesUtilisateurs($users)
    {
        //lignes tr du tableau
        $lignes_utilisateur = "";
        foreach($users as $user)
        {
            //créer une ligne pour un utilisateur
            $lignes_utilisateur.= "
            <tr>
                <td>".$user['pseudo']."</td>
                <td>".$user['statut']."</td>
                <td>".$user['mail']."</td>
                <td>".$user['mot_de_passe']."</td>
                <td>".$user['etat']."</td>
                <td><a href='user_form_update.php?id=".$user['id']."' >Modifier</a></td>";
            $lignes_utilisateur.="</tr>";

        }
        return $lignes_utilisateur;
    }

    function getMessage()
    {
        $message='';
        if(isset($_SESSION['message'])){
            $message = $_SESSION['message'];
        };
        $_SESSION['message']='';

        return $message;
    }

}