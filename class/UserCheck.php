<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 26/06/2018 09:37
 * Description:
 */

include_once ('./class/Page.php');
include_once ('Bdd.php');
$bdd = new Bdd();

class UserCheck extends Page
{

    public function checkPseudo()
    {
        $bool_verif = $this->checkInputText('pseudo');
        return $bool_verif;
    }

    public function checkMail()
    {
        $bool_verif = $this->checkInputText('mail');
        return $bool_verif;
    }
    public function checkPassword()
    {
        $bool_verif = $this->checkInputText('mot_de_passe');
        return $bool_verif;
    }

    public function checkStatut($limit)
    {
        $is_statut_verified = $this->checkSelect('statut', $limit);
        return $is_statut_verified;
    }

    public function checkEtat($limit)
    {
        $is_statut_verified = $this->checkSelect('etat', $limit);
        return $is_statut_verified;
    }

    /**
     * @param $bool_fields
     */
    public function traitement($bool_fields)
    {
        //Si tous les champs sont corrects
        if ($bool_fields)
        {
            $_SESSION['message'] = "Pas d'erreur";

            if(isset($_SESSION['id']))
            {
                //Modification
                $_SESSION['message'] .= ", Modification";
                $_SESSION['bdd_action'] = "update";
                echo "Session : ";var_dump($_SESSION);

                //Redirection pour faire la requête UPDATE
                //header('Location: user_updatedb_controller.php');

            }else{
                //Creation
                $_SESSION['message'] .= ", Création";
                $_SESSION['bdd_action'] = "insert";
                echo "Session : ";var_dump($_SESSION);

                //Redirection pour faire la requête INSERT
                //header('Location: user_updatedb_controller.php');
            }

        }else{ //si au moins un champs est incorrect

            //mettre ce message en session pour l'afficher sur le formulaire
            $_SESSION['message'] = "Il y a (au moins) une erreur dans le formulaire";
            echo $_SESSION['message'];

            //redirection vers le formulaire
            header('Location: user_controller.php');
        }

    }
}