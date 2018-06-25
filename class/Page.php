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
    function __construct($html_template)
    {
        $this->html = file_get_contents($html_template);
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

    public function setSelect($array_sql, $label, $name, $balise)
    {
        $html = "
        <label>$label :</label>
        <select name='$name'>";

        foreach ($array_sql as $enregistrement)
        {
            $html .= "<option value='".$enregistrement['id']."'>" . $enregistrement['libelle'] . "</option>";
        }

        $html .= '
        </select><br/><br/>';

        $this->replaceBalise($balise, $html);
    }

}