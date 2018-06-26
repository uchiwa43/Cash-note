<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 26/06/2018 09:37
 * Description: Classe utilisé par le user_check_controller.php
 * pour vérifier les données envoyées dans le formulaire user_view.html
 */

include_once ('./class/Page.php');
include_once ('Bdd.php');
$bdd = new Bdd();


class UserCheck extends Page
{
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
    public function traitement($bool_fields)
    {
        //Si tous les champs sont corrects
        if ($bool_fields)
        {
            $_SESSION['message'] = "Pas d'erreur";

            if(isset($_SESSION['id'])){
                //Modification
                $_SESSION['message'] .= ", Modification";
                echo "Session : ";var_dump($_SESSION);

            }else{
                //Creation
                $_SESSION['message'] .= ", Création";
                echo "Session : ";var_dump($_SESSION);
            }
            //redirection pour l'INSERT ou l'UPDATE en base
            header('Location: user_updatedb_controller.php');

        }else{
            //si au moins un champ est incorrect

            //message affiché sur le formulaire
            $_SESSION['message'] = "Il y a (au moins) une erreur dans le formulaire";
            //echo $_SESSION['message'];

            //redirection vers le formulaire
            header('Location: user_controller.php');
        }

    }
}