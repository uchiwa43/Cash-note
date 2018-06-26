<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 24/06/2018 23:30
 * Description: Classe utilisé par le user_list_controller.php
 * pour remplir la liste d'utilisateurs dans user_list_view.html
 */

include_once ('./class/Page.php');
include_once ('./class/Bdd.php');
$bdd = new Bdd();
include_once ('template/header_jquery.html');

class UserList extends Page
{
    /**
     * UserList constructor.
     * @param $template
     */
    public function __construct($template)
    {
        parent::__construct($template);
    }

    /**
     * remplit chaque ligne du tableau avec les informations de la table utilisateur
     * @param array $users Tableau de données provenant de la base de données
     * @return string Code HTML
     */
    public function remplirLignesUtilisateurs($users)
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
                <td><a href='user_controller.php?id=".$user['id']."' >Modifier</a></td>";
            $lignes_utilisateur .= "
            </tr>";

        }
        return $lignes_utilisateur;
    }

}