<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 02/07/2018 20:23
 * Description:
 */

class QuartierController extends Page
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
    public function remplirLignesQuartiers()
    {
        //lignes tr du tableau
        $lignes_quartiers = "";
        foreach($_SESSION['quartiers'] as $quartier)
        {
            //créer une ligne pour un utilisateur
            $lignes_quartiers.= "
            <tr>
                <td>".$quartier['id']."</td>
                <td>".$quartier['libelle']."</td>
                <td>".$quartier['ville']."</td>
                <td><a href='quartier_controller.php?id=".$quartier['id']."' >Modifier</a></td>";
            $lignes_quartiers .= "
            </tr>";

        }
        return $lignes_quartiers;
    }

    /**
     * @param $statuts
     * @param $id_statut
     */
    public function setVilles($statuts, $id_statut)
    {
        parent::setSelect($statuts,"Villes","id_ville","#villes#", $id_statut);
    }

    /**Met à jour la ville en base
     * @param $bdd
     * @return mixed
     */
    public function updateQuartier($bdd)
    {
        //créer la requête UPDATE
        $sql_update_quartier = "
        UPDATE quartier
        SET
            libelle ='".$_POST['libelle']."',
            id_ville = ".$_POST['id_ville']."
            WHERE id=".$_SESSION['id']."
        ";
        echo "La requête de mise a jour va être jouée :"; var_dump($sql_update_quartier);

        //exécuter la requête UPDATE
        $result = $bdd->executeQuery($sql_update_quartier);

        return $result;
    }

    /**Insère la ville en base
     * @param $bdd
     * @param $id
     * @return mixed
     */
    public function insertQuartier($bdd, $id)
    {
        //Création d'utilisateur

        //créer la requête INSERT
        $sql_insert_quartier = "
        INSERT INTO quartier (id, libelle, id_ville)
        VALUES ($id, '".$_POST['libelle']."',".$_POST['id_ville'].")";
        echo "La requête d'insertion va être jouée :"; var_dump($sql_insert_quartier);

        //exécuter la requête INSERT
        $result = $bdd->executeQuery($sql_insert_quartier);
        return $result;
    }
}