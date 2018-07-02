<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 02/07/2018 18:43
 * Description:
 */

class VilleController extends Page
{
    public function __construct($html_template='')
    {
        parent::__construct($html_template);
    }


    /**
     * remplit chaque ligne du tableau avec les informations de la table ville
     * @param array $users Tableau de données provenant de la base de données
     * @return string Code HTML
     */
    public function remplirLignesVille()
    {
        //lignes tr du tableau
        $lignes_ville = "";
        foreach($_SESSION['villes'] as $ville)
        {
            //créer une ligne pour un utilisateur
            $lignes_ville.= "
            <tr>
                <td>".$ville['id']."</td>
                <td>".$ville['libelle']."</td>
                <td><a href='ville_controller.php?id=".$ville['id']."' >Modifier</a></td>";
            $lignes_ville .= "
            </tr>";

        }
        return $lignes_ville;
    }


    /**Pré-remplis le libellé par la valeur en session ou par la valeur donnée (valeur en base ou '')
     * @param $init_value
     */
    public function setLibelleValue($init_value)
    {
        parent::setInputValue("#libelle_value#", 'libelle', $init_value);
    }

    /**Met à jour la ville en base
     * @param $bdd
     * @return mixed
     */
    public function updateVille($bdd)
    {
        //créer la requête UPDATE
        $sql_update_ville = "
        UPDATE ville
        SET
            libelle ='".$_POST['libelle']."'
            WHERE id=".$_SESSION['id']."
        ";
        echo "La requête de mise a jour va être jouée :"; var_dump($sql_update_ville);

        //exécuter la requête UPDATE
        $result = $bdd->executeQuery($sql_update_ville);

        return $result;
    }

    /**Insère la ville en base
     * @param $bdd
     * @param $id
     * @return mixed
     */
    public function insertVille($bdd, $id)
    {
        //Création d'utilisateur

        //créer la requête INSERT
        $sql_insert_ville = "
        INSERT INTO ville (id, libelle)
        VALUES ($id, '".$_POST['libelle']."')";
        echo "La requête d'insertion va être jouée :"; var_dump($sql_insert_ville);

        //exécuter la requête INSERT
        $result = $bdd->executeQuery($sql_insert_ville);
        return $result;
    }

}