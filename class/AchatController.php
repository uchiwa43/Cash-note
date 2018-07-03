<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 03/07/2018 23:16
 * Description:
 */

class AchatController extends Page
{
    /**
     * remplit chaque ligne du tableau avec les informations de la table ville
     * @param array $users Tableau de données provenant de la base de données
     * @return string Code HTML
     */

    public function remplirLignesAchats()
    {
        //lignes tr du tableau
        $lignes_achats = "";

        foreach ($_SESSION['achats'] as $achats) {

            //traitement spécifique sur l'url produit
            $string_site = $achats['site'];
            if(!is_null($achats['url_produit']))
            {
                $string_site = "<a href='".$achats['url_produit']."' target='_blank'>".$achats['site']."</a>";
            }
            else
            {
                if (!is_null($achats['url_site']))
                {
                    $string_site = "<a href='".$achats['url_site']."' target='_blank'>".$achats['site']."</a>";
                }
            }

            //créer une ligne pour un utilisateur
            $lignes_achats .= "
            <tr>
                <td><a href='achats_controller.php?id= ". $achats['id'] ."'>Modifier</a></td>
                <td>". $achats['libelle'] ."</td>
                <td>". $achats['id_categorie'] ."</td>
                <td>". $achats['etat'] ."</td>
                <td>". $achats['prix_achat_reel'] ."<br/>". $achats['prix_achat_prevu'] ."</td>
                <td>". $achats['moyen_payement'] ."</td>
                <td>". $achats['date_achat_reelle'] ."</td>
                <td>". $achats['lieu'] ."</td>
                <td>". $string_site ."</td>";
            $lignes_achats .= "
            </tr>";
        }
        return $lignes_achats;
    }

}