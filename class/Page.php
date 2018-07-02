<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 24/06/2018 22:22
 * Description: Cette classe concerne le traitement du code HTML:
 * - récupération du HTML d'un template
 * - remplacement des balises
 * - et vérification des valeurs
 * Parent de toutes les classes sauf Bdd.
 */

class Page
{
    /**
     * Code HTML d'un template mis dans cette variable,
     * manipulé par un controlleur
     * et affiché à la fin de ce controller
     * @var string
     */
    protected $html;

    /**
     * Constructeur qui récupère le template HTML s'il est défini
     * @param string $html_template
     */
    function __construct($html_template='')
    {
        if($html_template != ''){
            $this->html = file_get_contents($html_template);
        }
    }

    /**
     * Renvoie le HTML, qui sera affiché(echo à la fin du controller)
     * @return string HTML
     */
    function getHtml()
    {   return $this->html;}

    /**
     * Renvoie un message stocké en session s'il existe
     * @return string Message pour l'utilisateur
     */
    public function getMessage()
    {
        $message = '';
        if(isset($_SESSION['message'])){
            $message = $_SESSION['message'];
        };
        $_SESSION['message']='';

        return $message;
    }


    /**
     * Remplace une #balise# par un contenu dans la propriété html
     * @param string $balise La #balise# à remplacer dans le template
     * @param string $content Le contenu qui remplacera la balise
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
     * @param string $var_in_session Valeur stockée en session
     * @param string $init_value Valeur="" ou valeur d'un resultat de requête
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

    /**Pré-remplis le libellé par la valeur en session ou par la valeur donnée (valeur en base ou '')
     * utilise le SetInputValue mais il est commun sur plusieurs modules donc autant le réutiliser
     * @param $init_value
     */
    public function setLibelleValue($init_value)
    {
        $this->setInputValue("#libelle_value#", 'libelle', $init_value);
    }

    /**Génère un select avec autant d'options que d'éléments dans l'array de données
     * et l'option a selected si on le récupère en base
     * @param array $array_sql Array de données(qui proviens de la requête sql)
     * @param string $label Nom affiché avant le champ
     * @param string $name Nom du champs dans le formulaire
     * @param string $balise #balise# à remplacer
     * @param int $id_in_sql
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
     * Vérifie que les valeurs sont comprises entre 0 et 50 caractères (limite en base de données)
     * et que les balises soient échappées
     * @param string $name Nom du champs dans le formulaire
     * @return bool Est-ce que le champs est vérifié ou non?
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

    /**
     * Vérifie que les valeurs sont comprises entre 0 et la limite
     * @param string $name Nom du champs dans le formulaire
     * @param $limit
     * @return bool Est-ce que le champs est vérifié ou non?
     */
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


    public function checkRadio()
    {
        $_SESSION['sexe'] = $_POST['sexe'];
        if ($_POST['sexe']=='H' or $_POST['sexe']=='F')
        {
            echo "Le champs sexe est vérifié<br>";
            return true;
        }else{
            echo "Erreur champ sexe <br/>";
            return false;
        }
    }

}