<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 03/07/2018 20:16
 * Description:
 */

class SiteController extends Page
{

    /**
     * remplit chaque ligne du tableau avec les informations de la table ville
     * @param array $users Tableau de données provenant de la base de données
     * @return string Code HTML
     */
    public function remplirLignesSites()
    {
        //lignes tr du tableau
        $lignes_sites = "";
        foreach($_SESSION['sites'] as $site)
        {
            //traitement spécifique de la couleur de l'état
            $color="";
            if($site['id_etat']==1)
            {
                $color="style='color:green'";
            }else {
                if($site['id_etat']==2)
                {
                    $color="style='color:red'";
                }
            }

            //créer une ligne pour un utilisateur
            $lignes_sites.= "
            <tr>
                <td>".$site['libelle']."</td>
                <td><a href='".$site['url']."'>".$site['url']."</a></td>
                <td $color >".$site['etat']."</td>
                <td><a href='site_controller.php?id=".$site['id']."' >Modifier</a></td>";
            $lignes_sites .= "
            </tr>";

        }
        return $lignes_sites;
    }

    public function setAdresseValue($init_value)
    {
        parent::setInputValue("#adresse_value#", 'url', $init_value);
    }

    //setEtat : dans Page




    /**Met à jour la ville en base
     * @param $bdd
     * @return mixed
     */
    public function updateSite($bdd)
    {
        //créer la requête UPDATE
        $sql_update_site = "
        UPDATE site_internet
        SET
            libelle ='".$_POST['libelle']."',
            url = '".$_POST['url']."',
            id_etat = ".$_POST['id_etat']."
            WHERE id=".$_SESSION['id']."
        ";
        echo "La requête de mise a jour va être jouée :"; var_dump($sql_update_site);

        //exécuter la requête UPDATE
        $result = $bdd->executeQuery($sql_update_site);

        return $result;
    }


    /**Insère la ville en base
     * @param $bdd
     * @param $id
     * @return mixed
     */
    public function insertSite($bdd, $id)
    {
        //créer la requête INSERT
        $sql_insert_site = "
        INSERT INTO site_internet (id, libelle, url, id_etat)
        VALUES ($id, '".$_POST['libelle']."', '".$_POST['url']."', ".$_POST['id_etat'].")";
        echo "La requête d'insertion va être jouée :"; var_dump($sql_insert_site);

        //exécuter la requête INSERT
        $result = $bdd->executeQuery($sql_insert_site);
        return $result;
    }
}