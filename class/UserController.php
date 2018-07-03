<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 25/06/2018 08:54
 * Description: Classe utilisé par le user_controller.php
 * pour remplir les données du formulaire user_view.html
 */


class UserController extends Page
{
    //todo supprimer ca
    /**
     * User constructor.
     * @param string $html_template Chemin du template
     */
    public function __construct($html_template='')
    {
        parent::__construct($html_template);
    }


    //champs text
    //appelle setInputValue en donnant des arguments fixes pour le pseudo, le mail et le password
    // (pour avoir moins de paramètre dans le controller)
    public function setPseudoValue($init_value)
    {
        parent::setInputValue("#pseudo_value#", 'pseudo', $init_value);
    }

    public function setMailValue($init_value)
    {
        parent::setInputValue("#mail_value#", 'mail', $init_value);
    }

    public function setPasswordValue($init_value)
    {
        parent::setInputValue("#password_value#", 'password', $init_value);
    }

    //champs select
    //appelle setSelect en donnant des arguments fixes pour l'état et le statut
    // (pour avoir moins de paramètre dans le controller)
    public function setStatut($statuts, $id_statut)
    {
        parent::setSelect($statuts,"Statut","statut","#statuts#", $id_statut);
    }
    //setEtat : dans Page

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


    //champs text
    //appelle checkInputText en donnant des arguments fixes pour le pseudo, le mail et le password
    // (pour avoir moins de paramètre dans le controller)
    public function checkPseudo()
    {
        $bool_verif = parent::checkInputText('pseudo');
        return $bool_verif;
    }

    public function checkMail()
    {
        $bool_verif = parent::checkInputText('mail');
        return $bool_verif;
    }
    public function checkPassword()
    {
        $bool_verif = parent::checkInputText('password');
        return $bool_verif;
    }

    //champs select
    //appelle setSelect en donnant des arguments fixes pour l'état et le statut
    // (pour avoir moins de paramètre dans le controller)
    public function checkStatut($limit)
    {
        $is_statut_verified = parent::checkSelect('statut', $limit);
        return $is_statut_verified;
    }

    public function checkEtat($limit)
    {
        $is_statut_verified = parent::checkSelect('etat', $limit);
        return $is_statut_verified;
    }

    /**
     * Traitement si les champs sont corrects ou si les champs sont incorrects
     * @param bool $bool_fields Opération "&" sur tous les boolens de vérification
     *      s'il vaut 1 c'est que tous les champs sont corrects
     */
    public function traitementFormulaire($bool_fields)
    {
        //Si tous les champs sont corrects
        if ($bool_fields)
        {
            $_SESSION['message'] = "Pas d'erreur";

            if(isset($_SESSION['id'])){
                //Modification
                $_SESSION['message'] .= ", Modification";
                //echo "Session : ";var_dump($_SESSION);

            }else{
                //Creation
                $_SESSION['message'] .= ", Création";
                //echo "Session : ";var_dump($_SESSION);
            }
            //redirection pour l'INSERT ou l'UPDATE en base
            //redirection en javascript, car on ne peut pas faire header() si on a des données en SESSION
            echo "<script type='text/javascript'>document.location.replace('user_controller_edit_db.php');</script>";

        }else{
            //si au moins un champ est incorrect

            //message affiché sur le formulaire
            $_SESSION['message'] = "Il y a (au moins) une erreur dans le formulaire";
            //echo $_SESSION['message'];

            //redirection vers le formulaire
            //header('Location: user_controller.php');
            echo "<script type='text/javascript'>document.location.replace('user_controller.php');</script>";
        }
    }

    public function updateUser($bdd)
    {

        //créer la requête UPDATE
        $sql_update_user = "
        UPDATE utilisateur
        SET
            pseudo ='".$_SESSION['pseudo']."',
            mail ='".$_SESSION['mail']."',
            mot_de_passe ='".$_SESSION['password']."',
            id_etat=".$_SESSION['id_etat'].",
            id_statut=".$_SESSION['statut']."
            WHERE id=".$_SESSION['id']."
        ";
        echo "La requête de mise a jour va être jouée :"; var_dump($sql_update_user);

        //exécuter la requête UPDATE
        $result = $bdd->executeQuery($sql_update_user);

        return $result;
    }

    public function insertUser($bdd, $id)
    {
        //Création d'utilisateur

        //créer la requête INSERT
        $sql_insert_user = "
        INSERT INTO utilisateur (id, pseudo, mail, 
        mot_de_passe, id_etat, id_statut)
        VALUES ($id, '".$_SESSION['pseudo']."', '".$_SESSION['mail']. "' , '".$_SESSION['password']."' ,".$_SESSION['etat'].", ".$_SESSION['statut'].")
            ";
        var_dump($sql_insert_user);

        //exécuter la requête INSERT
        $result = $bdd->executeQuery($sql_insert_user);
        return $result;
    }
}