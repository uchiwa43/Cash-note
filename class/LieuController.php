<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 02/07/2018 21:55
 * Description:
 */

class LieuController extends Page
{

    /**
     * remplit chaque ligne du tableau avec les informations de la table ville
     * @param array $users Tableau de données provenant de la base de données
     * @return string Code HTML
     */
    public function remplirLignesLieux()
    {
        //lignes tr du tableau
        $lignes_lieux = "";
        foreach($_SESSION['lieux'] as $lieu)
        {
            //créer une ligne pour un utilisateur
            $lignes_lieux.= "
            <tr>
                <td>".$lieu['libelle']."</td>
                <td>".$lieu['ville']."</td>
                <td>".$lieu['quartier']."</td>
                <td><a href='lieu_controller.php?id=".$lieu['id']."' >Modifier</a></td>";
            $lignes_lieux .= "
            </tr>";
        }
        return $lignes_lieux;
    }

    /**
     * @param $statuts
     * @param $id_statut
     */
    public function setVilles($villes, $id_ville)
    {
        parent::setSelect($villes,"Villes","id_ville","#villes#", $id_ville);
    }

    /**
     * @param $statuts
     * @param $id_statut
     */
    public function setQuartiers($quartiers, $id_quartier)
    {
        parent::setSelect($quartiers,"Quartier","id_quartier","#quartiers#", $id_quartier);
    }



    /**Met à jour la ville en base
     * @param $bdd
     * @return mixed
     */
    public function updateLieu($bdd)
    {
        if ($_POST['id_quartier']==0)
        {
            $string_id_quartier = 'NULL';
        } else {
            $string_id_quartier = $_POST['id_quartier'];
        }

        //créer la requête UPDATE
        $sql_update_lieu = "
        UPDATE lieu
        SET
            libelle ='".$_POST['libelle']."',
            id_ville = ".$_POST['id_ville'].",
            id_quartier = $string_id_quartier
            WHERE id=".$_SESSION['id']."
        ";
        echo "La requête de mise a jour va être jouée :"; var_dump($sql_update_lieu);

        //exécuter la requête UPDATE
        $result = $bdd->executeQuery($sql_update_lieu);

        return $result;
    }


    /**Insère la ville en base
     * @param $bdd
     * @param $id
     * @return mixed
     */
    public function insertLieu($bdd, $id)
    {
        //Création d'utilisateur

        if ($_POST['id_quartier']==0)
        {
            $string_id_quartier = 'NULL';
        } else {
            $string_id_quartier = $_POST['id_quartier'];
        }

        //créer la requête INSERT
        $sql_insert_lieu = "
        INSERT INTO lieu (id, libelle, id_ville, id_quartier)
        VALUES ($id, '".$_POST['libelle']."',".$_POST['id_ville'].", $string_id_quartier )";
        echo "La requête d'insertion va être jouée :"; var_dump($sql_insert_lieu);

        //exécuter la requête INSERT
        $result = $bdd->executeQuery($sql_insert_lieu);
        return $result;
    }
}