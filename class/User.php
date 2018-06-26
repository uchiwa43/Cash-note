<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 25/06/2018 08:54
 * Description: Classe utilisé par le user_controller.php
 * pour remplir les données du formulaire user_view.html
 */

include_once ('./class/Page.php');
include_once ('Bdd.php');
$bdd = new Bdd();
include_once ('template/header_jquery.html');

class User extends Page
{
    /**
     * User constructor.
     * @param string $html_template Chemin du template
     */
    public function __construct($html_template)
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
    public function setEtat($etats, $id_etat)
    {
        parent::setSelect($etats,"Etat", "etat","#etats#", $id_etat);
    }

    public function setStatut($statuts, $id_statut)
    {
        parent::setSelect($statuts,"Statut","statut","#statuts#", $id_statut);
    }
}