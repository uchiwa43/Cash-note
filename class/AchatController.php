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

        foreach ($_SESSION['achats'] as $achat)
        {
            //traitements spécifiques sur les cases
            $str_prix = $this->setColorForPrix($achat);
            $str_date_achat = $this->setColorForDateDAchat($achat);
            $str_site = $this->setLinkForSite($achat);

            //si moyen de payement ==liquide pas de date de débit
            $str_date_debit = ($achat['id_moyen_payement']==2)? '' : $achat['date_debit'] ;

            //créer une ligne pour un utilisateur
            $lignes_achats .= "
            <tr>
                <td><a href='achats_controller.php?id= ". $achat['id'] ."'>Modifier</a></td>
                <td>". $achat['libelle'] ."</td>
                <td>". $achat['categorie'] ."</td>
                <td>". $achat['etat'] ."</td>
                <td>". $str_prix ."</td>
                <td>". $achat['moyen_payement'] ."</td>
                <td>". $str_date_achat ."<br/>". $str_date_debit ."</td>
                <td>". $achat['lieu'] ."</td>
                <td>". $str_site ."</td>";
            $lignes_achats .= "
            </tr>";
        }
        return $lignes_achats;
    }

    /**
     * @param $achat
     * @return string
     */
    public function setColorForPrix($achat)
    {
        $str_prix = $achat['prix_achat_reel'] ."<br/>". $achat['prix_achat_prevu'];

        if($achat['prix_achat_prevu']!=null AND $achat['prix_achat_reel']!=null)
        {
            if ($achat['prix_achat_reel'] > $achat['prix_achat_prevu'])
            {
                $str_prix = "<span style = 'color: red'>".$str_prix."</span>";
            }
            if ($achat['prix_achat_reel'] < $achat['prix_achat_prevu'])
            {
                $str_prix = "<span style = 'color: green'>".$str_prix."</span>";
            }
        }
        return $str_prix;
    }

    /**
     * @param $achat
     * @return string
     */
    public function setColorForDateDAchat($achat)
    {
        $str_date_achat = $achat['date_achat_reelle'];

        //traitement spécifique sur la date d'achat
        if($achat['date_achat_reelle']!=null AND $achat['date_achat_prevue_debut']!=null AND $achat['date_achat_prevue_fin']!=null)
        {
            if($achat['date_achat_reelle'] < $achat['date_achat_prevue_debut'])
            {
                $str_date_achat = "<span style = 'color: green'>". $str_date_achat ."</span>";
            }
            if($achat['date_achat_reelle'] > $achat['date_achat_prevue_fin'])
            {
                $str_date_achat = "<span style = 'color: red'>". $str_date_achat ."</span>";
            }
        }
        return $str_date_achat;
    }

    /**
     * @param $achat
     * @return string
     */
    public function setLinkForSite($achat)
    {
        $str_site = $achat['site'];

        if(!is_null($achat['url_produit']))
        {
            $str_site = "<a href='".$achat['url_produit']."' target='_blank'>".$achat['site']."</a>";
        }
        else
        {
            if (!is_null($achat['url_site']))
            {
                $str_site = "<a href='".$achat['url_site']."' target='_blank'>".$achat['site']."</a>";
            }
        }
        return $str_site;
    }


    public function setTypes($types_categorie)
    {
        parent::setSelect($types_categorie,"Type","id_type_categorie","#types#",null );
    }

    public function setLieux($lieu )
    {
        parent::setSelect($lieu,"Lieu","id_lieu","#lieux#", null);
    }

    public function setCategories($categories)
    {
        parent::setSelect($categories,"Categorie","id_categorie","#categories#",null );
    }
}