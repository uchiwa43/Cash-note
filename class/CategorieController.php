<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 02/07/2018 23:11
 * Description:
 */

class CategorieController extends Page
{


    /**
     * remplit chaque ligne du tableau avec les informations de la table ville
     * @param array $users Tableau de données provenant de la base de données
     * @return string Code HTML
     */

    public function remplirLignesCategories()
    {
        //lignes tr du tableau
        $lignes_categories = "";
        foreach($_SESSION['categories'] as $categorie)
        {
            //créer une ligne pour un utilisateur
            $lignes_categories.= "
            <tr>
                <td>".$categorie['libelle']."</td>
                <td>".$categorie['type']."</td>
                <td><a href='categorie_controller.php?id=".$categorie['id']."' >Modifier</a></td>";
            $lignes_categories .= "
            </tr>";
        }
        return $lignes_categories;
    }

    public function setType($type_categorie, $id_ville)
    {
        parent::setSelect($type_categorie,"Type","id_type_categorie","#types#", $id_ville);
    }




    /**Met à jour la ville en base
     * @param $bdd
     * @return mixed
     */
    public function updateCategorie($bdd)
    {
        //créer la requête UPDATE
        $sql_update_lieu = "
        UPDATE categorie
        SET
            libelle = '".$_POST['libelle']."',
            id_type_categorie = ".$_POST['id_type_categorie']."
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
    public function insertCategorie($bdd, $id)
    {
        //créer la requête INSERT
        $sql_insert_categorie = "
        INSERT INTO categorie (id, libelle, id_type_categorie)
        VALUES ($id, '".$_POST['libelle']."',".$_POST['id_type_categorie'].")";
        echo "La requête d'insertion va être jouée :";
        var_dump($sql_insert_categorie);

        //exécuter la requête INSERT
        $result = $bdd->executeQuery($sql_insert_categorie);
        return $result;
    }
}