<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 25/06/2018 08:54
 * Description:
 */

include_once ('class/Page.php');
include_once ('Bdd.php');
$bdd = new Bdd();
include_once ('template/header_jquery.html');

class User extends Page
{
    /**
     * User constructor.
     * @param $html_template
     */
    public function __construct($html_template)
    {
        parent::__construct($html_template);
    }

    public function setEtat($etats)
    {
        parent::setSelect($etats, "Etat", "etat","#etats#");
    }

    public function setStatut($statuts)
    {
        $options = parent::setSelect($statuts,"Statut","statut","#statuts#");
    }
}