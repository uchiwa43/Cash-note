<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 24/06/2018 22:22
 * Description: Parent de toutes les classes métier
 */

class Page
{
    /**
     * Code HTML manipulé par l'objet
     * @var string
     */
    protected $html;

    /**
     * Constructeur qui charge le template HTML dans la propriété
     * @param string $html_template
     */
    function __construct($html_template='')
    {
        if($html_template != '')
        {
            $this->html = file_get_contents($html_template);
        }
    }

    /**
     * Renvoie le HTML rempli avec les données, qui sera affiché(echo à la fin du controller)
     * @return string
     */
    function getHtml()
    {
        return $this->html;
    }

    /**
     * Remplace une #balise# par un contenu
     * @param string $balise
     * @param string $content
     */
    function replaceBalise($balise,$content)
    {
        $this->html = str_replace($balise,$content,$this->html);
    }

    /**
     * Met une valeur dans un input de type text :
     * -soit la valeur en session si elle existe,
     * -soit si c'est une modification par le résultat d'une requête sql
     * -soit si c'est une creation par ""
     * @param string $balise #value_...# dans la value d'un input
     * @param string $var_in_session Valeur en session
     * @param string $default "" ou valeur d'un resultat de requête
     */
    public function setInputValue($balise, $var_in_session, $init_value)
    {
        if (isset($_SESSION[$var_in_session]))
        {
            $this->replaceBalise($balise, $_SESSION[$var_in_session]);
        }else{
            $this->replaceBalise($balise, $init_value);
        }
    }

    /**Génère un select avec
     * autant d'options que donné dans l'array de données qui proviens de la requête sql
     * et l'option a selected si on le récupère en base
     * @param $array_sql
     * @param $label
     * @param $name
     * @param $balise
     */
    public function setSelect($array_sql ,$label, $name, $balise, $id_in_sql)
    {

        $html = "
        <label>$label :</label>
        <select name=$name>";

        if(isset($_SESSION[$name]))
        {
            $id_to_compare = $_SESSION[$name];
        }else{
            $id_to_compare = $id_in_sql;
        }

        foreach ($array_sql as $enregistrement)
        {
            $selected='';
            if ($enregistrement['id'] == $id_to_compare)
            {
                $selected = "selected";
            }
            $html .= "<option value='".$enregistrement['id']."' ". $selected .">" . $enregistrement['libelle'] . "</option>";
        }

        $html .= '
        </select><br/><br/>';

        $this->replaceBalise($balise, $html);
    }

    /**
     * @param string $name Nom du champs dans le formulaire
     * @return bool est-ce que le champs est vérifié ou non?
     */
    public function checkInputText($name)
    {
        $_SESSION[$name] = strip_tags($_POST[$name]);

        if (strlen($_POST[$name]) >= 0 and strlen($_POST[$name]) < 50)
        {
            echo "Le champs $name est vérifié<br>";
            return true;

        }else{
            echo "Erreur champ $name<br/>";
            return false;
        }
    }

    public function checkSelect($name,$limit)
    {
        $_SESSION[$name] = strip_tags($_POST[$name]);

        if ($_POST[$name] >= 0 and $_POST[$name] <= $limit )
        {
            echo "Le champs $name est vérifié<br>";
            return true;
        }
        else {
            echo "Erreur champs $name<br/>";
            return false;
        }
    }

}